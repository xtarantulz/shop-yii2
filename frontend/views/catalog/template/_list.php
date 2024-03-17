<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $products array */
/* @var $model common\models\Category */
/* @var $pages yii\data\Pagination */

?>

<div class="category-list">
    <?php if (count($products)): ?>
        <?php foreach ($products as $product): ?>
            <?= $this->render('fields', [
                'product' => $product,
                'model' => $model
            ]); ?>
        <?php endforeach; ?>

        <?= LinkPager::widget(['pagination' => $pages]); ?>
    <?php else: ?>
        <?= Yii::t('app', 'Товари не знайдені'); ?>
    <?php endif; ?>
</div>
