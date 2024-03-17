<?php
/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categoryFields common\models\CategoryField[] */
/* @var $fields array */

if($model->parent_id){
    $this->title = 'Створення під-категорії: '. $model->parent->name;
}else{
    $this->title = 'Створення категорії';
}

$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categoryFields' => $categoryFields,
        'fields' => $fields
    ]) ?>
</div>
