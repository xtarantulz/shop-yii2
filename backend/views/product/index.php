<?php

use common\models\Category;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use common\widgets\dynamic_grid_filter\DynamicGridFilterWidget;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\export\ExportMenu;
use common\models\core\Functional;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $regions array */
/* @var $points array */

$this->title = Yii::t('app', 'Товари');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-index">
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
        'options' => ['id' => 'dynagrid-product'],
        'gridOptions' => [
            'export' => [
                'label' => Yii::t('app', 'Експорт'),
                'target' => ExportMenu::TARGET_SELF,
                'showConfirmAlert' => false
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'panel' => [
                'heading' => "<h3 class='panel-title'><i class='fa fa-briefcase'></i> ".Yii::t('app', 'Таблиця Товарів')."</h3>",
                'before' => Html::a(Yii::t('app', 'Створити Товар'), ['create'], ['class' => 'btn btn-success']),
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
                                var text = "' . Yii::t('app', 'Ви впевнені, що хочете видалити вибрані товари?') . '";
                              
                                krajeeDialog.confirm(text, function(out){
                                    if(out) $.post("' . Url::to(['product/selected']) . '", {type: type, keys: $("#dynagrid-product>div").yiiGridView("getSelectedRows")});
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
                'attribute' => 'image',
                'filter' => false,
                'content' => function ($data) {
                    return Html::a(Html::img(Functional::getMiniImage($data['image']), [
                        'style' => 'width:80px;'
                    ]), $data['image'], [
                        'rel' => 'fancybox',
                    ]);
                },
                'headerOptions' => ['width' => '80'],
                'contentOptions' => ['height' => '100'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'name',
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'category_id',
                'filter' => Select2::widget([
                    'name' => 'ProductSearch[category_id]',
                    'value' => $searchModel->category_id,
                    'data' => Category::forSelectTree(),
                    'options' => [
                        'prompt' => ''
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]),
                'content' => function ($data) {
                    return $data['category']['name'];
                },
                'headerOptions' => ['width' => '120'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'price',
                'content' => function ($data) {
                    return Functional::floorDecimal($data['price'], 2);
                },
                'contentOptions' => ['align' => 'center'],
                'headerOptions' => ['width' => '100'],
                'order' => DynaGrid::ORDER_FIX_LEFT
            ],

            [
                'attribute' => 'description',
                'headerOptions' => ['width' => '200'],
                'visible' => false
            ],

            [
                'attribute' => 'slug',
                'content' => function ($data) {
                    return Html::a("/".$data['category']['alias']."/".$data['slug'].".html", "/".$data['category']['alias']."/".$data['slug'].".html", ['target' => '_blank']);
                },
                'headerOptions' => ['width' => '50'],
                'contentOptions' => ['align' => 'center'],
                'visible' => false
            ],

            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'name' => 'ProductSearch[created_at]',
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
                    'name' => 'ProductSearch[updated_at]',
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
                'attribute' => 'fields',
                'label' => Yii::t('app', 'Характеристики товара'),
                'filter' => false,
                'content' => function ($data) {
                    return Html::a(Yii::t('app', 'Показати'), '#', [
                        'data-id' => $data['id'],
                        'class' => 'modal-btn btn btn-info',
                        'data-pjax' => 0,
                        'data-target' => Url::toRoute(['product/ajax-info', 'id' => $data['id']]),
                        'title' => Yii::t('app', 'Характеристики товара').": ".$data['id']
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
