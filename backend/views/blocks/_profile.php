<?php

use common\models\User;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $disabled string */

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="panel panel-default">
        <div class="panel-body">
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
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'password')->label($model->isNewRecord ? Yii::t('app', 'Password') : Yii::t('app', 'Enter a new password'))->textInput(['autocomplete' => 'off']); ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'status')->widget(Select2::classname(), [
                        'data' => User::getLabels('status'),
                        'options' => [
                            'disabled' => $disabled,
                            'prompt' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
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
        </div>
    </div>
<?= $this->render('/blocks/_save_apply_cancel') ?>

<?php ActiveForm::end(); ?>