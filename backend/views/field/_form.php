<?php
/* @var $model common\models\Field */

use common\models\Field;
use unclead\multipleinput\MultipleInput;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>

<div class="filed-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'type')->widget(Select2::classname(), [
                                'data' => Field::getLabels('type'),
                                'options' => [
                                    'placeholder' => Yii::t('app', 'Виберіть тип...'),
                                    'onchange' => '
                                        $(".field_type").addClass("hidden")
                                        $(".field_type_"+$(this).val()).removeClass("hidden")
                                       
                                    '
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]); ?>
                        </div>
                    </div>

                    <div class="field_type field_type_float field_type_integer <?= ($model->type == Field::TYPE_INTEGER || $model->type == Field::TYPE_FLOAT) ? '' : 'hidden'; ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'prefix')->textInput(['maxlength' => true]) ?>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'suffix')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="field_type field_type_float <?= ($model->type == Field::TYPE_FLOAT) ? '' : 'hidden'; ?>">
                        <?= $form->field($model, 'number_after_point')->textInput() ?>
                    </div>

                    <div class="field_type field_type_selection <?= ($model->type == Field::TYPE_SELECTION) ? '' : 'hidden'; ?>">
                        <?= $form->field($model, 'options')->widget(MultipleInput::className(), [
                            'addButtonPosition' => MultipleInput::POS_ROW
                        ]); ?>
                    </div>

                    <div class="field_type field_type_file <?= ($model->type == Field::TYPE_FILE) ? '' : 'hidden'; ?>">
                        <?= $form->field($model, 'fileExpansions')->widget(Select2::classname(), [
                            'data' => Field::getLabels('fileExpansions'),
                            'options' => [
                                'prompt' => Yii::t('app', 'Виберіть розширення...'),
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ]
                        ]); ?>
                    </div>

                    <div class="field_type field_type_image <?= ($model->type == Field::TYPE_IMAGE) ? '' : 'hidden'; ?>">
                        <?= $form->field($model, 'imageExpansions')->widget(Select2::classname(), [
                            'data' => Field::getLabels('imageExpansions'),
                            'options' => [
                                'multiple' => true,
                                'prompt' => Yii::t('app', 'Виберіть розширення...'),
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ]
                        ]); ?>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('/blocks/_save_apply_cancel') ?>

    <?php ActiveForm::end(); ?>
</div>