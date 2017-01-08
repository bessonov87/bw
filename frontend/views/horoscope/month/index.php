<?php
/**
 * @var \yii\web\View $this
 * @var int $year
 * @var int $currentYear
 * @var int $nextYear
 * @var int $zodiak
 * @var \common\models\ar\Goroskop $horoscope
 * @var array $monthsCurrentYear
 * @var array $monthsNextYear
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;

$period = $year ? $year.' год по месяцам' : 'месяц';

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$this->title = "Гороскопы на $period";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп на $period, события $period, Прогнозы, вопросы, предсказания астрологов"
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

$options['content'] = '<div style="margin-bottom: 20px;" class="goroskop_text"><img src="/bw15/images/horoscope/horoscopes/monthly-horoscope-all'.($year ? '-'.$year : '').'.png" style="float: left; padding-bottom: 8px; padding-right: 8px; " width="180" alt="Гороскоп '.$year.' по месяцам">';
if($horoscope) {
    $options['content'] .= GlobalHelper::getShortText(strip_tags($horoscope->text), 500).' ';
    $options['content'] .= Html::a("Читать далее Гороскоп на {$horoscope->year} год", '/horoscope/na-god/'.$horoscope->year.'/');
} else {
    $options['content'] .= '<p>Ежемесячный гороскоп дает представление о вероятных событиях и вызовах в течение определенного 
        месяца в году. Эти предсказания основаны на вашем знаке Зодиака и призваны дать вам информацию о возможностях и 
        конфликтах, которые могут вас ожидать в течение того или иного месяца.</p>
        <p>&nbsp;</p>
        <p>В отличие от ежедневных или еженедельных гороскопов, которые основаны на более коротких периодах времени, 
        ежемесячный гороскоп дает больше информации и большую перспективу. Этот тип гороскопа считается более полным и 
        обширным источником астрологического понимания. Ежемесячный гороскоп предоставляет различные сроки и варианты 
        для максимального расширения возможностей, а также помогает избежать проблем или, по крайней мере, 
        подготовиться к ним, предоставляя широкий спектр вариантов для вас рассмотреть при принятии решений.</p>
        <p>&nbsp;</p>
        <p>Миллионы людей по всему миру интересуются гороскопами, тысячи людей ежедневно читают гороскопы на нашем 
        сайте Beauty-Women.ru. Попробуйте и вы приобщиться к этому поистине захватывающему процессу. Мы уверены, что 
        сможем дать вам своеобразный планетарный старт в захватывающей игре жизни.</p>';
}
$options['content'] .= '</div>';

$widgetYear = $year ?: date('Y');
$widgetMonth = date('m');
$options['content'] .= '<div class="goroskop_vse">';
$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/horoscope/na-mesjac/'.$widgetYear.'/'.$widgetMonth.'/',
    'znak' => $zodiak,
    'year' => $widgetYear,
    'month' => $widgetMonth,
    'period' => \common\models\ar\Goroskop::PERIOD_MONTH
]);
$options['content'] .= '</div>';

if($monthsCurrentYear) {
    $options['content'] .= "<div><h3 style='text-align: center;'>Гороскоп на $currentYear год по месяцам</h3>";
    foreach ($monthsCurrentYear as $horo) {
        $options['content'] .= "<div class='month-horoscope-item well'><h5>Гороскоп на " . GlobalHelper::rusMonth($horo->month) . " {$horo->year} года</h5>
        <span>" . GlobalHelper::getShortText($horo->text, 400) . "</span>
        <a href='/horoscope/na-mesjac/{$horo->year}/" . sprintf('%02d', $horo->month) . "/' title='Гороскоп на " . GlobalHelper::rusMonth($horo->month) . " {$horo->year} года'>Далее >></a>
        </div>";
    }
    $options['content'] .= '</div>';
}

if($monthsNextYear){
    $options['content'] .= "<div class='goroskop_vse'><h4 style='text-align: center;'>Гороскоп на $nextYear год по месяцам</h4>";
    $items = [];
    foreach ($monthsNextYear as $horo) {
        $items[] = Html::a('Гороскоп на ' . GlobalHelper::rusMonth($horo->month) . ' ' . $horo->year . ' года', "/horoscope/na-mesjac/{$horo->year}/" . sprintf('%02d', $horo->month) . "/");
        /*$options['content'] .= "<div class='month-horoscope-item well'><h5>Гороскоп на " . GlobalHelper::rusMonth($horo->month) . " {$horo->year} года</h5>
        <span>" . GlobalHelper::getShortText($horo->text, 400) . "</span>
        <a href='/horoscope/na-mesjac/{$horo->year}/" . sprintf('%02d', $horo->month) . "/' title='Гороскоп на " . GlobalHelper::rusMonth($horo->month) . " {$horo->year} года'>Далее >></a>
        </div>";*/
    }
    $options['content'] .= Html::ul($items, ['encode' => false]);
    $options['content'] .= '</div>';
}

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);
