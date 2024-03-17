<?php

use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\TabularColumn;
use unclead\multipleinput\TabularInput;
use yii\web\View;
use yii\widgets\ActiveForm;
use common\models\Category;
use kartik\select2\Select2;
use dosamigos\selectize\SelectizeDropDownList;
use yii\web\JsExpression;
use common\models\CategoryField;
use kartik\file\FileInput;
use yii\helpers\Html;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
/* @var $categoryFields common\models\CategoryField[] */
/* @var $fields array */

$categories = Category::forSelectTree();
if ($model->id) unset($categories[$model->id]);
?>

    <div class="category-form">
        <?php $form = ActiveForm::begin(); ?>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#main"><?= Yii::t('app', 'Основне') ?></a></li>
            <li><a data-toggle="tab" href="#seo"><?= Yii::t('app', 'SEO налаштування') ?></a></li>
        </ul>

        <div class="tab-content">
            <div id="main" class="tab-pane fade in active">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, "parent_id")->widget(Select2::className(), [
                                    'data' => $categories,
                                    'options' => [
                                        'prompt' => Yii::t('app', 'Виберіть категорію...')
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                            ]
                        ]); ?>

                        <div class="panel panel-default">
                            <div class="panel-heading"><?= Yii::t('app', 'Поля'); ?></div>
                            <div class="panel-body" id="category_fields">
                                <?= TabularInput::widget([
                                    'min' => 0,
                                    'models' => $categoryFields,
                                    'form' => $form,
                                    'attributeOptions' => [
                                        'enableClientValidation' => true,
                                        'validateOnChange' => true,
                                        'validateOnSubmit' => true,
                                        'validateOnBlur' => true,
                                    ],
                                    'addButtonPosition' => MultipleInput::POS_FOOTER,
                                    'columns' => [
                                        [
                                            'name' => 'id',
                                            'type' => TabularColumn::TYPE_HIDDEN_INPUT,
                                        ],

                                        [
                                            'name' => 'field_id',
                                            'enableError' => true,
                                            'type' => SelectizeDropDownList::className(),
                                            'options' => [
                                                'clientOptions' => [
                                                    'render' => [
                                                        'option' => new JsExpression("
                                                            function(item, escape) {
                                                                return renderSelectOptions(item, $('.list-cell__field_id'));
                                                            }
                                                        ")
                                                    ]
                                                ],
                                                'items' => $fields,
                                                'options' => [
                                                    'prompt' => Yii::t('app', 'Виберіть поле...'),
                                                    'class' => 'form-control',
                                                            'onchange' => "
                                                        refreshSelectOptions($('.list-cell__field_id'));
                                                    "
                                                ]
                                            ],
                                            'title' => Yii::t('app', 'Поле'),
                                        ],

                                        [
                                            'name' => 'depth',
                                            'title' => Yii::t('app', 'Вага'),
                                            'headerOptions' => ['width' => '50'],
                                        ],

                                        [
                                            'name' => 'list',
                                            'type' => 'dropDownList',
                                            'items' => CategoryField::getLabels('list'),
                                            'title' => Yii::t('app', 'Показувати в списку?'),
                                            'headerOptions' => ['width' => '200'],
                                        ],

                                        [
                                            'name' => 'filter',
                                            'type' => 'dropDownList',
                                            'items' => CategoryField::getLabels('filter'),
                                            'title' => Yii::t('app', 'Фільтрувати?'),
                                            'headerOptions' => ['width' => '200'],
                                        ],
                                    ],
                                ]) ?>
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
                                <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->render('/blocks/_save_apply_cancel') ?>

        <?php ActiveForm::end(); ?>
    </div>

<?php
$script = <<< JS
    $('#category_fields>div').on('afterDeleteRow', function(e, row) {
        refreshSelectOptions($('.list-cell__field_id'));
    });
JS;
$this->registerJs($script, View::POS_READY);
?>