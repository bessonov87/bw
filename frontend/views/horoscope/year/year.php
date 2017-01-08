<?php
/**
 * @var \yii\web\View $this
 * @var int $zodiak
 * @var \common\models\ar\Goroskop $horoscope
 * @var array $years
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;

$znakText = $zodiak ? GlobalHelper::rusZodiac($zodiak) : 'для всех знаков Зодиака';

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];
if($year && $zodiak) {
    $this->params['breadcrumbs'][] = ['label' => Html::a('Гороскопы на год', '/horoscope/na-god/'), 'encode' => false];
}

$yearText = $year ? $year.' ' : '';

$this->title = "Гороскоп на ".$yearText."год $znakText";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп на ".$yearText."год, события ".$yearText."года, Прогнозы, вопросы, предсказания астрологов, $znakText"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Астрологический прогноз на ".$yearText."год"
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/index', 'type' => 'common', 'period' => 'index'])]);

$options = [
    'title' => $this->title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

if(!$zodiak) {

    $options['content'] .= '<div class="goroskop_text">
        <img src="/bw15/images/horoscope/horoscopes/yearly-horoscope-'.($year ? $year : 'all').'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.$this->title.'">';
    if(!$year || !$horoscope) {
        $options['content'] .= '<p>Изучая транзиты планет солнечной системы, таких как Плутон, Уран, Нептун, Сатурн и Юпитер, 
        а также положение относительно Северного и Южного узлов, мы можем получить более ясное представление о вероятных тенденциях 
        в течение длительных периодов времени. Эти и некоторые другие особенности позволяют астрологам составлять ежегодный гороскоп.</p>
        <p>&nbsp;</p>
        <p>Изучая движения планет относительно различных знаков Зодиака и сопоставляя данные с наблюдениями, которые 
        производились астрологами в течение многих сотен лет, астрологи научились строить подробные предсказания на самые 
        разнообразные периоды времени. Вы можете также ознакомиться с <a href="/horoscope/na-mesjac/">гороскопами на месяц</a>, <a href="/horoscope/na-nedelju/">гороскопами на неделю</a> 
            или с <a href="/horoscope/na-den/">гороскопами на каждый день</a>.</p>';
        $options['content'] .= '<p>&nbsp;</p>';
        if($year && !$horoscope){
            $options['content'] .= '<p>&nbsp;</p>';
            $options['content'] .= '<div class="alert alert-info"><strong>К сожалению прогноза на этот период еще нет. Гороскоп на '.$year.' год появится немного позже. Приносим свои извинения.</strong></div>';
        }
    } else {
        $options['content'] .= $horoscope->text;
    }
    $options['content'] .= '</div>';

} else {

    $engZnak = \common\components\AppData::$engZnaki[$zodiak];
    $engZnakTranslit = \common\components\AppData::$engZnakiTranslit[$zodiak];
    $rodZnak = GlobalHelper::rusZodiac($zodiak, 'r');

    $options['content'] .= '<div class="goroskop_text">
        <img src="/bw15/images/horoscope/horoscopes/yearly-horoscope-'.$engZnak.'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.$this->title.'">';
    if(!$horoscope) {
        $options['content'] .= '<p>Хотите знать, что планируют звезды для '.$rodZnak.' в '.$year.' году? 
            Если да, готовы предложить вам наши ежегодные астрологические прогнозы. Если вам нужен более подробный и точный прогноз, 
            можете ознакомиться с <a href="/horoscope/na-mesjac/">гороскопами на месяц</a>, <a href="/horoscope/na-nedelju/">гороскопами на неделю</a> 
            или с <a href="/horoscope/na-den/">гороскопами на каждый день</a>.</p>';
        $options['content'] .= '<p>&nbsp;</p>';
        $options['content'] .= '<div class="alert alert-info"><strong>К сожалению прогноза на этот период еще нет. Гороскоп на '.$year.' год для '.$rodZnak.' появится немного позже. Приносим свои извинения.</strong></div>';
    } else {
        $options['content'] .= $horoscope->text;
    }
    $options['content'] .= '</div>';

    $znakSymbol = '&#98'.sprintf('%02d', ($zodiak-1)).';';
    $year = date('Y');
    $month = date('m');
    $options['content'] .= '<div class="goroskop_vse">
    <strong>Все гороскопы для представителей знака Зодиака <span style="text-decoration:underline">'.GlobalHelper::rusZodiac($zodiak).'</span>:</strong><br>';
    $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-zavtra/' . $engZnakTranslit . '/" title="">Гороскоп на завтра для ' . $rodZnak . ' »</a><br>';
    $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-segodnja/' . $engZnakTranslit . '/" title="">Гороскоп на сегодня для ' . $rodZnak . ' »</a><br>';
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-nedelju/'.$engZnakTranslit.'/" title="">Гороскоп на неделю для '.$rodZnak.' »</a><br>';
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-sledujushhuju-nedelju/'.$engZnakTranslit.'/" title="">Гороскоп на следующую неделю для '.$rodZnak.' »</a><br>';
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month).' '.$year.' для '.$rodZnak.' »</a><br>';
    if($month < 12) {
        $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month+1).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month+1).' '.$year.' для '.$rodZnak.' »</a><br>';
    }
    $options['content'] .= '</div>';
}

$widgetYear = $year ? $year : date('Y');
$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/horoscope/na-god/'.$widgetYear.'/',
    'znak' => $zodiak,
    'year' => $widgetYear,
    'period' => \common\models\ar\Goroskop::PERIOD_YEAR
]);

if(!$year && $years){
    $options['content'] .= "<div class='goroskop_vse'><h4 style='text-align: center;'>Все ежегодные гороскопы:</h4>";
    $items = [];
    foreach ($years as $horoYear) {

        $items[] = Html::a('Гороскоп на ' . $horoYear . ' год', "/horoscope/na-god/$horoYear/");
    }
    $options['content'] .= Html::ul($items, ['encode' => false]);
    $options['content'] .= '</div>';
}

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);