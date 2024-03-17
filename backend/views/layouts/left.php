<?php

use yii\helpers\Html;
use common\models\core\Functional;

/* @var $user common\models\User */
?>

<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="/admin" class="site_title">
            <i class="fa fa-paw"></i>
            <span><?= Yii::$app->name; ?></span>
        </a>
    </div>
    <div class="clearfix"></div>

    <div class="profile">
        <div class="profile_pic">
            <img src="<?= Functional::getMiniImage($user->photo); ?>" class="img-circle profile_img">
        </div>
        <div class="profile_info">
            <span>Привіт,</span>
            <h2><?= $user->first_name . " " . $user->last_name; ?></h2>
        </div>
    </div>

    <br/>
    <div class="clearfix"></div>

    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <?= common\widgets\Menu::widget(
                [
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Пункти меню'),
                            "url" => "#",
                            'icon' => 'bars',
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Дерево'),
                                    'url' => ['map/index'],
                                    'scope' => ['map/index', 'map/update', 'map/create'],
                                ],
                                [
                                    'label' => Yii::t('app', 'Таблиця'),
                                    'url' => ['map/list'],
                                ],
                            ]
                        ],
                        [
                            "label" => Yii::t('app', "Сторінки"),
                            "icon" => "book",
                            "url" => ["page/index"],
                            'scope' => ['page/index', 'page/update', 'page/create'],
                        ],
                        [
                            "label" => Yii::t('app', "Користувачі"),
                            "icon" => "users",
                            "url" => "#",
                            "items" => [
                                [
                                    "label" => Yii::t('app', "Адміністратори"),
                                    "url" => ["user/index"],
                                    'scope' => ['user/index', 'user/update', 'user/create'],
                                ],
                                [
                                    "label" => Yii::t('app', "Менеджери"),
                                    "url" => ["manager/index"],
                                    'scope' => ['manager/index', 'manager/update', 'manager/create'],
                                ],
                                [
                                    "label" => Yii::t('app', "Клієнти"),
                                    "url" => ["client/index"],
                                    'scope' => ['client/index', 'client/update', 'client/create'],
                                ],
                            ],
                        ],
                        [
                            'label' => Yii::t('app', 'Категорії'),
                            "url" => "#",
                            'icon' => 'arrows-alt',
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Дерево'),
                                    'url' => ['category/index'],
                                    'scope' => ['category/index', 'category/update', 'category/create'],
                                ],
                                [
                                    'label' => Yii::t('app', 'Таблиця'),
                                    'url' => ['category/list'],
                                ],
                            ]
                        ],
                        [
                            "label" => Yii::t('app', "Товари"),
                            "icon" => "briefcase",
                            "url" => ["product/index"],
                            'scope' => ['product/index', 'product/update', 'product/create'],
                        ],
                        [
                            "label" => Yii::t('app', "Поля"),
                            "icon" => "server",
                            "url" => ["field/index"],
                            'scope' => ['field/index', 'field/update', 'field/create'],
                        ],
                        [
                            "label" => Yii::t('app', "Замовлення"),
                            "icon" => "id-card",
                            "url" => ["order/index"],
                            'scope' => ['order/index', 'order/update', 'order/create'],
                        ],
                    ]
                ]
            ); ?>
        </div>
    </div>

    <div class="sidebar-footer hidden-small">
        <?= Html::a('<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
            ['/site/profile'],
            [
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => Yii::t('app', 'Профайл'),
            ]
        ); ?>

        <?= Html::a('<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>',
            ['/site/config'],
            [
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => Yii::t('app', 'Налаштування'),
            ]
        ); ?>

        <?= Html::a('<span class="glyphicon glyphicon-file" aria-hidden="true"></span>',
            ['/site/file'],
            [
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => Yii::t('app', 'Файловий менеджер'),
            ]
        ); ?>

        <?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span>',
            ['/site/logout'],
            [
                'data-method' => 'post',
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => Yii::t('app', 'Вийти'),
            ]
        ); ?>
    </div>
</div>
