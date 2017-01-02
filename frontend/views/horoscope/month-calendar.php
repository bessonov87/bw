<?php
/**
 * @var \yii\web\View $this
 * @var int $year
 * @var int $month
 * @var string $monthEng
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => Html::a('Лунный календарь ' . $year, '/horoscope/lunnyj-kalendar-na-god/'), 'encode' => false];

$this->title = "Лунный календарь на ".GlobalHelper::rusMonth($month)." $year года. Благоприятные и неблагоприятные дни в ".GlobalHelper::rusMonth($month, 'p')." $year";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "лунный календарь, $year, Луна $year, знаки Зодиака, влияние Луны, лунный, календарь, Луна, дни, год, новолуние, календарь лунных дней $year, полнолуние, сутки, влияние, Зодиаки, месяц, положение"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Лунный календарь на ".GlobalHelper::rusMonth($month)." $year года. Календарь лунных дней и фазы Луны"
]);

// Добавляем canonical
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/moon-month-calendar', 'year' => $year, 'month' => $month])]);

$options = [
    'title' => "Лунный календарь на ".GlobalHelper::rusMonth($month)." $year года",
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';
$options['content'] = "
    <p> Рады представить вам лунный календарь на ".GlobalHelper::rusMonth($month)." $year года. Мы подготовили для вас таблицу,
    из которой вы сможете узнать фазы луны на этот месяц, лунные дни, соответствующие календарным дням. В конце статьи вы найдете 
    общую информацию о благоприятности того или иного дня в " . GlobalHelper::rusMonth($month, 'p') . ".</p>
    <p>&nbsp;</p>
    <div style='text-align:center;'><img src='/uploads/moon/calendar/$year-".sprintf('%02d', $month).".jpg' width='400' alt='{$options['title']}'></div>
	<p>&nbsp;</p>
	<p>Каждый из 30 лунных дней, представленных в лунном календаре, имеет некоторые свои особенности. Вы, наверняка, прекрасно
	  знаете, что каждые лунные сутки оказывают на людей определенное влияние. И астрологам уже с давних времен известно, когда это влияние 
	  является наиболее или наименее благоприятным, а также, какие дни и вовсе являются неблагоприятными. Это, безусловно, нужно 
	  учитывать при формировании своей жизни, особенно каких-то важных действий и планов. Информация поможет вам более четко 
	  планировать и контролировать ход событий.
	</p>
	<p>&nbsp;</p>
	<p>Время событий лунного календаря – <strong>московское</strong>. Если вы находитесь в другом часовом поясе, это 
	обязательно стоит учитывать. Прибавляйте или отнимайте свою разницу во времени.</p>
	<p>&nbsp;</p>
	<p>Время рядом со знаком Зодиака – точное время транзита Луны из одного знака в другой.</p>
	<p>&nbsp;</p>";

$options['content'] .= '<table class="table-bordered moon-month-table" width="100%">
<tr>
<th><strong>Дата</strong></th>
<th><strong>День<br>недели</strong></th>
<th><strong>Лунные сутки</strong></th>
<th><strong>Начало<br>суток</strong></th>
<th><strong>Луна в знаке</strong></th>
<th colspan="2"><strong>Фаза Луны</strong></th>
</tr>';
$moon_phases = [1 => 'Новолуние', 2 => '1 четверть', 3 => 'Полнолуние', 4 => '4 четверть'];
$daysInMonth = date('t', strtotime($year.'-'.sprintf('%02d', $month)));
$monthR = GlobalHelper::rusMonth($month, 'r');
for($x=1;$x<=$daysInMonth;$x++) {
    $date = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $x);
    //var_dump($monthData[$date]); die;
    $data = $monthData[$date];
    $dateText = $x . ' ' . $monthR;
    $dateLink = Html::a($dateText, ['horoscope/moon-day-calendar', 'year' => $year, 'month' => $monthEng, 'day' => $x]);
    //$moonDay = $data['moon_day'].'-е';
    $options['content'] .= '<tr>
        <td>'.$dateLink.'</td>
        <td>'.$data['moon_weekday'].'</td>
        <td>'.$data['moon_day'].'</td>
        <td>'.($data['moon_day_from'] === '00:00' ? '' : $data['moon_day_from']).'</td>
        <td>'.$data['moon_zodiak'].' '.($data['moon_zodiak_from_ut'] === '00:00' ? '' : 'с '.$data['moon_zodiak_from_ut']).'</td>
        <td><img src="/bw15/images/moon/'.$data['phase_image'].'.png" alt="" width="25"></td>
        <td>'.$data['moon_phase'].'</td>
    </tr>';
}
$options['content'] .= '</table><p>&nbsp;</p>';

$bad_array = array(1, 3, 5, 7);
$bad_days = '';
$all_days = [];
foreach($monthData as $date => $data) {
    list($y, $m, $d) = explode('-', $date);
    if(in_array($data['phase_image'], $bad_array)) $all_days[intval($d)] = 0;
    else $all_days[intval($d)] = 1;
}

//var_dump($all_days); die;

$last_day = $all_days[1];
$j = 1;
$f = 0;
$good_days = [];
foreach($all_days as $key => $one_day)
{
    $this_day = $one_day;
    if($f == 0 && $this_day == 1) $good_days[$j]['start'] = $key;
    else if($this_day == 1 && $this_day != $last_day) $good_days[$j]['start'] = $key;
    else if($this_day == 0 && $last_day = 1)
    {
        $bad_days .= $key . ", ";
        if($key != 1)
        {
            $good_days[$j]['finish'] = $key - 1;
            $j++;
        }
    }
    else if($this_day == 0) $bad_days .= $key . ", ";
    $last_day = $this_day;
    $f++;
}

$options['content'] .= \app\components\widgets\AdvertWidget::widget(['block_number' => 1]);

$options['content'] .= "<h3>Неблагоприятные дни " . GlobalHelper::rusMonth($month, 'r') . " " . $year . " года:</h3>" .
    substr($bad_days, 0, strlen($bad_days) - 2) . " " . GlobalHelper::rusMonth($month, 'r');
$options['content'] .= "<br /><br /><p>Эти дни очень рискованные и требуют большей, чем обычно осторожности и внимательности. Также неблагоприятные дни лунного календаря можно назвать стрессовыми, так как в это время возможно возникновение проблем со здоровьем и психологических проблемю Не стоить на это время планированить какие-то важные дела и начинания. Их лучше переносить на благоприятные периоды, особенно периоды растущей луны.</p>";
$options['content'] .= "<br /><h3>Благоприятные дни в " . GlobalHelper::rusMonth($month, 'p') . " " . $year . " года:</h3>";
$w = count($all_days);
foreach($good_days as $good_interval)
{
    if(!isset($good_interval['finish']) || !$good_interval['finish']) $good_interval['finish'] = $w-1;
    if($good_interval['start'] == $good_interval['finish']){
        $options['content'] .= $good_interval['finish'] . " " . GlobalHelper::rusMonth($month, 'r') . " " . $year . " года;<br />";
    } else {
        $options['content'] .= "с " . $good_interval['start'] . " по " . $good_interval['finish'] . " " . GlobalHelper::rusMonth($month, 'r') . " " . $year . " года;<br />";
    }
}

$options['content'] .= "<br /><p>Любые новые дела можно и даже нужно начинать в периоды растущей Луны. Это наиболее благоприятное время для абсолютно всех позитивных начинаний, будь то начала здорового и активного образа жизни, борьба с вредными привычками, диеты, новый бизнес, переход на новое место работы и т.д. Дела, начатые в этот период, обязательно принесут удачу. Результаты от таких начинаний будут только положительными. Однако стоит отметить, что все зависит не только от Луны, но и от вас самих. Луна может вам дать импульс и направление, но не даст вам все на \"блюдечке с голубой каёмочкой\".</p><br /><br />";

$options['similar'] = [];
if($month != date('m')){
    $m = date('m');
    $options['similar'][0]['url'] = Url::to(['horoscope/moon-month-calendar', 'year' => $year, 'month' => GlobalHelper::engMonth($m, 'i')]);
    $options['similar'][0]['title'] = 'Лунный календарь на '.GlobalHelper::rusMonth($m).' '.$year.' года';
    $options['similar'][1]['url'] = Url::to(['horoscope/hair-month-calendar', 'year' => $year, 'month' => GlobalHelper::engMonth($m, 'i')]);
    $options['similar'][1]['title'] = 'Лунный календарь стрижек на '.GlobalHelper::rusMonth($m).' '.$year.' года';
}
$options['similar'][2]['url'] = Url::to(['horoscope/hair-month-calendar', 'year' => $year, 'month' => GlobalHelper::engMonth($month, 'i')]);
$options['similar'][2]['title'] = 'Лунный календарь стрижек на '.GlobalHelper::rusMonth($month).' '.$year.' года';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);





















































