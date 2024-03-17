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

$this->title = Yii::t('app', 'Історія замовлень');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-orders">
    <h1><?= $this->title; ?></h1>

    <?= DynaGrid::widget([
        'storage' => DynaGrid::TYPE_COOKIE,
        'theme' => 'panel-info',
        'options' => ['id' => 'dynagrid-user-orders'],
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
                'before' => '',
                'after' => false,
                'showFooter' => false
            ],
            'toolbar' => [
                DynamicGridFilterWidget::widget(),
                ['content' => '{dynagrid}'],
                '{export}',
            ]
        ],
        'columns' => [
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
                        'data-target' => Url::toRoute(['user/ajax-order-info', 'id' => $data['id']]),
                        'title' => Yii::t('app', 'Товари замовлення').": ".$data['id']
                    ]);
                },
                'headerOptions' => ['width' => '120'],
                'contentOptions' => ['align' => 'center'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ],
        ]
    ]); ?>
</div>
