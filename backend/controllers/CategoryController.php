<?php

namespace backend\controllers;

use common\models\Category;
use common\models\CategoryField;
use common\models\Field;
use common\models\search\CategorySearch;
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'update', 'delete', 'selected', 'list', 'ajax-info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'selected' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAjaxInfo($id)
    {
        if (Yii::$app->request->isAjax) {
            $fields = Field::find()->select([
                Field::tableName() . ".name",
                Field::tableName() . ".type",
                CategoryField::tableName() . ".list",
                CategoryField::tableName() . ".filter"
            ])->joinWith('categoryFields')->where([
                CategoryField::tableName() . ".category_id" => $id
            ])->createCommand()->queryAll();

            $this->layout = false;
            return $this->renderAjax('_info', [
                'fields' => $fields,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionList()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionIndex($id = 1)
    {
        $categories = Category::getTree();
        $model = new Category();
        $formName = $model->formName();

        return $this->render('index', [
            'categories' => $categories,
            'id' => $id,
            'formName' => $formName,
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $model = new Category();
        $model->parent_id = $parent_id;

        $categoryFields = [];

        $fields = ArrayHelper::map(
            Field::find()->select([
                'id', 'name'
            ])->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            'name'
        );

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!Yii::$app->request->isAjax) {
                if ($model->load($post)) {
                    $transaction = Yii::$app->db->beginTransaction();
                    if ($model->save()) {
                        $categoryFields = $model->saveFields($post);

                        if (!$model->hasErrors()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', Yii::t('app', 'Категорія була створена.'));
                            if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                            return $this->redirect(['index']);
                        }
                    } else {
                        $categoryFields = $model->saveFields($post);
                    }

                    $transaction->rollback();
                }
            } else {
                //если аяксом идет сохранение
                if ($model->load($post) && $model->save()) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        //если пусто, то достать какие есть поля
        if (count($categoryFields) == 0) {
            if ($model->categoryFields) {
                $categoryFields = $model->categoryFields;
            } else {
                $categoryFields = [new CategoryField()];
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categoryFields' => $categoryFields,
            'fields' => $fields
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categoryFields = [];

        $fields = ArrayHelper::map(
            Field::find()->select([
                'id', 'name'
            ])->orderBy(['name' => SORT_ASC])->asArray()->all(),
            'id',
            'name'
        );

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!Yii::$app->request->isAjax) {
                if ($model->load($post)) {
                    $transaction = Yii::$app->db->beginTransaction();
                    if ($model->save()) {
                        $categoryFields = $model->saveFields($post);

                        if (!$model->hasErrors()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', Yii::t('app', 'Категорія була оновлена.'));
                            if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                            return $this->redirect(['index']);
                        }
                    } else {
                        $categoryFields = $model->saveFields($post);
                    }

                    $transaction->rollback();
                }
            } else {
                //если аяксом идет сохранение
                if ($model->load($post) && $model->save()) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        //если пусто, то достать какие есть поля
        if (count($categoryFields) == 0) {
            if ($model->categoryFields) {
                $categoryFields = $model->categoryFields;
            } else {
                $categoryFields = [new CategoryField()];
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categoryFields' => $categoryFields,
            'fields' => $fields
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Категорія була видалена.'));
        return $this->redirect(['index']);
    }

    public function actionSelected()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            if (!empty($post['keys'])) {
                for ($i = 0; $i < count($post['keys']); $i = $i + 1) {
                    $model = $this->findModel($post['keys'][$i]);
                    if ($model) $model->delete();
                }
            }
        }

        return $this->redirect(['list']);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запитувана сторінка не існує.');
        }
    }
}
