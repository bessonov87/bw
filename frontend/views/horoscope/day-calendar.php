<?php
/**
 * @var \yii\web\View $this
 * @var integer $year
 * @var integer $month
 * @var integer $day
 * @var array $month_array
 * @var array $moonCalTodayTomorrow
 * @var string $monthEng
 */

use common\components\helpers\GlobalHelper;
use yii\helpers\Html;
use app\components\widgets\AdvertWidget;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => Html::a('Лунный календарь ' . $year, '/horoscope/lunnyj-kalendar-na-god/'), 'encode' => false];

$daysInMonth = date('t', strtotime($year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $day)));
$month_num_02d = sprintf('%02d', $month);
$this_date = $day . "." . $month_num_02d . "." . $year;
$month_rus_rod = GlobalHelper::rusMonth($month, 'r');
$this_text_date = $day . " " . $month_rus_rod . " " . $year . " года";
$moonDate = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $day);
$month_rus = GlobalHelper::rusMonth($month);
$month_rus_big = GlobalHelper::ucfirst($month_rus);

$art_title = $this_text_date . " в лунном календаре. Влияние и фазы Луны на " . $this_date;
$art_metatitle = $art_title . ". Лунный день и знак Зодиака";

$this->title = $art_title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "лунный календарь на день, лунный календарь, $year, Луна $year, знаки Зодиака, влияние Луны, лунный, календарь, Луна, дни, год, новолуние, календарь лунных дней $year, полнолуние, сутки, влияние, Зодиаки, месяц, положение"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => $art_metatitle
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/moon-calendar'])]);

