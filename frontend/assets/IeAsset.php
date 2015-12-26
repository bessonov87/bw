<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class IeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['condition' => 'lt IE 9'];

    public $css = [];
    public $js = [
        'bw15/libs/html5shiv/es5-shim.min.js',
        'bw15/libs/html5shiv/html5shiv.min.js',
        'bw15/libs/html5shiv/html5shiv-printshiv.min.js',
        'bw15/libs/respond/respond.min.js',
    ];
}