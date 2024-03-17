<?php

use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use common\widgets\dynamic_grid_filter\DynamicGridFilterWidget;
use common\models\User;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Адміністратори');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <?= DynaGrid::widget([
        'storage' => DynaGrid::TYPE_COOKIE,
        'theme' => 'panel-info',
        'options' => ['id' => 'dynagrid-user'],
        'gridOptions' => [
            'export' => [
                'label' => Yii::t('app', 'Експорт'),
                'target' => ExportMenu::TARGET_SELF,
                'showConfirmAlert' => false
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model) {
                if ($model->status == User::STATUS_DELETED) return ['class' => 'no-active'];
                return null;
            },
            'panel' => [
                'heading' => "<h3 class='panel-title'><i class='fa fa-user'></i> ".Yii::t('app', 'Таблиця адміністраторів')."</h3>",
                'before' => Html::a(Yii::t('app', 'Створити Адміністратора'), ['create'], ['class' => 'btn btn-success']),
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
                                    if(out) $.post("' . Url::to(['user/selected']) . '", {type: type, keys: $("#dynagrid-user>div").yiiGridView("getSelectedRows")});
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
                'attribute' => 'photo',
                'filter' => false,
                'content' => function ($data) {
                    return Html::a(Html::img($data['photo'], [
                        'style' => 'width:80px;'
                    ]), $data['photo'], [
                        'rel' => 'fancybox',
                    ]);
                },
                'headerOptions' => ['width' => '80'],
                'contentOptions' => ['height' => '100'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'email',
                'headerOptions' => ['width' => '120'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'fullName',
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'status',
                'filter' => Html::dropDownList('UserSearch[status]', $searchModel->status,
                    [
                        1 => Yii::t('app', 'Так'),
                        0 => Yii::t('app', 'Ні')
                    ],
                    [
                        'class' => 'form-control',
                        'prompt' => Yii::t('app', 'Всі')
                    ]
                ),
                'content' => function ($data) {
                    if ($data['status'] == User::STATUS_ACTIVE) {
                        return Html::a('<span class="fa fa-toggle-on"></span>', 'status?id=' . $data['id'], [
                            'title' => Yii::t('app', 'Відключити'),
                            'class' => 'toggle-off',
                            'aria-label' => Yii::t('app', 'Відключити'),
                            'data-pjax' => 0,
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('app', 'Ви дійсно хочете відключити цього адміністратора?')
                        ]);
                    } else {
                        return Html::a('<span class="fa fa-toggle-off"></span>', 'status?id=' . $data['id'], [
                            'title' => Yii::t('app', 'Включить'),
                            'class' => 'toggle-on',
                            'aria-label' => Yii::t('app', 'Включить'),
                            'data-pjax' => 0,
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('app', 'Ви дійсно хочете включити цього адміністратора?')
                        ]);
                    }
                },
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['width' => '80'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ],

            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'name' => 'UserSearch[created_at]',
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
                    'name' => 'UserSearch[updated_at]',
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
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}<br><br>{delete}',
                'headerOptions' => ['width' => '30', 'style' => 'font-size:0px'],
                'order' => DynaGrid::ORDER_FIX_RIGHT
            ],
        ]
    ]); ?>
</div>
