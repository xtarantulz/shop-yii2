<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Створення менеджера');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Менеджери'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager-create">

    <?= $this->render('/user/_form', [
        'model' => $model,
    ]) ?>

</div>
