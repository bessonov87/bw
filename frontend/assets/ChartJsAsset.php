<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 27.01.17
 * Time: 23:00
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class ChartJsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/chartjs/dist/';

    public $js = [
        'Chart.bundle.min.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset'
    ];
}