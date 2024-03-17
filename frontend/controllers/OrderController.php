<?php

namespace backend\controllers;

use common\models\Category;
use common\models\OrderItem;
use common\models\Product;
use common\models\User;
use Yii;
use common\models\Order;
use common\models\search\OrderSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'ajax-info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'selected' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAjaxInfo($id)
    {
        if (Yii::$app->request->isAjax) {
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
            return $this->render('_info', [
                'products' => $products,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'clients' => User::getAllNames(User::ROLE_CLIENT)
        ]);
    }

    public function actionCreate()
    {
        $model = new Order();
        $orderItems = [];

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                $transaction = Yii::$app->db->beginTransaction();
                if ($model->save()) {
                    $orderItems = $model->saveItems($post);

                    if (!$model->hasErrors()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Замовлення було створено.'));
                        if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                        return $this->redirect(['index']);
                    }
                } else {
                    $orderItems = $model->saveItems($post);
                }

                $transaction->rollback();
            }
        }

        //если пусто, то достать какие есть вложения
        if (count($orderItems) == 0) {
            if ($model->orderItems) {
                $orderItems = $model->orderItems;
            } else {
                $orderItems = [new OrderItem()];
            }
        }

        return $this->render('create', [
            'model' => $model,
            'orderItems' => $orderItems,
            'products' => Product::getAllNames(),
            'clients' => User::getAllNames(User::ROLE_CLIENT)
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $orderItems = [];

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                $transaction = Yii::$app->db->beginTransaction();
                if ($model->save()) {
                    $orderItems = $model->saveItems($post);

                    if (!$model->hasErrors()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Замовлення було оновлено.'));
                        if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                        return $this->redirect(['index']);
                    }
                } else {
                    $orderItems = $model->saveItems($post);
                }

                $transaction->rollback();
            }
        }

        //если пусто, то достать какие есть вложения
        if (count($orderItems) == 0) {
            if ($model->orderItems) {
                $orderItems = $model->orderItems;
            } else {
                $orderItems = [new OrderItem()];
            }
        }

        return $this->render('update', [
            'model' => $model,
            'orderItems' => $orderItems,
            'products' => Product::getAllNames(),
            'clients' => User::getAllNames(User::ROLE_CLIENT)
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Замовлення було видалено.'));

        return $this->redirect(['index']);
    }

    public function actionSelected()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            if (isset($post['keys']) && is_array($post['keys']) && count($post['keys'])) {
                foreach ($post['keys'] as $key) {
                    $model = $this->findModel($key);
                    $model->delete();
                }
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запитувана сторінка не існує.'));
    }
}
