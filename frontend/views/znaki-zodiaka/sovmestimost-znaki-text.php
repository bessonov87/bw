<?php
/**
 * @var \yii\web\View $this
 * @var string $znakMan
 * @var string $znakWoman
 * @var \common\models\ar\Sovmestimost $sovmestimost
 */

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;
use common\models\ar\ZnakiZodiaka;
use app\components\widgets\ZnakZodiakaHeaderWidget;
use common\components\AppData;

$this->params['breadcrumbs'][] = ['label' => Html::a('Знаки Зодиака', '/znaki-zodiaka/'), 'encode' => false];

$znakManRus = GlobalHelper::rusZodiac($znakMan);
$znakManRod = GlobalHelper::rusZodiac($znakMan, 'r');
$znakWomanRus = GlobalHelper::rusZodiac($znakWoman);
$znakWomanRod = GlobalHelper::rusZodiac($znakWoman, 'r');
$engMan = AppData::$engZnaki[$znakMan];
$engManTranslit = AppData::$engZnakiTranslit[$znakMan];
$engWoman = AppData::$engZnaki[$znakWoman];
$engWomanTranslit = AppData::$engZnakiTranslit[$znakWoman];

$title = "$znakWomanRus-женщина + $znakManRus-мужчина. Гороскоп совместимости";
$metaTitle = "Гороскоп совместимости $znakWomanRus-женщина + $znakManRus-мужчина в любви, дружбе, сексе";

$this->title = $metaTitle;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "совместимость знаков, $znakManRus-мужчина, $znakWomanRus-женщина, предсказания астрологов, $znakWomanRus+$znakManRus"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$title}. Астрологические прогнозы для $znakManRod и $znakWomanRod"
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/index', 'type' => 'common', 'period' => 'index'])]);

$options = [
    'title' => $title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

$options['content'] .= '<img style="float: left; padding-right: 8px;" src="/bw15/images/horoscope/signs/'.$engWoman.'.png" alt="'.$znakWomanRus.'-женщина" width="130" height="130">';
$options['content'] .= '<img style="float: right; padding-right: 8px;" src="/bw15/images/horoscope/signs/'.$engMan.'.png" alt="'.$znakManRus.'-мужчина" width="130" height="130">';



$options['content'] .= $sovmestimost->text;

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);
