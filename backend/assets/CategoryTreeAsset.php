<?php
namespace backend\assets;

use yii\web\AssetBundle;

class CategoryTreeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/tree/jquery.mjs.nestedSortable.js',
        'js/tree/tree.js',
    ];

    public $css = [
        'css/tree/tree.css',
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];
}