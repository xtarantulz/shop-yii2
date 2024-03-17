<?php

use common\models\Map;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Category;
use common\models\core\Functional;

function showMainMenu($maps)
{
    echo "<ul>";
    foreach ($maps as $map) {
        $url = '/';
        if (isset($map['alias']) && $map['alias']) {
            $url = Url::to([$map['alias']]);
        } else {
            if (isset($map['slug']) && $map['slug']) {
                $url = Url::to([$map['slug']]);
            }
        }

        if ($url == '/') $url = '#';

        $class = '';
        if (isset($map['children'])) $class = 'drop-down';
        if ($url == Url::to()) $class = $class . " active";

        $options = [];
        if (isset($map['options'])) $options = $map['options'];
        echo "<li class='" . $class . "'>";
        echo Html::a($map['name'], $url, $options);
        if (isset($map['children'])) showMainMenu($map['children']);
        echo "</li>";
    }
    echo "</ul>";
}

$maps = Map::getTree();
//добавим каталог
$catalog[0] = [
    'name' => Yii::t('app', 'Каталог'),
    'alias' => '',
    'children' => Category::getTreeForMap()
];
$maps = array_merge($catalog, $maps);

//добавим пользоватеьское меню
if (Yii::$app->user->isGuest) {
    $maps[] = [
        'name' => Yii::t('app', 'Користувач'),
        'alias' => '',
        'children' => [
            [
                'name' => Yii::t('app', 'Вхід'),
                'alias' => 'user/login',
                'options' => [
                    'class' => 'modal-btn',
                    'data-pjax' => 0,
                    'data-target' => Url::toRoute(['user/login']),
                    'title' => Yii::t('app', 'Форма входу')
                ]
            ],
            [
                'name' => Yii::t('app', 'Регістрація'),
                'alias' => 'user/registration',
                'options' => [
                    'class' => 'modal-btn',
                    'data-pjax' => 0,
                    'data-target' => Url::toRoute(['user/registration']),
                    'title' => Yii::t('app', 'Форма регістрації')
                ]
            ],
            [
                'name' => Yii::t('app', 'Забули пароль'),
                'alias' => 'user/reset-password',
                'options' => [
                    'class' => 'modal-btn',
                    'data-pjax' => 0,
                    'data-target' => Url::toRoute(['user/reset-password']),
                    'title' => Yii::t('app', 'Форма скидання пароля')
                ]
            ],
        ]
    ];
} else {
    $maps[] = [
        'name' => Html::img(Functional::getMiniImage(Yii::$app->user->identity->photo), [
                'class' => 'photo-user-menu'
            ]) . Yii::t('app', 'Користувач'),
        'alias' => '',
        'children' => [
            [
                'name' => Yii::t('app', 'Профіль'),
                'alias' => 'user/profile',
            ],
            [
                'name' => Yii::t('app', 'Історія замовлень'),
                'alias' => 'user/orders',
            ],
            [
                'name' => Yii::t('app', 'Вихід'),
                'alias' => 'user/logout',
                'options' => [
                    "data-method" => "post",
                ]
            ],
        ]
    ];
}

//добавим корзину
$maps[] = [
    'name' => Yii::t('app', 'Кошик'),
    'alias' => 'cart/show',
];


?>

<header id="header" class="fixed-top">
    <div class="container">
        <div class="logo pull-left">
            <?= Html::a(Html::img('/img/logo.png', ['class' => 'img-fluid']), '/', ['class' => 'scrollto']) ?>
        </div>

        <nav class="main-nav pull-right hidden-xs hidden-sm hidden-md">
            <?php showMainMenu($maps); ?>
        </nav>
    </div>
</header>
