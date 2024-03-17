<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Category;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        $categories = Category::find()->where([
            'parent_id' => null
        ])->orderBy(['sort_order' => SORT_ASC])->all();

        return $this->render('index', [
            'categories' => $categories
        ]);
    }
}

