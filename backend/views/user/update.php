<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Редагування адміністратора: {full_name}', [
    'full_name' => $model->fullName,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Адміністратори'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['index', 'UserSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
