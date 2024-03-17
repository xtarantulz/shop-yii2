<?php

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('app', 'Редагування сторінки: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Сторінки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index', 'PageSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="page-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
