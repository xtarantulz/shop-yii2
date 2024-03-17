<?php

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t('app', 'Створення товара');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
