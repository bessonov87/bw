<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'bw15/fancybox/jquery.fancybox.min.css',
    ];

    public $js = [
        'bw15/fancybox/jquery.fancybox.min.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}