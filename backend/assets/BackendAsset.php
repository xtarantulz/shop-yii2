<?php

namespace backend\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/change.css',
        'css/site.css',
    ];
    public $js = [
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\jui\JuiAsset',
    ];
}
