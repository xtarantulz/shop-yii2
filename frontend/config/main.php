<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => 'frontend\module\api\ApiModule',
        ]
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii2mod\tree\TreeAsset' => [
                    'css' => [
                        'skin-win8/ui.fancytree.less',
                    ]
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'page/<slug:[\w_\/-]+>'=>'page/index',
                'catalog/<alias:[\w\-\d\(\)\/\*\s]+>/<slug:[\w\-\d\(\)\*\s]+>.html'=>'catalog/product',
                'catalog/<alias:[\w\-\d\(\)\/\*\s]+>'=>'catalog/index',
                '<action:\w+>' => 'site/<action>',
            ]
        ]
    ],
    'params' => $params,
];
