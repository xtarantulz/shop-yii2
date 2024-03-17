<?php

use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $reset_model common\models\forms\ResetPasswordForm */

?>

<div class="user-reset-password">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute('user/ajax-validate-reset-password')
    ]); ?>

    <?= $form->field($reset_model, 'email')->input('email', ['placeholder' => Yii::t('app', 'Ведіть Ваш e-mail')]); ?>

    <?= Html::submitButton(Yii::t('app', 'Скинути пароль'), ['class' => 'btn btn-success submit']) ?>

    <?php ActiveForm::end(); ?>
</div>
