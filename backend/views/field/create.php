<?php

/* @var $this yii\web\View */
/* @var $model common\models\Field */

$this->title = Yii::t('app', 'Створення поля');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Поля'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filed-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
