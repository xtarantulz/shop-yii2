<?php
/* @var $this yii\web\View */
/* @var $model common\models\Map */
/* @var $pages array */

$this->title = Yii::t('app', 'Редагування пункта меню').': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пункти меню'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['index', 'MapSearch[id]' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Редагування');
?>
<div class="map-update">
    <?= $this->render('_form', [
        'model' => $model,
        'pages' => $pages
    ]) ?>
</div>
