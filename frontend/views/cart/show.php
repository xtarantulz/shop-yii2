<?php

use yii\helpers\Html;
use common\models\core\Functional;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $cart array */
/* @var $order common\models\Order */


$this->title = Yii::t('app', 'Кошик');
?>

<div class="cart-show">
    <h1><?= $this->title; ?></h1>

    <?php if (!count($cart)): ?>
        <div class="alert alert-warning" role="alert">
            <?= Yii::t('app', 'Ваш кошик пуст!'); ?>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'ID'); ?></th>
                    <th class="text-center" style="width: 80px;"><?= Yii::t('app', 'Зображення'); ?></th>
                    <th><?= Yii::t('app', 'Товар'); ?></th>
                    <th><?= Yii::t('app', 'Категорія'); ?></th>
                    <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'Кількість'); ?></th>
                    <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'Цена'); ?></th>
                    <th class="text-center" style="width: 10px;"><?= Yii::t('app', 'Сума'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cart as $item): ?>
                    <?php if ($item['product']): ?>
                        <tr>
                            <td class="text-center"><?= $item['product']['id']; ?></td>
                            <td class="text-center"><?= Html::a(Html::img(Functional::getMiniImage($item['product']['image']), [
                                    'style' => 'width:80px;'
                                ]), $item['product']['image'], [
                                    'rel' => 'fancybox',
                                ]); ?>
                            </td>
                            <td>
                                <?= Html::a($item['product']['name'], $item['product']['url'], [
                                    'target' => '_blank'
                                ]); ?>
                            </td>
                            <td>
                                <?= Html::a($item['product']['category']['name'], $item['product']['category']['url'], [
                                    'target' => '_blank'
                                ]); ?>
                            </td>
                            <td class="text-center">
                                <?= $item['count']; ?>
                            </td>
                            <td class="text-center">
                                <?= $item['product']['price']; ?>
                            </td>
                            <td class="text-center">
                                <?= Functional::floorDecimal($item['count'] * $item['product']['price'], 2); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>

                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">
                        <b><?= Yii::t('app', 'Разом'); ?>:</b>&nbsp;<?= Functional::floorDecimal($order->total, 2); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <?php $form = ActiveForm::begin(); ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($order, 'last_name')->textInput(['maxlength' => true]); ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($order, 'first_name')->textInput(['maxlength' => true]); ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($order, 'middle_name')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($order, 'phone')->widget(MaskedInput::className(), [
                            'mask' => '+38 (099) 999-99-99',
                            'clientOptions' => [
                                'removeMaskOnSubmit' => true,
                            ]
                        ]); ?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?= $form->field($order, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <?= Html::a(Yii::t('app', 'Очистити кошик'), Url::to(['cart/clear']), ['class' => 'btn btn-warning pull-left']); ?>
                <?= Html::submitButton(Yii::t('app', 'Оформити заказ'), ['class' => 'btn btn-success pull-right']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>