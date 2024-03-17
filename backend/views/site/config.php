<?php

use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use xtarantulz\preview\PreviewAsset;
PreviewAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Config */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Налаштування');
?>

<div class="site-config">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'h1_main_page')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'slider_main_page')->widget(InputFile::className(), [
                        'path'          => 'config/slider',
                        'language'      => Yii::$app->language,
                        'controller'    => 'elfinder',
                        'filter'        => 'image',
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control img', 'readonly' => true],
                        'buttonOptions' => ['class' => 'btn btn-success'],
                        'multiple'      => true
                    ]);?>

                    <?= $form->field($model, 'footer_description')->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('/blocks/_save_apply_cancel') ?>

    <?php ActiveForm::end(); ?>
</div>
