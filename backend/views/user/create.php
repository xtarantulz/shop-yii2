<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Створення адміністратора');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Адміністратори'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
