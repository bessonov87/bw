<?php
/**
 * @var \yii\web\View $this
 * @var array $today
 * @var array $tomorrow
 */

// Для Сегодня
$moon_phase = $phase_image[$moons[$today]['w']];
if($moon_phase == 1) $rost_moon = "Новолуние";
if($moon_phase > 1 && $moon_phase < 5) $rost_moon = "Луна Растущая";
if($moon_phase == 1) $rost_moon = "Полнолуние";
if($moon_phase > 5) $rost_moon = "Луна Убывающая";
$rost_moon_tomorrow = '';
$blago_moon_tomorrow = '';
// Для Завтра
$moon_phase_tomorrow = $phase_image[$moons[$today]['w']+1];
if($moon_phase_tomorrow == 1) $rost_moon_tomorrow = "Новолуние";
if($moon_phase_tomorrow > 1 && $moon_phase_tomorrow < 5) $rost_moon = "Луна Растущая";
if($moon_phase_tomorrow == 5) $rost_moon_tomorrow = "Полнолуние";
if($moon_phase_tomorrow > 5) $rost_moon_tomorrow = "Луна Убывающая";

// Для Сегодня
if($moons[$today]['blago'] == 1) $blago_moon = "<span style=\"color:#090;font-size:16px;\">Благоприятный день для стрижки</span>";
if($moons[$today]['blago'] == 2) $blago_moon = "<span style=\"color:#c00;font-size:16px;\">Неблагоприятный день для стрижки</span>";

// Для Завтра
if($moons[$tomorrow]['blago'] == 1) $blago_moon_tomorrow = "<span style=\"color:#090;font-size:16px;\">Благоприятный день для стрижки</span>";
if($moons[$tomorrow]['blago'] == 2) $blago_moon_tomorrow = "<span style=\"color:#c00;font-size:16px;\">Неблагоприятный день для стрижки</span>";

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
                    <img src="/bw15/images/moon/phase_<?=$today['phase_image']?>.png" width="150">
                </div>
                <div class="today_moon_info">
                    <span style="font-size:16px;"><strong>Дата:</strong> <?=$today['moon_date']?> (<?=$today['moon_weekday']?>)</span><br />
                    <?=$today['moon_day']?> лунный день<br />
                    <strong><?=$rost_moon?></strong><br />
                    Луна в знаке <?=$today['moon_zodiak']?><br />
                    <strong><?=$blago_moon?></strong>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div id="tomorrow_block">
            <div class="today_info">
                <div class="today_moon"><img src="/bw15/images/moon/phase_<?=$tomorrow['phase_image']?>.png" width="150"></div>
                <div class="today_moon_info">
                    <span style="font-size:16px;"><strong>Дата:</strong> <?=$tomorrow['moon_date']?> (<?=$tomorrow['moon_weekday']?>)</span><br />
                    <?=$tomorrow['moon_day']?> лунный день<br />
                    <strong><?=$rost_moon_tomorrow?>'..'</strong><br />
                    Луна в знаке <?=$tomorrow['moon_zodiak']?><br />
                    <strong><?=$blago_moon_tomorrow?></strong>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>