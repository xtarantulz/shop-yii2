<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Редагування менеджера: {full_name}', [
    'full_name' => $model->fullName,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Менеджери'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['index', 'UserSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="manager-update">

    <?= $this->render('/user/_form', [
        'model' => $model,
    ]) ?>

</div>
