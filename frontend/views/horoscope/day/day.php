<?php
/**
 * @var \yii\web\View $this
 * @var integer $time
 * @var string $den
 * @var int $zodiak
 * @var int $znak
 * @var \common\models\ar\Goroskop $horoscope
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;

$time1 = time();
$time2 = time() + 86400;
$today = date('j', $time1) . ' ' . GlobalHelper::rusMonth(date('n', $time1), 'r') . ' ' . date('Y', $time1) . ' года';
$tomorrow = date('j', $time2) . ' ' . GlobalHelper::rusMonth(date('n', $time2), 'r') . ' ' . date('Y', $time2) . ' года';
$todayShort = date('d.m.Y', $time1);
$tomorrowShort = date('d.m.Y', $time2);

$day = $den == 'zavtra' ? 'завтра' : 'сегодня';
$znakText = $zodiak ? GlobalHelper::rusZodiac($zodiak) : 'для всех знаков Зодиака';

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$this->title = "Гороскоп на $day $znakText";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп на $day, события $day, Прогнозы, вопросы, предсказания астрологов, $znakText"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Астрологический прогноз на $day"
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
        <img src="/bw15/images/horoscope/horoscopes/daily-horoscope-all-'.($den && $den == 'zavtra' ? 'tomorrow' : 'today').'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="Общий Гороскоп на '.($den && $den == 'zavtra' ? 'завтра' : 'сегодня').' '.$znakText.'">
        <strong>'.($den && $den == 'zavtra' ? 'Завтра:' : 'Сегодня:').'</strong> '.($den && $den == 'zavtra' ? $tomorrow : $today).'<br><br>
        <p>Ежедневный гороскоп может подсказать, что ждет представителей каждого из двенадцати знаков Зодиака сегодня
            или завтра. Эта информация поможет вам избежать неудач или подготовиться к каким-либо событиям, которые
            могут произойти в любой из сфер вашей жизни. Зная возможное развитие дня, вы сможете оперативно повлиять
            на ситуацию и выйти из любого положения без особых проблем.</p>
        <p>&nbsp;</p>
        <p>Гороскоп на '.($den && $den == 'zavtra' ? 'завтра' : 'сегодня').' даст вам пищу для размышлений относительно того, что готовят звезды на предстоящий день.
            Чтобы узнать подробности, выбирайте свой знак Зодиака в таблице ниже и читайте астрологический прогноз
            на каждый день.</p><br>
    </div>';

} else {

    $engZnak = \common\components\AppData::$engZnaki[$zodiak];
    $engZnakTranslit = \common\components\AppData::$engZnakiTranslit[$zodiak];
    $rodZnak = GlobalHelper::rusZodiac($zodiak, 'r');

    if(!$horoscope){

        $options['content'] .= '<div class="goroskop_text">
            <img src="/bw15/images/horoscope/horoscopes/daily-horoscope-'.$engZnak.'-'.($den && $den == 'zavtra' ? 'tomorrow' : 'today').'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.GlobalHelper::rusZodiac($zodiak).' Гороскоп на сегодня">
            <strong>Дата:</strong> '.($den && $den == 'zavtra' ? $tomorrowShort : $todayShort).'<br><br>
            <p>Хотите знать, что ждет '.$rodZnak.' '.$day.'? Благодаря нашему астрологическому прогнозу вы сможете быть в 
            курсе событий каждой периода своей жизни. Наши гороскопы помогут вам планировать свою жизнь, благодаря 
            тому, что вы будете наперед знать о некоторых событиях, которые ожидают вас в ближайшие дни, недели, месяцы 
            и даже в этом году. Вы сможете узнать насколько благоприятен или нет этот период с точки зрения звезд и планет.</p>
	        <p>&nbsp;</p>
	        <p><strong>К сожалению прогноза на этот период еще нет. Гороскоп на '.$day.' для '.$rodZnak.' появится немного позже. Приносим свои извинения.</strong></p>
	        </div>';

    } else {

        $options['content'] .= '<div class="goroskop_text">
            <img src="/bw15/images/horoscope/horoscopes/daily-horoscope-'.$engZnak.'-'.($den && $den == 'zavtra' ? 'tomorrow' : 'today').'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.GlobalHelper::rusZodiac($zodiak).' Гороскоп на сегодня">
            <strong>Дата:</strong> '.($den && $den == 'zavtra' ? $tomorrowShort : $todayShort).'<br><br>
            <p>'.$horoscope->text.'</p>
	        </div>';

    }

    $znakSymbol = '&#98'.sprintf('%02d', ($zodiak-1)).';';
    $year = date('Y');
    $month = date('m');
    $options['content'] .= '<div class="goroskop_vse">
    <strong>Все гороскопы для представителей знака Зодиака <span style="text-decoration:underline">'.GlobalHelper::rusZodiac($zodiak).'</span>:</strong><br>';
    if($den == 'segodnja') {
        $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-zavtra/' . $engZnakTranslit . '/" title="">Гороскоп на завтра для ' . $rodZnak . ' »</a><br>';
    } else {
        $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-segodnja/' . $engZnakTranslit . '/" title="">Гороскоп на сегодня для ' . $rodZnak . ' »</a><br>';
    }
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-nedelju/'.$engZnakTranslit.'/" title="">Гороскоп на неделю для '.$rodZnak.' »</a><br>';
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-sledujushhuju-nedelju/'.$engZnakTranslit.'/" title="">Гороскоп на следующую неделю для '.$rodZnak.' »</a><br>';
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month).' '.$year.' для '.$rodZnak.' »</a><br>';
    if($month < 12) {
        $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month+1).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month+1).' '.$year.' для '.$rodZnak.' »</a><br>';
    }
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-god/'.$year.'/'.$engZnakTranslit.'/" title="">Гороскоп на '.$year.' год для '.$rodZnak.' »</a>
    </div>';
}



$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/horoscope/na-'.$den.'/',
    'znak' => $zodiak,
    'den' => $den,
    'period' => \common\models\ar\Goroskop::PERIOD_DAY
]);

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);