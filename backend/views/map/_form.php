<?php

use yii\widgets\ActiveForm;
use common\models\Map;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Map */
/* @var $form yii\widgets\ActiveForm */
/* @var $pages array */

$maps = Map::forSelectTree();
if($model->id) unset($maps[$model->id]);
?>

<div class="map-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, "parent_id")->widget(Select2::className(), [
                        'data' => $maps,
                        'options' => [
                            'class' => 'form-control',
                            'prompt' => Yii::t('app', 'Виберіть пунк меню...')
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, "page_id")->widget(Select2::className(), [
                        'data' => [Yii::t('app', 'За замовчуванням - контролер і дія')] + $pages,
                        'options' => [
                            'class' => 'form-control',
                            'prompt' => Yii::t('app', 'За замовчуванням - контролер і дія'),
                            'onchange' => "
                                if($(this).val() !== '0'){
                                    $('.controller-and-action input').prop('disabled', true);
                                }else{
                                    $('.controller-and-action input').prop('disabled', false);
                                }
                            "
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>

                    <div class="row controller-and-action">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'controller')->textInput([
                                'maxlength' => true,
                                'disabled' => ($model->page_id)? true : false
                            ]) ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'action')->textInput([
                                'maxlength' => true,
                                'disabled' => ($model->page_id)? true : false
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('/blocks/_save_apply_cancel') ?>

    <?php ActiveForm::end(); ?>
</div>