<?php

namespace backend\controllers;

use common\models\Config;
use common\models\forms\ResetPasswordForm;
use common\models\Product;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\forms\LoginForm;
use common\models\forms\PasswordResetRequestForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['reset'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['error', 'logout', 'index', 'profile', 'config', 'file', 'info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionInfo()
    {
        phpinfo();
    }

    public function actionFile()
    {
        return $this->render('file');
    }

    public function actionConfig()
    {
        $model = Config::findOne(1);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Настройки були оновлені.'));
                return $this->redirect(['config']);
            } else {
                if ($model->hasErrors()) {
                    foreach ($model->errors as $key => $value) {
                        Yii::$app->session->setFlash('error', $key . ": " . $value[0]);
                    }
                }
            }
        }

        return $this->render('config', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $model = User::findOne(Yii::$app->user->getId());
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                if ($post['User']['password'] != '') $model->setPassword($post['User']['password']);

                if ($model->validate() && $model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Дані профілю успішно змінені.'));
                    if (isset($_POST['apply'])) return $this->redirect(['profile']);

                    return $this->goHome();
                }
            }
        }
        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $this->redirect(['map/index']);
    }


    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $login_model = new LoginForm();
        $reset_model = new PasswordResetRequestForm();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            //авторизация
            if (isset($post['LoginForm'])) {
                if ($login_model->load($post) && $login_model->login()) {
                    return $this->goBack();
                }
            }

            //забыли пароль
            if (isset($post['PasswordResetRequestForm'])) {
                if ($reset_model->load($post) && $reset_model->validate()) {
                    if ($reset_model->sendEmail()) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Перевірте вашу електронну пошту для отримання подальших інструкцій.'));

                        return $this->goHome();
                    } else {
                        Yii::$app->session->setFlash('error', Yii::t('app', 'На жаль, ми не може скинути пароль для наданого адреси електронної пошти.'));
                    }
                }
            }
        }

        $login_model->password = '';

        if ($login_model->load(Yii::$app->request->post()) && $login_model->login()) {
            return $this->goBack();
        } else {
            $login_model->password = '';

            return $this->render('login', [
                'login_model' => $login_model,
                'reset_model' => $reset_model
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionReset($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Новий пароль збережений.'));

            return $this->goHome();
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }
}

