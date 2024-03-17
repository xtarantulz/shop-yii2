<?php

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->seo_title;
?>
<div class="page-index">
    <h1><?= $model->name; ?></h1>
    <?= $model->content; ?>
</div>
