<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field array */
/* @var $model common\models\forms\FilterForm */

echo $form->field($model, 'value[' . $field['id'] . ']')->textInput([
    'maxlength' => true,
    'value' => $model->value
])->label($field["name"]);


