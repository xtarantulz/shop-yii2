<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categoryFields common\models\CategoryField[] */
/* @var $fields array */

$this->title = Yii::t('app', 'Редагування категорії').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Категорії'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index', 'CategorySearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="category-update">
    <?= $this->render('_form', [
        'model' => $model,
        'categoryFields' => $categoryFields,
        'fields' => $fields
    ]) ?>
</div>
