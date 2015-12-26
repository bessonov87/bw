<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'bw15/css/main.css',
        'bw15/css/fonts.css',
        'bw15/css/normalize.css',
        'bw15/libs/owl-carousel/owl.carousel.css',
        'bw15/libs/fancybox/jquery.fancybox.css',
        'bw15/libs/font-awesome-4.2.0/css/font-awesome.min.css',
    ];
    public $js = [
        'bw15/libs/jquery-mousewheel/jquery.mousewheel.min.js',
        'bw15/libs/fancybox/jquery.fancybox.pack.js',
        'bw15/libs/scrollto/jquery.scrollTo.min.js',
        'bw15/libs/owl-carousel/owl.carousel.min.js',
        'bw15/js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
