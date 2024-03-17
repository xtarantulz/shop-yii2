<?php

/* @var $this yii\web\View */
/* @var $model common\models\Field */

$this->title = Yii::t('app', 'Редагування поля: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Поля'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index', 'FieldSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="filed-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
