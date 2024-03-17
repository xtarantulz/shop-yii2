<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $products array */
/* @var $pages yii\data\Pagination */
/* @var $model common\models\Category */
?>

<div class="category-block">
    <div class="row">
        <?php if (count($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 block">
                    <?= $this->render('fields', [
                        'product' => $product,
                        'model' => $model
                    ]); ?>
                </div>
            <?php endforeach; ?>

            <div class="col-xs-12">
                <?= LinkPager::widget(['pagination' => $pages]); ?>
            </div>
        <?php else: ?>
            <div class="col-xs-12">
                <?= Yii::t('app', 'Товари не знайдені'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
