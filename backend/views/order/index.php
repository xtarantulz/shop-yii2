<?php

use yii\helpers\Html;
use common\widgets\dynamic_grid_filter\DynamicGridFilterWidget;
use kartik\dynagrid\DynaGrid;
use kartik\export\ExportMenu;
use common\models\Order;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $clients array */

$this->title = Yii::t('app', 'Замовлення');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <?php
    Modal::begin([
        'header' => '<h2></h2>',
        'id' => 'modal',
        'size' => Modal::SIZE_DEFAULT,
        'footer' => '<button type="button" class="btn btn-danger" data-dismiss="modal">' . Yii::t("app", "Закрити") . '</button>'
    ]);
    ?>
    <div id='modal-content'><?= Yii::t('app', 'Загрузка...'); ?></div>
    <?php Modal::end(); ?>

    <?= DynaGrid::widget([
        'storage' => DynaGrid::TYPE_COOKIE,
        'theme' => 'panel-info',
        'options' => ['id' => 'dynagrid-order'],
        'gridOptions' => [
            'export' => [
                'label' => Yii::t('app', 'Експорт'),
                'target' => ExportMenu::TARGET_SELF,
                'showConfirmAlert' => false
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model) {
                if ($model->status == Order::STATUS_CANCELED) return ['class' => 'no-active'];
                return null;
            },
            'panel' => [
                'heading' => "<h3 class='panel-title'><i class='fa fa-id-card'></i> " . Yii::t('app', 'Таблиця замовлень') . "</h3>",
                'before' => Html::a(Yii::t('app', 'Створити Замовлення'), ['create'], ['class' => 'btn btn-success']),
                'after' => false,
                'showFooter' => false
            ],
            'toolbar' => [
                DynamicGridFilterWidget::widget(),
                ['content' => '{dynagrid}'],
                '{export}',
                [
                    'content' => Html::dropDownList('s_id', null, [1 => Yii::t('app', 'Видалити вибрані')], [
                        'prompt' => Yii::t('app', 'Дія на обраному'),
                        'class' => 'form-control',
                        'onchange' => '
                            var type = $(this).val();
                            if(type > 0){
                                var text = "' . Yii::t('app', 'Ви впевнені, що хочете видалити вибрані адміністратори?') . '";
                              
                                krajeeDialog.confirm(text, function(out){
                                    if(out) $.post("' . Url::to(['order/selected']) . '", {type: type, keys: $("#dynagrid-order>div").yiiGridView("getSelectedRows")});
                                });
                            }
                        ',
                    ])
                ],
            ]
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'class' => 'kartik\grid\SerialColumn',
                'order' => DynaGrid::ORDER_FIX_LEFT,
                'header' => '№'
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '50'],
                'contentOptions' => ['align' => 'center'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'user_id',
                'filter' => Select2::widget([
                    'name' => 'SubjectSearch[user_id]',
                    'value' => $searchModel->user_id,
                    'data' => $clients,
                    'options' => [
                        'prompt' => ''
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]),
                'content' => function ($data) {
                    if ($data['user_id']) {
                        return Html::a($data['user']['fullName'], Url::to(['client/index', 'UserSearch[id]' => $data['user_id']]), [
                            'style' => 'color: green;'
                        ]);
                    }else{
                        return "<div style='color: grey;'>" . Yii::t('app', 'Гость') . "</div>";

                    }},
                'headerOptions' => ['width' => '120'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'fullName',
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'email',
                'headerOptions' => ['width' => '80'],
                'order' => DynaGrid::ORDER_FIX_LEFT,
            ],

            [
                'attribute' => 'phone',
                'content' => function ($data) {
                    return "+380" . $data['phone'];
                },
                'headerOptions' => ['width' => '80'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'total',
                'contentOptions' => ['align' => 'center'],
                'headerOptions' => ['width' => '80'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'status',
                'filter' => Html::dropDownList('OrderSearch[status]', $searchModel->status,
                    Order::getLabels('status'),
                    [
                        'class' => 'form-control',
                        'prompt' => Yii::t('app', 'Всі')
                    ]
                ),
                'content' => function ($data) {
                    $color = 'grey';
                    if ($data['status'] == Order::STATUS_APPROVED) $color = 'green';
                    if ($data['status'] == Order::STATUS_CANCELED) $color = 'red';
                    return "<div style='color: " . $color . ";'>" . Order::getLabels('status')[$data['status']] . "</div>";
                },
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['width' => '100']
            ],

            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'name' => 'OrderSearch[created_at]',
                    'value' => $searchModel->created_at,
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]),
                'format' => 'datetime',
                'headerOptions' => ['width' => '95'],
                'visible' => false
            ],

            [
                'attribute' => 'updated_at',
                'filter' => DatePicker::widget([
                    'name' => 'OrderSearch[updated_at]',
                    'value' => $searchModel->updated_at,
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]),
                'format' => 'datetime',
                'headerOptions' => ['width' => '95'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ],

            [
                'attribute' => 'items',
                'label' => Yii::t('app', 'Товари'),
                'filter' => false,
                'content' => function ($data) {
                    return Html::a(Yii::t('app', 'Показати'), '#', [
                        'data-id' => $data['id'],
                        'class' => 'modal-btn btn btn-info',
                        'data-pjax' => 0,
                        'data-target' => Url::toRoute(['order/ajax-info', 'id' => $data['id']]),
                        'title' => Yii::t('app', 'Товари замовлення').": ".$data['id']
                    ]);
                },
                'headerOptions' => ['width' => '120'],
                'contentOptions' => ['align' => 'center'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}<br><br>{delete}',
                'headerOptions' => ['width' => '30', 'style' => 'font-size:0px'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ],
        ]
    ]); ?>
</div>

<?php $this->registerJsFile('/admin/js/modal.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
