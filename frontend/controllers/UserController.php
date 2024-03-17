<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\forms\LoginForm;
use common\models\forms\PasswordResetRequestForm;
use common\models\forms\SignupForm;
use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use common\models\ResetPasswordForm;
use common\models\search\OrderSearch;
use common\models\User;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile', 'orders', 'logout', 'ajax-order-info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'registration', 'reset-password', 'ajax-validate-login', 'ajax-validate-registration', 'ajax-validate-reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['confirm', 'reset'],
                        'allow' => true,
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
        ];
    }


    public function actionLogin()
    {
        $login_model = new LoginForm();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($login_model->load($post) && $login_model->login()) {
                return $this->goBack();
            }
        }

        $this->layout = null;
        return $this->renderAjax('login', [
            'login_model' => $login_model,
        ]);
    }

    //аякс акшен валидации формы входа
    public function actionAjaxValidateLogin()
    {
        $login_model = new LoginForm();
        if ($login_model) {
            if (Yii::$app->request->isAjax && $login_model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($login_model);
            }
        }

        return false;
    }

    public function actionRegistration()
    {
        $signup_model = new SignupForm();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($signup_model->load($post) && $user = $signup_model->signup()) {
                if ($user) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Перевірте вашу електронну пошту, щоб підтвердити реєстрацію.'));
                    $signup_model->sentEmailConfirm($user);
                    return $this->goBack();
                }
            }
        }

        return $this->renderAjax('registration', [
            'signup_model' => $signup_model,
        ]);
    }


    //аякс акшен валидации формы регистрации
    public function actionAjaxValidateRegistration()
    {
        $signup_model = new SignupForm();
        if ($signup_model) {
            if (Yii::$app->request->isAjax && $signup_model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($signup_model);
            }
        }

        return false;
    }

    public function actionResetPassword()
    {
        $reset_model = new PasswordResetRequestForm();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($reset_model->load($post) && $reset_model->validate()) {
                if ($reset_model->sendEmail()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Перевірте вашу електронну пошту для отримання подальших інструкцій.'));

                    return $this->goHome();
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'На жаль, ми не може скинути пароль для наданої адреси електронної пошти.'));
                }
            }
        }

        return $this->renderAjax('reset-password', [
            'reset_model' => $reset_model
        ]);
    }

    //аякс акшен валидации формы забылипароль
    public function actionAjaxValidateResetPassword()
    {
        $reset_model = new PasswordResetRequestForm();
        if ($reset_model) {
            if (Yii::$app->request->isAjax && $reset_model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($reset_model);
            }
        }

        return false;
    }

    public function actionReset($token)
    {
        $user = User::findOne(['password_reset_token' => $token]);

        if (!$user) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Токен скидання пароля не вірний.'));
            return $this->goHome();
        } else {
            $user->password_reset_token = null;
            $user->save(false);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Ви успішно увійшли, тепер можете поміняти свій пароль в профілі.'));
            Yii::$app->user->login($user, 3600 * 24 * 30);

            return $this->redirect(['user/profile']);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionConfirm($token)
    {
        $signup_model = new SignupForm();

        try {
            $signup_model->confirmation($token);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Ви успішно підтвердили свою реєстрацію і виконали вхід.'));
        } catch (\Exception $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->goHome();
    }


    public function actionProfile()
    {
        $model = Yii::$app->user->identity;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Ви успішно оновили профіль.'));
            }
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionOrders()
    {
        $searchModel = new OrderSearch();
        $search = Yii::$app->request->queryParams;
        $search['OrderSearch']['user_id'] = Yii::$app->user->getId();
        $dataProvider = $searchModel->search($search);

        return $this->render('orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clients' => User::getAllNames(User::ROLE_CLIENT)
        ]);
    }

    public function actionAjaxOrderInfo($id)
    {
        if (Yii::$app->request->isAjax) {
            $order = Order::findOne(['user_id' => Yii::$app->user->getId(), 'id' => $id]);
            if (!$order) throw new NotFoundHttpException('Запитувана сторінка не існує.');

            $products = Product::find()->select([
                "product_id" => Product::tableName() . ".id",
                "product_name" => Product::tableName() . ".name",
                "product_image" => Product::tableName() . ".image",
                "category_id" => Category::tableName() . ".id",
                "category_name" => Category::tableName() . ".name",
                "order_count" => OrderItem::tableName() . ".count",
                "product_price" => OrderItem::tableName() . ".price",
            ])->joinWith(['orderItems', 'category'])->where([
                OrderItem::tableName() . ".order_id" => $id
            ])->createCommand()->queryAll();

            $this->layout = false;
            return $this->render('_order-info', [
                'products' => $products,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}

