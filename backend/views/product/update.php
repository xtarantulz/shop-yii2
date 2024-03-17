<?php

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $regions array */
/* @var $points array */

$this->title = Yii::t('app', 'Редагування товара: {id}', [
    'id' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Товари'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index', 'ProductSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>

<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
        'regions' => $regions,
        'points' => $points
    ]) ?>
</div>
