<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SharerAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'bw15/sharer/style.css',
    ];

    public $js = [
        'bw15/sharer/script.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}