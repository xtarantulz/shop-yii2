<?php

use kartik\select2\Select2;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field array */
/* @var $model common\models\forms\FilterForm */

$field["options"] = Json::decode($field["options"], true);
$options = [];
foreach ($field["options"] as $option) {
    $options[$option] = $option;
}

echo $form->field($model, 'value[' . $field["id"] . ']')->label($field["name"])->widget(Select2::classname(), [
    'data' => $options,
    'options' => [
        'prompt' => Yii::t('app', 'Виберіть значення...'),
        'value' => $model->value,
    ],
    'pluginOptions' => [
        'allowClear' => true
    ]
]);


