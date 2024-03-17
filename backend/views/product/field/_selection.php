<?php

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field common\models\Field */
/* @var $model common\models\ProductField */

$options = [];
foreach ($field->options as $option) {
    $options[$option] = $option;
}

?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'value[' . $field->id . ']')->label($field->name)->widget(Select2::classname(), [
        'data' => $options,
        'options' => [
            'prompt' => Yii::t('app', 'Виберіть значення...'),
            'value' => $model->value,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]); ?>
</div>

