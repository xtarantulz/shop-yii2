<?php
/* @var $model common\models\Page */

use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

?>

<div class="page-form">
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
                        </div>
                    </div>

                    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                        'editorOptions' => [
                            'preset' => 'standard',
                            'inline' => false,
                        ],
                    ]); ?>
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