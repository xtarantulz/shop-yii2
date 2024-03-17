<?php
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Профіль');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-profile">
    <?= $this->render('/blocks/_profile', [
        'model' => $model,
        'disabled' => true
    ]) ?>
</div>