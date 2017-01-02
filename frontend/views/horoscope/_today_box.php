<?php
/**
 * @var \yii\web\View $this
 * @var array $today
 * @var array $tomorrow
 */

use common\models\MoonCal;
use common\components\helpers\GlobalHelper;

// БЛОК СЕГОДНЯ
// Основной запрос
$moonQuery = MoonCal::find();
$weekDays = [0 => "Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"];
$firstMoonPhase = 0;
$currentMonthDays = date('t');
$currentDay = date('j');
$monthYear = date('Y-m');
$moonQuery->where("to_char(date, 'YYYY-mm') = '$monthYear'");
$nextMonthYear = date('Y-m', strtotime($monthYear) + 2764800);
// Если сейчас последний день месяца
if($currentDay == $currentMonthDays){
    $moonQuery->orWhere("to_char(date, 'YYYY-mm') = '$nextMonthYear'");
}
$moonCalDays = $moonQuery->orderBy('date')->asArray()->all();

//var_dump($moonCalDays); die;

$phase_image_num = 0;
$w = 0;
$phase_image = [];
$moons = [];
foreach($moonCalDays as $rows_moon){
    $w++;
    $moon_date_base = $rows_moon['date'];
    $moons[$moon_date_base]['w'] = $w;
    $moons[$moon_date_base]['moon_date'] = date("j", strtotime($moon_date_base)) . " " . GlobalHelper::rusMonth(date("n", strtotime($moon_date_base))) . " " . date("Y", strtotime($moon_date_base));
    $moons[$moon_date_base]['moon_day'] = $rows_moon['moon_day'];
    $moons[$moon_date_base]['moon_day_from'] = substr($rows_moon['moon_day_from'], 0, 5);
    $moons[$moon_date_base]['moon_day2'] = $rows_moon['moon_day2'];
    $moons[$moon_date_base]['moon_day2_from'] = substr($rows_moon['moon_day2_from'], 0, 5);
    $moons[$moon_date_base]['moon_zodiak'] = GlobalHelper::rusZodiac($rows_moon['zodiak']);
    $moons[$moon_date_base]['moon_zodiak_from_ut'] = substr($rows_moon['zodiak_from_ut'], 0, 5);
    $moons[$moon_date_base]['moon_phase'] = $rows_moon['phase'];
    $moons[$moon_date_base]['$moon_phase_from'] = substr($rows_moon['phase_from'], 0, 5);
    $moons[$moon_date_base]['blago'] = $rows_moon['blago'];

    $moons[$moon_date_base]['moon_weekday'] = $weekDays[date("w", strtotime($moon_date_base))];

    if($rows_moon['moon_day2']) $moons[$moon_date_base]['moon_day'] = $moons[$moon_date_base]['moon_day'] . "/" . $moons[$moon_date_base]['moon_day2'];

    if($moons[$moon_date_base]['moon_phase'])
    {
        $firstMoonPhase++;
        $phase_image_num = $moons[$moon_date_base]['moon_phase'] * 2 - 1;
        $phase_image[$w] = $phase_image_num;
        if($firstMoonPhase == 1 && $w != 1)
        {
            $w_difference = $w - 1;
            for($e=1;$e<=$w_difference;$e++)
            {
                if($phase_image_num != 1) $phase_image[$e] = $phase_image_num - 1;
                else $phase_image[$e] = 8;
            }
        }

        //$moon_phase = $moon_phases[$moon_phase] . " с " . $moon_phase_from;
    }
    else
    {
        //$moon_phase = "";
        $phase_image[$w] = $phase_image_num + 1;
    }

}

if($moons && $phase_image) {

    $today = date("Y-m-d");
    $tomorrow = date('Y-m-d', time() + 86400);

    // Для Сегодня
    $moon_phase = $phase_image[$moons[$today]['w']];
    if ($moon_phase == 1) $rost_moon = "Новолуние";
    if ($moon_phase > 1 && $moon_phase < 5) $rost_moon = "Луна Растущая";
    if ($moon_phase == 1) $rost_moon = "Полнолуние";
    if ($moon_phase > 5) $rost_moon = "Луна Убывающая";
    $rost_moon_tomorrow = '';
    $blago_moon_tomorrow = '';
    // Для Завтра
    $moon_phase_tomorrow = $phase_image[$moons[$today]['w'] + 1];
    if ($moon_phase_tomorrow == 1) $rost_moon_tomorrow = "Новолуние";
    if ($moon_phase_tomorrow > 1 && $moon_phase_tomorrow < 5) $rost_moon = "Луна Растущая";
    if ($moon_phase_tomorrow == 5) $rost_moon_tomorrow = "Полнолуние";
    if ($moon_phase_tomorrow > 5) $rost_moon_tomorrow = "Луна Убывающая";

    // Для Сегодня
    if ($moons[$today]['blago'] == 1) $blago_moon = "<span style=\"color:#090;font-size:16px;\">Благоприятный день для стрижки</span>";
    if ($moons[$today]['blago'] == 2) $blago_moon = "<span style=\"color:#c00;font-size:16px;\">Неблагоприятный день для стрижки</span>";

    // Для Завтра
    if ($moons[$tomorrow]['blago'] == 1) $blago_moon_tomorrow = "<span style=\"color:#090;font-size:16px;\">Благоприятный день для стрижки</span>";
    if ($moons[$tomorrow]['blago'] == 2) $blago_moon_tomorrow = "<span style=\"color:#c00;font-size:16px;\">Неблагоприятный день для стрижки</span>";

?>
<div align="center">
    <div class="today_box">
        <div class="today_up">
            <div id="moon_today" class="today_day today_active">Сегодня</div>
            <div id="moon_tomorrow" class="today_day">Завтра</div>
            <div style="clear:both;"></div>
        </div>
    <div id="today_block">
        <div class="today_info">
            <div class="today_moon">
                <img src="/bw15/images/moon/phase_<?=$phase_image[$moons[$today]['w']]?>.png" width="150">
            </div>
            <div class="today_moon_info">
                <span style="font-size:16px;"><strong>Дата:</strong> <?=$moons[$today]['moon_date']?> (<?=$moons[$today]['moon_weekday']?>)</span><br />
                <?=$moons[$today]['moon_day']?> лунный день<br />
                <strong><?=$rost_moon?></strong><br />
                Луна в знаке <?=$moons[$today]['moon_zodiak']?><br />
                <strong><?=$blago_moon?></strong>
    </div>
    <div style="clear:both;"></div>
</div>
</div>
<div id="tomorrow_block">
    <div class="today_info">
        <div class="today_moon"><img src="/bw15/images/moon/phase_<?=$phase_image[$moons[$tomorrow]['w']]?>.png" width="150"></div>
            <div class="today_moon_info">
                <span style="font-size:16px;"><strong>Дата:</strong> <?=$moons[$tomorrow]['moon_date']?> (<?=$moons[$tomorrow]['moon_weekday']?>)</span><br />
        <?=$moons[$tomorrow]['moon_day']?> лунный день<br />
        <strong><?=$rost_moon_tomorrow?></strong><br />
        Луна в знаке <?=$moons[$tomorrow]['moon_zodiak']?><br />
        <strong><?=$blago_moon_tomorrow?></strong>
    </div>
    <div style="clear:both;"></div>
</div>
</div>
</div>
</div>

<?php } ?>