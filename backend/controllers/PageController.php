<?php

namespace backend\controllers;

use common\models\Page;
use common\models\search\PageSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;


class PageController extends Controller
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
                        'actions' => ['create', 'index', 'update', 'delete', 'selected'],
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

    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $search = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($search);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Page();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Сторінка була створена.'));
                    if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                    return $this->redirect(['index']);
                }

                if ($model->hasErrors()) {
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
            if ($model->load($post)) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Сторінка була оновлена.'));
                    if (isset($_POST['apply'])) return $this->redirect(['update', 'id' => $model->id]);
                    return $this->redirect(['index']);
                }

                if ($model->hasErrors()) {
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
        Yii::$app->session->setFlash('success', Yii::t('app', 'Сторінка була видалена.'));

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
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запитувана сторінка не існує.'));
    }
}