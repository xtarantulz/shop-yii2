<?php

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('app', 'Створення сторінки');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Сторінки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
