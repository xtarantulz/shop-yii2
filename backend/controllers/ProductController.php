<?php

namespace backend\controllers;

use common\models\Field;
use common\models\Product;
use common\models\ProductField;
use common\models\search\ProductSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class ProductController extends Controller
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
                        'actions' => ['create', 'index', 'update', 'delete', 'selected', 'ajax-fields', 'ajax-info', 'ajax-price'],
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

    public function actionAjaxPrice($id)
    {
        if (Yii::$app->request->isAjax) {
            $product = Product::findOne($id);
            if(!$product) return 0;
            return $product->price;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionAjaxInfo($id)
    {
        if (Yii::$app->request->isAjax) {
            $fields = Field::find()->select([
                Field::tableName() . ".name",
                Field::tableName() . ".type",
                Field::tableName() . ".prefix",
                Field::tableName() . ".suffix",
                ProductField::tableName() . ".value"
            ])->joinWith('productFields')->where([
                ProductField::tableName() . ".product_id" => $id
            ])->createCommand()->queryAll();

            $this->layout = false;
            return $this->renderAjax('_info', [
                'fields' => $fields,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }


    //аякс акшен показа формы в зависимости от типа задания
    public function actionAjaxFields()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (isset($post['category_id']) && isset($post['product_id']) && isset($post['form_action'])) {
                return $this->renderAjax('_fields', [
                    'category_id' => $post['category_id'],
                    'product_id' => $post['product_id'],
                    'form_action' => $post['form_action'],
                ]);
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }


    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $search = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($search);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (isset($post['ProductField'])) {
                $transaction = Yii::$app->db->beginTransaction();
                if ($model->load($post) && $model->save()) {
                    //сохранение значений
                    $ids = [];
                    foreach ($post['ProductField'] as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $productField = ProductField::getModel($model->id, $key2);
                            if($value2) {
                                $data['ProductField'][$key] = $value2;
                                $productField->load($data);
                            }
                            $productField->uploadFile(); //загрузка файла если єто файл
                            if ($productField->save()) $ids[] = $productField->id;
                        }
                    }
                    if (count($ids) > 0) ProductField::deleteAll('id not in (' . implode(',', $ids) . ') and product_id = ' . $model->id);

                    if (!$model->hasErrors()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Товар був створен.'));
                        if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                        return $this->redirect(['index']);
                    }

                }

                if ($model->hasErrors()) {
                    $transaction->rollback();
                    foreach ($model->errors as $key => $value) {
                        Yii::$app->session->setFlash('error', $key . ": " . $value[0]);
                    }
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (isset($post['ProductField'])) {
                $transaction = Yii::$app->db->beginTransaction();
                if ($model->load($post) && $model->save()) {
                    //сохранение значений
                    $ids = [];
                    foreach ($post['ProductField'] as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $productField = ProductField::getModel($model->id, $key2);
                            if($value2) {
                                $data['ProductField'][$key] = $value2;
                                $productField->load($data);
                            }
                            $productField->uploadFile(); //загрузка файла если єто файл
                            if ($productField->save()) $ids[] = $productField->id;
                        }
                    }
                    if (count($ids) > 0) ProductField::deleteAll('id not in (' . implode(',', $ids) . ') and product_id = ' . $model->id);


                    if (!$model->hasErrors()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Товар був оновлен.'));
                        if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                        return $this->redirect(['index']);
                    }

                }

                if ($model->hasErrors()) {
                    $transaction->rollback();
                    foreach ($model->errors as $key => $value) {
                        Yii::$app->session->setFlash('error', $key . ": " . $value[0]);
                    }
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Товар був видален.'));

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
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запитувана сторінка не існує.'));
    }
}