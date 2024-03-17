<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
{
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
                        'matchCallback' => function ($rule, $action) {
                            return User::canAction(Yii::$app->request->get(), $action->id);
                        }
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
        $search['UserSearch']['role'] = User::ROLE_ADMIN;
        $dataProvider = $searchModel->search($search);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                $model->role = User::ROLE_ADMIN;
                if ($post['User']['password'] != '') $model->setPassword($post['User']['password']);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Адміністратор був створений.'));
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

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if ($model->load($post)) {
                $model->role = User::ROLE_ADMIN;
                if ($post['User']['password'] != '') $model->setPassword($post['User']['password']);
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Адміністратор був оновлений.'));
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
        if ($id != Yii::$app->user->getId()) {
            $model = $this->findModel($id);

            if ($model->status == User::STATUS_ACTIVE) {
                $model->status = User::STATUS_DELETED;
                Yii::$app->session->setFlash('success', Yii::t('app', 'Адміністратор був відключений.'));
            } else {
                $model->status = User::STATUS_ACTIVE;
                Yii::$app->session->setFlash('success', Yii::t('app', 'Адміністратор був активований.'));
            }

            $model->save();
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ви не можете змінити статус самостійно.'));
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        if ($id != Yii::$app->user->getId()) {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', Yii::t('app', 'Адміністратор був видалений.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ви не можете видаляти самостійно.'));
        }

        return $this->redirect(['index']);
    }

    public function actionSelected()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            if (isset($post['keys']) && is_array($post['keys']) && count($post['keys'])) {
                foreach ($post['keys'] as $key) {
                    $model = $this->findModel($key);
                    if ($model->id != Yii::$app->user->getId()) {
                        $model->delete();
                    }
                }
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id, 'role' => User::ROLE_ADMIN])) !== null) {
            return $model;
        }


        throw new NotFoundHttpException(Yii::t('app', 'Запитувана сторінка не існує.'));
    }
}