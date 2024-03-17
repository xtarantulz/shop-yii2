<?php

namespace backend\controllers;

use common\models\Map;
use common\models\Page;
use common\models\search\MapSearch;
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class MapController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'update', 'delete', 'selected', 'list'],
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

    public function actionList()
    {
        $searchModel = new MapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => Page::getAllTitles()
        ]);
    }


    public function actionIndex($id = 1)
    {
        $maps = Map::getTree();
        $model = new Map();
        $formName = $model->formName();

        return $this->render('index', [
            'maps' => $maps,
            'id' => $id,
            'formName' => $formName,
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $model = new Map();
        $model->parent_id = $parent_id;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!Yii::$app->request->isAjax) {
                if ($model->load($post) && $model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Пункт меню був створен.'));
                    if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                    return $this->redirect(['index']);
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

        return $this->render('create', [
            'model' => $model,
            'pages' => Page::getAllTitles()
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (!Yii::$app->request->isAjax) {
                if ($model->load($post) && $model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Пункт меню був оновлен.'));
                    if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                    return $this->redirect(['index']);
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

        return $this->render('update', [
            'model' => $model,
            'pages' => Page::getAllTitles()
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Пунк меню був видалений.'));
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
        if (($model = Map::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запитувана сторінка не існує.');
        }
    }
}
