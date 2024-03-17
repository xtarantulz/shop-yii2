<?php

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use common\models\Order;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\TabularColumn;
use dosamigos\selectize\SelectizeDropDownList;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
/* @var $products array */
/* @var $clients array */
/* @var $orderItems common\models\OrderItem[] */
?>

<div class="order-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, "user_id")->widget(Select2::className(), [
                        'data' => $clients,
                        'options' => [
                            'prompt' => Yii::t('app', 'Виберіть клієнта...'),
                            'onchange' => "
                                $.get('" . Url::to(['client/ajax-info']) . "', {id: $(this).val()}, function(client) {
                                    client = JSON.parse(client);
                                    $('#order-email').val(client.email);
                                    $('#order-phone').val(client.phone);
                                    $('#order-last_name').val(client.last_name);
                                    $('#order-first_name').val(client.first_name);
                                    $('#order-middle_name').val(client.middle_name);
                                });
                            "
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                        'mask' => '+38 (099) 999-99-99',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ]
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('app', 'Товари'); ?></div>
                <div class="panel-body" id="order_products">
                    <?= TabularInput::widget([
                        'min' => 0,
                        'models' => $orderItems,
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
                                'name' => 'product_id',
                                'enableError' => true,
                                'type' => SelectizeDropDownList::className(),
                                'options' => [
                                    'clientOptions' => [
                                        'render' => [
                                            'option' => new JsExpression("
                                                function(item, escape) {
                                                    return renderSelectOptions(item, $('.list-cell__product_id'));
                                                }
                                            ")
                                        ]
                                    ],
                                    'items' => $products,
                                    'options' => [
                                        'prompt' => Yii::t('app', 'Виберіть товар...'),
                                        'class' => 'form-control',
                                        'onchange' => "
                                            //refreshSelectOptions($('.list-cell__product_id'));
                                            
                                            var index = parseInt($(this).attr('id').replace(/\D+/g,''));
                                            $.get('" . Url::to(['product/ajax-price']) . "', {id: $(this).val()}, function(price) {
                                                var count = $('#orderitem-'+index+'-count').val().replace(',', '.').replace(/\s/g, '');
                                                if(count == 1*count){
                                                    $('#orderitem-'+index+'-price').val(price);
                                                    $('#orderitem-'+index+'-sum').val(floorFigure(1*price*1*count, 2));
                                                    $('.list-cell__sum input').change(); 
                                                }
                                            });
                                        "
                                    ]
                                ],
                                'title' => Yii::t('app', 'Товар'),
                            ],

                            [
                                'name' => 'count',
                                'title' => Yii::t('app', 'Кілкість'),
                                'options' => [
                                    'onchange' => "
                                        var index = parseInt($(this).attr('id').replace(/\D+/g,''));
                                        var count = $('#orderitem-'+index+'-count').val().replace(',', '.').replace(/\s/g, '');
                                        var price = $('#orderitem-'+index+'-price').val().replace(',', '.').replace(/\s/g, '');
                                        if(count == 1*count){
                                            $('#orderitem-'+index+'-sum').val(floorFigure(1*price*1*count, 2));
                                            $('.list-cell__sum input').change(); 
                                        }   
                                    "
                                ],
                                'value' => function ($data) {
                                    if (!$data['count']) $data['count'] = 1;
                                    return $data['count'];
                                },
                                'headerOptions' => ['width' => '100'],
                            ],

                            [
                                'name' => 'price',
                                'title' => Yii::t('app', 'Цена'),
                                'options' => [
                                    'onchange' => "
                                        var index = parseInt($(this).attr('id').replace(/\D+/g,''));
                                        var count = $('#orderitem-'+index+'-count').val().replace(',', '.').replace(/\s/g, '');
                                        var price = $('#orderitem-'+index+'-price').val().replace(',', '.').replace(/\s/g, '');
                                        if(price == 1*price){
                                            $('#orderitem-'+index+'-price').val(floorFigure(price, 2));
                                            $('#orderitem-'+index+'-sum').val(floorFigure(1*price*1*count, 2));
                                            $('.list-cell__sum input').change(); 
                                        }   
                                    "
                                ],
                                'value' => function ($data) {
                                    if (!$data['price']) $data['price'] = 0;
                                    return $data['price'];
                                },
                                'headerOptions' => ['width' => '100'],
                            ],

                            [
                                'name' => 'sum',
                                'title' => Yii::t('app', 'Сума'),
                                'options' => [
                                    'disabled' => true,
                                    'placeholder' => 0,
                                    'onchange' => "
                                        if($(this).val() == 1*$(this).val()){
                                            var total = 0;
                                            $('.list-cell__sum input').each(function(){
                                                total = total + 1*$(this).val();
                                            });
    
                                            $('#order-total').val(floorFigure(total, 2));
                                        }
                                    "
                                ],
                                'headerOptions' => ['width' => '100'],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'status')->label(Yii::t('app', 'Статус замовлення'))->widget(Select2::classname(), [
                        'data' => Order::getLabels('status'),
                        'options' => [
                            'prompt' => ''
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'total')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('/blocks/_save_apply_cancel') ?>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
    $('#order_products>div').on('afterDeleteRow', function(e, row) {
        refreshSelectOptions($('.list-cell__product_id'));
        $('#order-total').val(floorFigure(0, 2));
        $('.list-cell__sum input').change(); 
    });
JS;
$this->registerJs($script, View::POS_READY);
?>
