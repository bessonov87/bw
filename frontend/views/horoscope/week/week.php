<?php
/**
 * @var \yii\web\View $this
 * @var integer $time
 * @var string $week
 * @var int $zodiak
 * @var int $znak
 * @var int $weekNum
 * @var \common\models\ar\Goroskop $horoscope
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;

$monday = GlobalHelper::getMonday($weekNum);
$sunday = GlobalHelper::getSunday($weekNum);
$weekInterval = 'с '.date('j', $monday) . ' ' . GlobalHelper::rusMonth(date('n', $monday), 'r') . ' по ' . date('j', $sunday) . ' ' . GlobalHelper::rusMonth(date('n', $sunday), 'r');
$weekIntervalShort = date('d.m.Y', $monday) . ' - ' . date('d.m.Y', $sunday);

$period = $week == 'this' ? 'неделю' : 'следующую неделю';
$znakText = $zodiak ? GlobalHelper::rusZodiac($zodiak) : 'для всех знаков Зодиака';

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$this->title = "Гороскоп на $period $znakText";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп на $period, события $period, Прогнозы, вопросы, предсказания астрологов, $znakText"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Астрологический прогноз на $period"
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
        <img src="/bw15/images/horoscope/horoscopes/weekly-horoscope-all.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="Общий Гороскоп на '.$period.' '.$znakText.'">
        <strong>Неделя:</strong> '.$weekIntervalShort.'<br><br>
        <p>Хотите знать, что ждет вас на '.($week == 'this' ? 'этой' : 'следующей').' неделе? Тогда вы попали точно по адресу. Благодаря 
        еженедельному астрологическому прогнозу вы сможете каждую неделю начинать с правильной ноты. Наши гороскопы 
        на '.$period.' помогут вам быть в курсе событий, который с большой вероятностью ожидают вас в ближайшие дни. 
        Также вы можете понять благоприятна эта неделя для каких-либо действий или нет.</p>
        <p>&nbsp;</p>
        <p>Гороскоп на '.$period.' составляется для каждого знака Зодиака. В нем содержится краткая информация о том, что 
        вас ждет и к чему вам нужно готовиться на неделе. Помимо информации о вероятных событиях, в гороскопах 
        содержатся ценные советы, которые помогут вам справиться с некоторыми проблемами, которые готовит для вас 
        судьба. Только не воспринимайте гороскоп в качестве руководства к действию. У каждого астрологического 
        прогноза есть своя вероятность и свой процент совпадений. Один и тот же прогноз не может сбываться у всех 
        без исключения людей того или иного знака Зодиака. Поэтому, если описанные в гороскопе события (особенно 
        негативные) не происходят, не стоит на них зацикливаться, провоцируя тем самым их возникновение. Используйте 
        гороскоп как рекомендацию, если событие уже произошло.</p><br>
    </div>';

} else {

    $engZnak = \common\components\AppData::$engZnaki[$zodiak];
    $engZnakTranslit = \common\components\AppData::$engZnakiTranslit[$zodiak];
    $rodZnak = GlobalHelper::rusZodiac($zodiak, 'r');

    if(!$horoscope){

        $options['content'] .= '<div class="goroskop_text">
            <img src="/bw15/images/horoscope/horoscopes/weekly-horoscope-'.$engZnak.'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.GlobalHelper::rusZodiac($zodiak).' Гороскоп на сегодня">
            <strong>Неделя:</strong> '.$weekInterval.'<br><br>
            <p>Хотите знать, что ждет '.$rodZnak.' на '.($week == 'this' ? 'этой' : 'следующей').' неделе? Благодаря нашему астрологическому прогнозу вы сможете быть в 
            курсе событий каждой периода своей жизни. Наши гороскопы помогут вам планировать свою жизнь, благодаря 
            тому, что вы будете наперед знать о некоторых событиях, которые ожидают вас в ближайшие дни, недели, месяцы 
            и даже в этом году. Вы сможете узнать насколько благоприятен или нет этот период с точки зрения звезд и планет.</p>
	        <p>&nbsp;</p>
	        <div class="alert alert-info"><strong>К сожалению прогноза на этот период еще нет. Гороскоп на '.($week == 'this' ? 'эту' : 'следующую').' неделю для '.$rodZnak.' появится немного позже. Приносим свои извинения.</strong></p>
	        </div>';

    } else {

        $options['content'] .= '<div class="goroskop_text">
            <img src="/bw15/images/horoscope/horoscopes/weekly-horoscope-'.$engZnak.'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.GlobalHelper::rusZodiac($zodiak).' Гороскоп на сегодня">
            <strong>Неделя:</strong> '.$weekInterval.'<br><br>
            <p>'.$horoscope->text.'</p>
	        </div>';

    }

    $znakSymbol = '&#98'.sprintf('%02d', ($zodiak-1)).';';
    $year = date('Y');
    $month = date('m');
    $options['content'] .= '<div class="goroskop_vse">
    <strong>Все гороскопы для представителей знака Зодиака <span style="text-decoration:underline">'.GlobalHelper::rusZodiac($zodiak).'</span>:</strong><br>';
    $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-zavtra/' . $engZnakTranslit . '/" title="">Гороскоп на завтра для ' . $rodZnak . ' »</a><br>';
    $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-segodnja/' . $engZnakTranslit . '/" title="">Гороскоп на сегодня для ' . $rodZnak . ' »</a><br>';
    if($week == 'next') {
        $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-nedelju/' . $engZnakTranslit . '/" title="">Гороскоп на неделю для ' . $rodZnak . ' »</a><br>';
    } else {
        $options['content'] .= $znakSymbol . ' <a href="/horoscope/na-sledujushhuju-nedelju/' . $engZnakTranslit . '/" title="">Гороскоп на следующую неделю для ' . $rodZnak . ' »</a><br>';
    }
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month).' '.$year.' для '.$rodZnak.' »</a><br>';
    if($month < 12) {
        $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month+1).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month+1).' '.$year.' для '.$rodZnak.' »</a><br>';
    }
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-god/'.$year.'/'.$engZnakTranslit.'/" title="">Гороскоп на '.$year.' год для '.$rodZnak.' »</a>
    </div>';
}



$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/horoscope/na-'.($week == 'this' ? 'nedelju' : 'sledujushhuju-nedelju').'/',
    'znak' => $zodiak,
    'week' => $week,
    'period' => \common\models\ar\Goroskop::PERIOD_WEEK
]);

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);