<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field common\models\Field */
/* @var $model common\models\ProductField */

?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'value[' . $field->id . ']')->textarea([
        'value' => $model->value,
        'class' => 'float form-control',
    ])->label($field->name); ?>
</div>

