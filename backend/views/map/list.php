<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use yii\helpers\Url;
use common\widgets\dynamic_grid_filter\DynamicGridFilterWidget;
use common\models\Map;
use yii\jui\DatePicker;
use kartik\export\ExportMenu;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pages array */

$this->title = Yii::t('app', 'Пункти меню');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-list">
    <?= DynaGrid::widget([
        'storage' => DynaGrid::TYPE_COOKIE,
        'theme' => 'panel-info',
        'options' => ['id' => 'dynagrid-map'],
        'gridOptions' => [
            'export' => [
                'label' => Yii::t('app', 'Експорт'),
                'target' => ExportMenu::TARGET_SELF,
                'showConfirmAlert' => false
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'panel' => [
                'heading' => "<h3 class='panel-title'><i class='fa fa-bars'></i> ".Yii::t('app', 'Табиця категорій')."</h3>",
                'before' => Html::a(Yii::t('app', 'Створити Пункт Меню'), ['create'], ['class' => 'btn btn-success']) .
                    Html::a(Yii::t('app', 'Перегляд Дерева'), ['index'], ['class' => 'btn btn-primary', 'style' => 'margin-left:20px;']),
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
                                var text = "' . Yii::t('app', 'Ви впевнені, що хочете видалити вибрані пункти меню?') . '";
                              
                                krajeeDialog.confirm(text, function(out){
                                    if(out) $.post("' . Url::to(['map/selected']) . '", {type: type, keys: $("#dynagrid-map>div").yiiGridView("getSelectedRows")});
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
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '50'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'name',
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'page_id',
                'filter' => Select2::widget([
                    'name' => 'MapSearch[page_id]',
                    'value' => $searchModel->page_id,
                    'data' => $pages,
                    'options' => [
                        'prompt' => ''
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]),
                'content' => function ($data) {
                    if ($data['page_id']) {
                        return Html::a($data['page']['name'], Url::to(['page/index', 'PageSearch[id]' => $data['page']['id']]));
                    } else {
                        return "";
                    }
                },
                'headerOptions' => ['width' => '200'],
            ],

            [
                'attribute' => 'parent_id',
                'filter' => Select2::widget([
                    'name' => 'MapSearch[parent_id]',
                    'value' => $searchModel->parent_id,
                    'data' => Map::forSelectTree(),
                    'options' => [
                        'prompt' => ''
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]),
                'content' => function ($data) {
                    if ($data['parent_id']) {
                        return Html::a($data['parent']['name'], Url::to(['map/list', 'MapSearch[id]' => $data['parent']['id']]));
                    } else {
                        return "";
                    }
                },
                'headerOptions' => ['width' => '200'],
            ],

            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'name' => 'MapSearch[created_at]',
                    'value' => $searchModel->created_at,
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]),
                'format' => 'datetime',
                'headerOptions' => ['width' => '95']
            ],

            [
                'attribute' => 'updated_at',
                'filter' => DatePicker::widget([
                    'name' => 'MapSearch[updated_at]',
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}<br>{create}<br>{delete}',
                'buttons' => [
                    'create' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', Url::to(['create', 'parent_id' => $model->id]), [
                            'title' => Yii::t('yii', 'Створити під-меню'),
                            'aria-label' => 'Створити під-меню',
                            'data-pjax' => '0'
                        ]);
                    },

                ],
                'headerOptions' => ['width' => '30'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ]
        ]
    ]); ?>
</div>
