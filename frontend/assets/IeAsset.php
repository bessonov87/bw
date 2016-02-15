<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * IeAsset подключает файлы для Internet Explorer ниже 9 версии
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
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