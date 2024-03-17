<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Створення клієнта');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Клієнти'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <?= $this->render('/user/_form', [
        'model' => $model,
    ]) ?>

</div>
