<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ManagerController extends Controller
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
                        'actions' => ['create', 'index', 'update', 'delete', 'status', 'selected'],
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
        $searchModel = new UserSearch();
        $search = Yii::$app->request->queryParams;
        $search['UserSearch']['role'] = User::ROLE_MANAGER;
        $dataProvider = $searchModel->search($search);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                $model->role = User::ROLE_MANAGER;
                if ($post['User']['password'] != '') $model->setPassword($post['User']['password']);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Менеджер був створений.'));
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
                if ($post['User']['password'] != '') $model->setPassword($post['User']['password']);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Менеджер був оновлений.'));
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

    public function actionStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->status == User::STATUS_ACTIVE) {
            $model->status = User::STATUS_DELETED;
            Yii::$app->session->setFlash('success', Yii::t('app', 'Менеджер був відключений.'));
        } else {
            $model->status = User::STATUS_ACTIVE;
            Yii::$app->session->setFlash('success', Yii::t('app', 'Менеджер був активований.'));
        }

        $model->save();

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('app', 'Менеджер був видалений.'));

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
        if (($model = User::findOne(['id' => $id, 'role' => User::ROLE_MANAGER])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запитувана сторінка не існує.'));
    }
}