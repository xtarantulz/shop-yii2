<?php

use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $login_model common\models\forms\LoginForm */

?>

<div class="user-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute('user/ajax-validate-login')
    ]); ?>

    <?= $form->field($login_model, 'email')->input('email', ['placeholder' => Yii::t('app', 'Ведіть Ваш e-mail')]); ?>

    <?= $form->field($login_model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Ведіть Ваш пароль')]); ?>

    <?= $form->field($login_model, 'rememberMe')->widget(Switchery::className())->label(false); ?>

    <?= Html::submitButton(Yii::t('app', 'Увійти'), ['class' => 'btn btn-success submit']) ?>

    <?php ActiveForm::end(); ?>
</div>
