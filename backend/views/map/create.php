<?php
/* @var $this yii\web\View */
/* @var $model common\models\Map */
/* @var $pages array */

if($model->parent_id){
    $this->title = 'Створення під-меню: '. $model->parent->name;
}else{
    $this->title = 'Створення пункта меню';
}

$this->params['breadcrumbs'][] = ['label' => 'Пункти меню', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="map-create">
    <?= $this->render('_form', [
        'model' => $model,
        'pages' => $pages
    ]) ?>
</div>
