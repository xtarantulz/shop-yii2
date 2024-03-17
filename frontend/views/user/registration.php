<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $signup_model common\models\forms\SignupForm */
?>

<div class="user-registration">
    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'enableAjaxValidation' => true,
        'validationUrl' => Url::toRoute('user/ajax-validate-registration')
    ]); ?>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($signup_model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($signup_model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($signup_model, 'middle_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($signup_model, 'phone')->widget(MaskedInput::className(), [
                'mask' => '+38 (099) 999-99-99',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($signup_model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($signup_model, 'password')->textInput(['autocomplete' => 'off']); ?>
        </div>
    </div>

    <?= Html::submitButton(Yii::t('app', 'Зареєструватися'), ['class' => 'btn btn-success submit']) ?>

    <?php ActiveForm::end(); ?>
</div>

