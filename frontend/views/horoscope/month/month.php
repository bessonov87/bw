<?php
/**
 * @var \yii\web\View $this
 * @var int $zodiak
 * @var \common\models\ar\Goroskop $horoscope
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;

$rodMonth = GlobalHelper::rusMonth($month, 'r');
$znakText = $zodiak ? GlobalHelper::rusZodiac($zodiak) : 'для всех знаков Зодиака';

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскопы на месяц', '/horoscope/na-mesjac/'), 'encode' => false];

$this->title = "Гороскоп на ".GlobalHelper::rusMonth($month)." $year года $znakText";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп на $month, события $rodMonth, Прогнозы, вопросы, предсказания астрологов, $znakText"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Астрологический прогноз на $month"
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
        <img src="/bw15/images/horoscope/horoscopes/monthly-horoscope-all.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.$this->title.'">';
    if(!$horoscope) {
        $options['content'] .= '<p>Хотите знать, какие события планируют для вас звезды в '.GlobalHelper::rusMonth($month, 'p').' '.$year.' года? 
            Если да, предлагаем вам ознакомиться с нашими астрологическими прогнозами. В этом разделе вы найдете гороскопы на каждый месяц 
            этого года для каждого из 12 знаков Зодиака. Если вам нужен более подробный и точный прогноз, можете ознакомиться с 
            <a href="/horoscope/na-nedelju/">гороскопом на неделю</a> или с <a href="/horoscope/na-den/">ежедневным гороскопом</a>. 
            Также на нашем сайте доступны прогнозы на весь '.$year.' год.</p>';
        $options['content'] .= '<p>&nbsp;</p>';
        $options['content'] .= '<p>Благодаря астрологическому прогнозу, который составляется специально для представителей каждого знака Зодиака, 
            вы можете узнать, чего вам ожидать в романтических отношениях, в работе, какие наиболее типичные проблемы со здоровьем могут появиться 
            у вас в течение '.$rodMonth.' '.$year.' года. Еще одной важной темой всех гороскопов является тема финансов. В общем, астропрогнозы 
            нацелены на выявление основных тенденций в практически каждой сфере нашей жизни. Выбирайте свой знак Зодиака, чтобы узнать, что вас ждет.</p>';
    } else {
        $options['content'] .= $horoscope->text;
    }
    $options['content'] .= '</div>';

} else {

    $engZnak = \common\components\AppData::$engZnaki[$zodiak];
    $engZnakTranslit = \common\components\AppData::$engZnakiTranslit[$zodiak];
    $rodZnak = GlobalHelper::rusZodiac($zodiak, 'r');

    $options['content'] .= '<div class="goroskop_text">
        <img src="/bw15/images/horoscope/horoscopes/monthly-horoscope-'.$engZnak.'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="'.$this->title.'">';
    if(!$horoscope) {
        $options['content'] .= '<p>Хотите знать, что планируют звезды для '.$rodZnak.' в '.GlobalHelper::rusMonth($month, 'p').' '.$year.' года? 
            Если да, предлагаем вам ознакомиться с нашими ежемесячными астрологическими прогнозами. Если вам нужен более подробный и точный прогноз, 
            можете ознакомиться с <a href="/horoscope/na-nedelju/">гороскопом на неделю</a> или с <a href="/horoscope/na-den/">ежедневным гороскопом</a>. 
            Также на нашем сайте доступны прогнозы на весь '.$year.' год.</p>';
        $options['content'] .= '<p>&nbsp;</p>';
        $options['content'] .= '<div class="alert alert-info"><strong>К сожалению прогноза на этот период еще нет. Гороскоп на '.$day.' для '.$rodZnak.' появится немного позже. Приносим свои извинения.</strong></div>';
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
    if($month < 12) {
        $options['content'] .= $znakSymbol.' <a href="/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month+1).'/'.$engZnakTranslit.'/" title="">Гороскоп на '.GlobalHelper::rusMonth($month+1).' '.$year.' для '.$rodZnak.' »</a><br>';
    }
    $options['content'] .= $znakSymbol.' <a href="/horoscope/na-god/'.$year.'/'.$engZnakTranslit.'/" title="">Гороскоп на '.$year.' год для '.$rodZnak.' »</a>
    </div>';
}

$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/horoscope/na-mesjac/'.$year.'/'.sprintf('%02d', $month).'/',
    'znak' => $zodiak,
    'year' => $year,
    'month' => $month,
    'period' => \common\models\ar\Goroskop::PERIOD_MONTH
]);

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);