<?php
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $field common\models\Field */
/* @var $model common\models\ProductField */

?>

<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?= $form->field($model, 'image_upload['.$field->id.']')->widget(FileInput::classname(), [
        'options'=>[
            'accept'=>'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => $model->value ? $model->value : false,
            'initialPreviewAsData' => $model->value ? true : false,
            'initialPreviewShowDelete' => false,
            'showRemove' => false,
            'showUpload' => false,
            'showDrag' => false,
            'showCaption' => false,
            'showCancel' => false,
            'showUploadedThumbs' => false,
            'allowedFileExtensions'=> $field->expansions,
        ],
    ])->label($field->name); ?>
</div>

