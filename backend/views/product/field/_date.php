<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field common\models\Field */

/* @var $model common\models\ProductField */

use kartik\date\DatePicker;
?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'value[' . $field->id . ']')->label($field->name)->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_INPUT,
        'options' => [
            'placeholder' => Yii::t('app', 'Введіть дату...'),
            'value' => $model->value,
        ],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true,
        ]
    ]); ?>
</div>

