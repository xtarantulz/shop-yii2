<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Field;
use yii\widgets\LinkPager;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $products array */
/* @var $fields array */
/* @var $search common\models\ProductField[] */
/* @var $pages yii\data\Pagination */

$this->title = $model->name;
?>
<div class="category-index">
    <h1><?= $model->name; ?></h1>
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
            <div class="filters">
                <?= $this->render('filters', [
                    'fields' => $fields,
                    'search' => $search,
                    'model' => $model
                ]); ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
            <?= $this->render('template/_block', [
                'fields' => $fields,
                'products' => $products,
                'pages' => $pages,
                'model' => $model
            ]); ?>
        </div>
    </div>
</div>
