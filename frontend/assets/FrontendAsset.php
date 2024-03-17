<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'lib/font-awesome/css/font-awesome.min.css',
        'lib/accordion/css/accordion.css',

        'css/from_backend.css',
        'css/style.css',
        'css/change.css',
        'css/main_page.css',
    ];
    public $js = [
        'lib/easing/easing.min.js',
        'lib/mobile-nav/mobile-nav.js',
        'lib/accordion/js/accordion.js',

        'js/main.js',
        'js/change.js',
        'js/cart.js',
        'js/modal.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\jui\JuiAsset',
    ];
}
