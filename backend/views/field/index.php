<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use common\widgets\dynamic_grid_filter\DynamicGridFilterWidget;
use common\models\Field;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Поля');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="field-index">
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
        'options' => ['id' => 'dynagrid-field'],
        'gridOptions' => [
            'export' => [
                'label' => Yii::t('app', 'Експорт'),
                'target' => ExportMenu::TARGET_SELF,
                'showConfirmAlert' => false
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'panel' => [
                'heading' => "<h3 class='panel-title'><i class='fa fa-server'></i> " . Yii::t('app', 'Таблиця полів') . "</h3>",
                'before' => Html::a(Yii::t('app', 'Створити Поле'), ['create'], ['class' => 'btn btn-success']),
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
                                var text = "' . Yii::t('app', 'Ви впевнені, що хочете видалити вибрані поля?') . '";
                              
                                krajeeDialog.confirm(text, function(out){
                                    if(out) $.post("' . Url::to(['field/selected']) . '", {type: type, keys: $("#dynagrid-field>div").yiiGridView("getSelectedRows")});
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
                'attribute' => 'name',
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'type',
                'filter' => Select2::widget([
                    'name' => 'FieldSearch[type]',
                    'value' => $searchModel->type,
                    'data' => Field::getLabels('type'),
                    'options' => [
                        'prompt' => ''
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]),
                'content' => function ($data) {
                    return Field::getLabels('type')[$data['type']];
                },
                'headerOptions' => ['width' => '120'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'options',
                'content' => function ($data) {
                    if ($data['options']) {
                        return implode(', ', $data['options']);
                    } else {
                        return '';
                    }
                },
                'headerOptions' => ['width' => '120'],
                'visible' => false
            ],

            [
                'attribute' => 'expansions',
                'filter' => Select2::widget([
                    'name' => 'FieldSearch[expansions]',
                    'value' => $searchModel->expansions,
                    'data' => Field::getLabels('expansions'),
                    'options' => [
                        'prompt' => ''
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]),
                'content' => function ($data) {
                    if ($data['expansions']) {
                        return implode(', ', $data['expansions']);
                    } else {
                        return '';
                    }
                },
                'headerOptions' => ['width' => '100'],
                'visible' => false
            ],

            [
                'attribute' => 'number_after_point',
                'content' => function ($data) {
                    if ($data['number_after_point']) {
                        return $data['number_after_point'];
                    } else {
                        return '';
                    }
                },
                'headerOptions' => ['width' => '10'],
                'visible' => false
            ],

            [
                'attribute' => 'prefix',
                'headerOptions' => ['width' => '10'],
                'visible' => false
            ],

            [
                'attribute' => 'suffix',
                'headerOptions' => ['width' => '10'],
                'visible' => false
            ],

            [
                'attribute' => 'description',
                'headerOptions' => ['width' => '200'],
            ],

            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'name' => 'FieldSearch[created_at]',
                    'value' => $searchModel->created_at,
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]),
                'format' => 'datetime',
                'headerOptions' => ['width' => '95'],
            ],

            [
                'attribute' => 'updated_at',
                'filter' => DatePicker::widget([
                    'name' => 'FieldSearch[updated_at]',
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
                'attribute' => 'details',
                'label' => Yii::t('app', 'Деталі поля'),
                'filter' => false,
                'content' => function ($data) {
                    return Html::a(Yii::t('app', 'Показати'), '#', [
                        'data-id' => $data['id'],
                        'class' => 'modal-btn btn btn-info',
                        'data-pjax' => 0,
                        'data-target' => yii\helpers\Url::toRoute(['field/ajax-info', 'id' => $data['id']]),
                        'title' => Yii::t('app', 'Показати деталі поля').": ".$data['name']
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
