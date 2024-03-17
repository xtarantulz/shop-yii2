<?php
use common\models\Config;

ini_set('date.timezone', 'Europe/Kiev');
return [
    'name' => 'Shop',
    'language' => 'uk',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'config' => function () {
            return Config::findOne(1);
        },
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport'=>[
                'class' => 'Swift_SmtpTransport',
                'host' => 'ssl://smtp.gmail.com',
                'username' => 'send@seotm.com',
                'password' => 'gB%&5jUK&u56HERBd',
                'port' => '465',
            ],
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Europe/Kiev',
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'timeFormat' => 'HH:mm:ss',
        ],
    ],
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
            'defaultPageSize' => 50
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ],
];
