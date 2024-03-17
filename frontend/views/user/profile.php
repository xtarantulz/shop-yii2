<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Профіль');
?>

<div class="user-profile">
    <h1><?= $this->title; ?></h1>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'profile-form',
            ]); ?>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                                'mask' => '+38 (099) 999-99-99',
                                'clientOptions' => [
                                    'removeMaskOnSubmit' => true,
                                ]
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-xs-12">
                            <?= $form->field($model, 'password')->textInput(['autocomplete' => 'off']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'photo_upload')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'initialPreview' => $model->photo ? $model->photo : false,
                            'initialPreviewAsData' => $model->photo ? true : false,
                            'initialPreviewShowDelete' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'showDrag' => false,
                            'showCaption' => false,
                            'showCancel' => false,
                            'showUploadedThumbs' => false,
                        ],
                    ]); ?>

                    <?= Html::button(Yii::t('app', 'Очистити'), [
                        'class' => 'btn btn-default btn-secondary',
                        'onClick' => '
                    $(this).prev().find("input[type=hidden]").val("delete");
                    $(this).prev().find(".fileinput-remove").click();
                ',
                        'style' => 'position:absolute; right:0px; z-index:1; margin-top: -43px;'
                    ]); ?>
                </div>
            </div>

            <?= Html::submitButton(Yii::t('app', 'Зберегти дані користувача'), ['class' => 'btn btn-success']); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
