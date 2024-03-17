<?php
/* @var $model common\models\Product */

use common\models\Category;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Html;
use mihaildev\elfinder\InputFile;
use mihaildev\ckeditor\CKEditor;
use yii\web\View;
use xtarantulz\preview\PreviewAsset;
PreviewAsset::register($this);

$form_id = 'form-product-fields';
?>

<div class="product-form">
    <?php $form = ActiveForm::begin(['id' => 'product-form']); ?>
    <input type="hidden" id="product_id" value="<?= ($model->id) ? $model->id : 0 ?>">
    <input type="hidden" id="form_action" value="<?= Url::to(); ?>">
    <?php ActiveForm::end(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#main"><?= Yii::t('app', 'Основне') ?></a></li>
        <li><a data-toggle="tab" href="#fields"><?= Yii::t('app', 'Характеристики') ?></a></li>
        <li><a data-toggle="tab" href="#seo"><?= Yii::t('app', 'SEO налаштування') ?></a></li>
    </ul>

    <div class="tab-content">
        <div id="main" class="tab-pane fade in active">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'name')->textInput([
                                'maxlength' => true,
                                'form' => $form_id
                            ]) ?>

                            <?= $form->field($model, 'price')->textInput([
                                'maxlength' => true,
                                'value' => $model->value,
                                'class' => 'float form-control',
                                'data-floor' => 2,
                                'form' => $form_id,
                            ]); ?>

                            <?= $form->field($model, 'images')->widget(InputFile::className(), [
                                'path' => 'product/images',
                                'language' => Yii::$app->language,
                                'controller' => 'elfinder',
                                'filter' => 'image',
                                'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'options' => ['class' => 'form-control img', 'readonly' => true, 'form' => $form_id],
                                'buttonOptions' => ['class' => 'btn btn-success'],
                                'multiple' => true
                            ]); ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                                'data' => Category::forSelectTree(),
                                'options' => [
                                    'form' => $form_id,
                                    'prompt' => Yii::t('app', 'Виберіть категорію...'),
                                    'onchange' => "
                                        $.post('" . Url::to(['product/ajax-fields']) . "', {
                                            category_id: $(this).val(),
                                            product_id: $('#product_id').val(),
                                            form_action: $('#form_action').val()
                                        }, function(data) {
                                           if(data !== '') $('.ajax-additional-fields').html(data);
                                        });
                                    "
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]); ?>

                            <?= $form->field($model, 'image_upload')->widget(FileInput::classname(), [
                                'options' => [
                                    'accept' => 'image/*',
                                ],
                                'pluginOptions' => [
                                    'initialPreview' => $model->image ? $model->image : false,
                                    'initialPreviewAsData' => $model->image ? true : false,
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

                    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                        'options' => [
                            'form' => $form_id,
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
        <div id="fields" class="tab-pane fade">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="ajax-additional-fields">
                            <?php if ($model->category_id) {
                                echo $this->render('_fields', [
                                    'category_id' => $model->category_id,
                                    'product_id' => $model->id,
                                    'form_action' => Url::to()
                                ]);
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="seo" class="tab-pane fade">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'seo_title')->textInput([
                                'maxlength' => true,
                                'form' => $form_id,
                            ]) ?>

                            <?= $form->field($model, 'seo_keywords')->textInput([
                                'maxlength' => true,
                                'form' => $form_id,
                            ]) ?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'seo_description')->textarea([
                                'rows' => 6,
                                'form' => $form_id,
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('/blocks/_save_apply_cancel', [
        'form_id' => $form_id
    ]) ?>
</div>

<?php
$script = <<< JS
    $('#product-image_upload').attr({'form': 'form-product-fields'});
JS;
$this->registerJs($script, View::POS_READY);
?>
