<?php
/**
 * @var \yii\web\View $this
 * @var int $year
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$this->title = "Лунный календарь на $year год. Влияние и фазы Луны";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "лунный календарь, $year, Луна $year, знаки Зодиака, влияние Луны, лунный, календарь, Луна, дни, год, новолуние, календарь лунных дней $year, полнолуние, сутки, влияние, Зодиаки, месяц, положение"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Лунный календарь на $year год. Календарь лунных дней и фазы Луны"
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/moon-calendar'])]);

$options = [
    'title' => $this->title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];


$options['content'] = '<table width="100%" class="moon_calendar_table">
    <tr>';
        for($x=1;$x<=12;$x++){
        $linkYear = $year;
        $linkText = 'Лунный календарь на '.GlobalHelper::rusMonth($x).' '.$linkYear.' года';
        if(isset($months[$linkYear][$x])) {
            $link = Html::a($linkText, "/horoscope/lunnyj-kalendar-na-god/$linkYear/" . GlobalHelper::engMonth($x) . '/');
        } else {
            $link = $linkText;
        }
        $options['content'] .= "<td>$link</td>";
        if($x % 2 == 0 && $x != 12){
        $options['content'] .= '</tr><tr>';
        }
        }
        $options['content'] .= '</tr>
</table>
<p>&nbsp;</p>';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);