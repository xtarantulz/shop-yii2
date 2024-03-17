<?php
/* @var $model common\models\User */
?>

<div class="user-form">
    <?= $this->render('/blocks/_profile', [
        'model' => $model,
        'disabled' => false
    ]) ?>
</div>