<?php

namespace frontend\controllers;

use common\models\Page;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actionIndex($slug)
    {
        $model = Page::findOne(['slug' => "page/" . $slug]);
        if (!$model) throw new NotFoundHttpException('Запитувана сторінка не існує.');

        Yii::$app->view->registerMetaTag([
            'title' => 'keywords',
            'content' => $model->seo_keywords
        ]);

        Yii::$app->view->registerMetaTag([
            'title' => 'description',
            'content' => $model->seo_description
        ]);

        return $this->render('index', [
            'model' => $model
        ]);
    }
}

