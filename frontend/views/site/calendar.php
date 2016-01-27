<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\GlobalHelper;

if(!$noControls) {
    $controls = Html::tag('div', '<i class="fa fa-angle-double-left fa-lg"></i>', ['class' => 'calendar_control', 'id' => 'calendar-prev']);
    $controls .= Html::tag('div', '<i class="fa fa-angle-double-right fa-lg"></i>', ['class' => 'calendar_control', 'id' => 'calendar-next']);
}

list($year, $month) = explode('-', $date);
$daysInMonth = date('t', strtotime($date));

$dateOut = GlobalHelper::ucfirst(GlobalHelper::rusMonth($month)).' '.$year;
if(!empty($posts)){
    $dateOut = Html::a($dateOut, '/'.$year.'/'.$month.'/');
}

$calendar = '<div class="calendar_nowmonth">'.$dateOut.'</div>
<table class="calendar_table">
	    <tr>
	        <th class="weekday">Пн</th>
	        <th class="weekday">Вт</th>
	        <th class="weekday">Ср</th>
	        <th class="weekday">Чт</th>
	        <th class="weekday">Пт</th>
	        <th class="weekday">Сб</th>
	        <th class="weekday">Вс</th>
	    </tr><tr>';
for($i=1;$i<=$daysInMonth;$i++){
    $day = sprintf('%02d', $i);
    $dayOfWeek = date('w', strtotime("$year-$month-$day"));
    if(!$dayOfWeek) $dayOfWeek = 7; // Устанавливаем воскресенью 7 вместо 0
    if($i != 1 && $dayOfWeek == 1){
        $calendar .= '</tr><tr>';
    }
    if($i == 1 && $dayOfWeek != 1){
        for($j=1;$j<$dayOfWeek;$j++){
            $calendar .= '<td>&nbsp;</td>';
        }
    }



    if(!empty($posts[$i])){
        $link = '/'.$year.'/'.$month.'/'.$day.'/';
        $calendar .= '<td><a href="'.$link.'">'.$i.'</a></td>';
    } else {
        $calendar .= '<td>'.$i.'</td>';
    }

}
$calendar .= '</tr></table>';

//var_dump($posts);
$calendar .= Html::tag('div', $date, ['id' => 'calendar-current-date', 'style' => 'display:none;']);
$result = $controls . Html::tag('div', $calendar, ['class' => 'calendar_body']);
echo Html::tag('div', $result, ['class' => 'calendar_widget', 'id' => 'calendar_widget']);

?>