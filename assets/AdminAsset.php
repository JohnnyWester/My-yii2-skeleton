<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/jquery-confirm.min.css',
        'css/default.css',
        'css/admin.css',
    ];
    public $js = [
        'js/jquery-confirm.min.js',
        'js/admin.js'
    ];
    public $depends = [

    ];

}