$options = [
    'title' => $art_title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

$lunar_day = $month_array[$moonDate]['moon_day'];
$lunar_day_start = $month_array[$moonDate]['moon_day_from'];
$lunar_day_sunset = $month_array[$moonDate]['moon_day_sunset'];
$moon_zodiak = $month_array[$moonDate]['moon_zodiak'];
$moon_faza = $month_array[$moonDate]['phase_image'];
$lunar_percent = $month_array[$moonDate]['moon_percent'];

$phases_array = array(1 => "Новолуние", "Растущая Луна", "Первая четверть (Растущая Луна)", "Растущая Луна", "Полнолуние", "Убывающая Луна", "Последняя четверть (Убывающая Луна)", "Убывающая Луна");

// Ссылка на календарь этого месяца
$this_month_cal_link = \yii\helpers\Url::to(['horoscope/moon-month-calendar', 'year' => $year, 'month' => $monthEng]);

$art_short = $art_descr = 'Всю информацию о положении Луны и ее влиянии на человека '.$this_text_date.' можно найти в этой статье';

$art_h2 = "Лунный день и фаза луны " . $this_text_date;

$options['content'] .= "<p>На этой странице вы найдете информацию о фазах Луны, лунном дне, восходе и закате Луны на " . $this_text_date . ". Также мы представим вам характеристику этого дня по лунному календарю в зависимости от того, растущая Луна или убывающая и в каком знаке Зодиака она находится. На основании этой информации вы сможете определить, является ли день " . $this_date . " благоприятным или нет. Краткие характеристики всех дней на этот месяц вы можете посмотреть в <a href=\"" . $this_month_cal_link . "\">лунном календаре на " . $month_rus . " " . $year . " года</a>.</p>";
$options['content'] .= "<h2>$art_h2</h2>";
$options['content'] .= "<p><strong>Обратите внимание</strong> на то, что время, указанное для начала лунных фаз, дней и транзита Луны в знаки Зодиака, московское. Для других часовых поясов данные могут существенно отличаться.</p>";
$options['content'] .= AdvertWidget::widget(['block_number' => 2]);

$options['content'] .= "<div class=\"info_moonday_block\"><p align=\"center\" style=\"font-size:1.5em;\"><strong>" . $this_date . "</strong></p>";
$options['content'] .= "<p><strong>" . $lunar_day . " лунный день</strong> с " . $lunar_day_start . " МСК.</p>";
$options['content'] .= "<p>Знак Зодиака: <strong>" . $moon_zodiak . "</strong>.</p>";
$options['content'] .= "<p align=\"center\"><img src=\"/bw15/images/moon/phase_" . $moon_faza . ".png\" width=\"100\"></p>";
$options['content'] .= "<p>Луна находится в фазе <strong>" . $phases_array[$moon_faza] . "</strong>.</p>";
$options['content'] .= "<p>Восход Луны в " . $lunar_day_start . ". Закат в " . $lunar_day_sunset . ".</p>";
$options['content'] .= "<p>Процент видимости Луны: <strong>" . $lunar_percent . "%</strong>.</p>";
$options['content'] .= "</div><div style=\"clear:both;\"></div>";
$options['content'] .= "<h3>Влияние Луны на человека " . $this_text_date . "</h3>";

$options['content'] .= "<p style=\"padding:5px 0 10px 0;\">Луна в знаке Зодиака <strong>" . $moon_zodiak . "</strong>. " . $znaki_blago . "</p>";
$options['content'] .= "<p>" . nl2br($znaki_text) . "</p><p>&nbsp;</p>";
$options['content'] .= "<p style=\"padding:5px 0 10px 0;\">" . $this_date . " идет <strong>" . $lunar_day . " лунный день</strong>. " . $dni_blago . "</p>";
$options['content'] .= "<p>" . nl2br($dni_text) . "</p><p>&nbsp;</p>";
$options['content'] .= "<p style=\"padding:5px 0 10px 0;\">В этот день Луна находится в фазе <strong>" . $phases_array[$moon_faza] . "</strong>. " . $fazy_blago . "</p>";
$options['content'] .= "<p>" . nl2br($fazy_text) . "</p><p>&nbsp;</p>";
$options['content'] .= "<p style=\"color:#777;\"><strong>Важно:</strong> Для определения благоприятности дня наивысший приоритет по важности имеет нахождение Луны в том или ином знаке Зодиака. Следующим в расчет берется лунный день, а затем фаза Луны. Например, если транзит Луны через знак Зодиака характеризует день, как неблагоприятный, то он будет таким, даже если лунный день и фаза говорят о положительном влиянии.</p>";
$options['content'] .= "<p>&nbsp;</p><p>".AdvertWidget::widget(['block_number' => 1])."</p><p>&nbsp;</p>";
$options['content'] .= "<h3>Весь календарь с фазами Луны на " . $month_rus_big . " " . $year . " года</h3>";
$options['content'] .= "<p>Выбирайте интересующий вас день, и вы всегда будет в курсе того, что вам готовит Луна. Обладая этой информацией, вы сможете заранее спланировать свой день и определить, что нужно делать, а что нельзя. Также вы будете точно знать чего стоит опасаться и чего остерегаться. Если вы будете стоить свои планы по лунному календарю, то сможете избежать множества потенциальных проблем.</p><p>&nbsp;</p>";
$options['content'] .= "<table width=\"644\" class=\"moon_month_table\">";

    // Определяем день недели первого дня месяца
    $first_day = $year . "-" . $month_num_02d . "-01";
    $days_in_month = date("t", strtotime($first_day));
    $first_day_weekday = date("w", strtotime($first_day));
    if($first_day_weekday == 0) $first_day_weekday = 7;

    // Определяем количество дней, которые будут выводиться в таблице, включая пустые дни, чтобы заполнить первую и последнюю строки
    // Для начала прибавляем к количеству дней в месяце количество дней отступа в зависимости от дня недели первого дня месяца
    $days_in_table = $days_in_month + ($first_day_weekday - 1);
    // Далее определяем остаток от деления на 7, чтобы определить сколько пустых ячеек нужно оставить в конце
    $ostatok = $days_in_table % 7;
    if($ostatok) $days_in_table = $days_in_table + (7 - $ostatok);

    $day_out = 0;
    $tr_num = 0;	// Номер строки
    for($x=1;$x<=$days_in_table;$x++)
    {
        // На первой и на каждой восьмой ячейке открываем строку
        if($x == 1 || $x % ($tr_num*7 + 1) == 0) { $options['content'] .= "<tr>"; $tr_num++; }

        if($day_out <= $days_in_month)
        {
            $calLink = '/horoscope/lunnyj-kalendar-na-god/'.$year.'/'.$monthEng.'/'.$x.'/';
            if($x == $first_day_weekday)
            {
                $day_out = 1;
                $date_out = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $day_out);
                $options['content'] .= "<td width=\"92\"><img src=\"/bw15/images/moon/" . $month_array[$date_out]['phase_image'] . ".png\" width=\"30\"><br />
				<a href=\"" . $calLink . "\">" . $day_out . " " . $month_rus_rod . "</a><br />
				" . $phases_array[$month_array[$date_out]['phase_image']] . "<br />" . $month_array[$date_out]['moon_day'] . " лунный день</td>";
            }
            else if($x != $first_day_weekday && $day_out)
            {
                $date_out = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $day_out);
                $options['content'] .= "<td width=\"92\"><img src=\"/bw15/images/moon/" . $month_array[$date_out]['phase_image'] . ".png\" width=\"30\"><br />
				<a href=\"" . $calLink . "\">" . $day_out . " " . $month_rus_rod . "</a><br />
				" . $phases_array[$month_array[$date_out]['phase_image']] . "<br />" . $month_array[$date_out]['moon_day'] . " лунный день</td>";
            }
            else if($x != $first_day_weekday && !$day_out)
            {
                $options['content'] .= "<td width=\"92\">&nbsp;</td>";
            }
        }
        else
        {
            $options['content'] .= "<td width=\"92\">&nbsp;</td>";
        }

        if($day_out) $day_out++;
        // После каждой 7 ячейки закрываем строку
        if($x % 7 == 0) $options['content'] .= "</tr>";
    }

    $options['content'] .= "</table><p>&nbsp;</p>";

    /*echo 'h2: ' . $art_h2 . '<br>';
    echo 'Metatitle: ' . $art_metatitle . '<br>';
    echo 'Full: ' . $options['content'] . '<br>';*/

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);