<?php

use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field array */
/* @var $model common\models\forms\FilterForm */
?>

<fieldset>
    <legend><?= $field['name']; ?></legend>
    <div class="row">
        <div class="col-xs-6 col">
            <?= $form->field($model, 'from[' . $field['id'] . ']')->widget(DatePicker::classname(), [
                'pickerIcon' => false,
                'removeButton' => false,
                'options' => [
                    'placeholder' => Yii::t('app', 'Виберіть дати...'),
                    'value' => $model->from,
                ],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true,
                ]
            ])->label(Yii::t('app', 'від')); ?>
        </div>
        <div class="col-xs-6 col">
            <?= $form->field($model, 'to[' . $field['id'] . ']')->widget(DatePicker::classname(), [
                'pickerIcon' => false,
                'removeButton' => false,
                'options' => [
                    'placeholder' => Yii::t('app', 'Виберіть дату...'),
                    'value' => $model->to,
                ],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true,
                ]
            ])->label(Yii::t('app', 'до')); ?>
        </div>
    </div>



