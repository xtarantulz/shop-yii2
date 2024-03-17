<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field common\models\Field */
/* @var $model common\models\ProductField */

?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'value[' . $field->id . ']', [
        'template' => "
            {label}\n
            {hint}\n
            <div class='input-group'>
                <span class='input-group-addon'>
                    ".$field->prefix."
                </span>
                {input}
                <span class='input-group-addon'>
                    ".$field->suffix."
                </span>
            </div>\n
            {error}
        "
    ])->textInput([
        'maxlength' => true,
        'value' => $model->value,
        'class' => 'float form-control',
        'data-floor' => 0
    ])->label($field->name); ?>
</div>

