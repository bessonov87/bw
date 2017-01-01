<?php
/**
 * @var \yii\web\View $this
 * @var array $today
 * @var array $tomorrow
 */

// ��� �������
$moon_phase = $phase_image[$moons[$today]['w']];
if($moon_phase == 1) $rost_moon = "���������";
if($moon_phase > 1 && $moon_phase < 5) $rost_moon = "���� ��������";
if($moon_phase == 1) $rost_moon = "����������";
if($moon_phase > 5) $rost_moon = "���� ���������";
$rost_moon_tomorrow = '';
$blago_moon_tomorrow = '';
// ��� ������
$moon_phase_tomorrow = $phase_image[$moons[$today]['w']+1];
if($moon_phase_tomorrow == 1) $rost_moon_tomorrow = "���������";
if($moon_phase_tomorrow > 1 && $moon_phase_tomorrow < 5) $rost_moon = "���� ��������";
if($moon_phase_tomorrow == 5) $rost_moon_tomorrow = "����������";
if($moon_phase_tomorrow > 5) $rost_moon_tomorrow = "���� ���������";

// ��� �������
if($moons[$today]['blago'] == 1) $blago_moon = "<span style=\"color:#090;font-size:16px;\">������������� ���� ��� �������</span>";
if($moons[$today]['blago'] == 2) $blago_moon = "<span style=\"color:#c00;font-size:16px;\">��������������� ���� ��� �������</span>";

// ��� ������
if($moons[$tomorrow]['blago'] == 1) $blago_moon_tomorrow = "<span style=\"color:#090;font-size:16px;\">������������� ���� ��� �������</span>";
if($moons[$tomorrow]['blago'] == 2) $blago_moon_tomorrow = "<span style=\"color:#c00;font-size:16px;\">��������������� ���� ��� �������</span>";

?>

<div align="center">
    <div class="today_box">
        <div class="today_up">
            <div id="moon_today" class="today_day today_active">�������</div>
            <div id="moon_tomorrow" class="today_day">������</div>
            <div style="clear:both;"></div>
        </div>
        <div id="today_block">
            <div class="today_info">
                <div class="today_moon">
                    <img src="/bw15/images/moon/phase_<?=$today['phase_image']?>.png" width="150">
                </div>
                <div class="today_moon_info">
                    <span style="font-size:16px;"><strong>����:</strong> <?=$today['moon_date']?> (<?=$today['moon_weekday']?>)</span><br />
                    <?=$today['moon_day']?> ������ ����<br />
                    <strong><?=$rost_moon?></strong><br />
                    ���� � ����� <?=$today['moon_zodiak']?><br />
                    <strong><?=$blago_moon?></strong>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div id="tomorrow_block">
            <div class="today_info">
                <div class="today_moon"><img src="/bw15/images/moon/phase_<?=$tomorrow['phase_image']?>.png" width="150"></div>
                <div class="today_moon_info">
                    <span style="font-size:16px;"><strong>����:</strong> <?=$tomorrow['moon_date']?> (<?=$tomorrow['moon_weekday']?>)</span><br />
                    <?=$tomorrow['moon_day']?> ������ ����<br />
                    <strong><?=$rost_moon_tomorrow?>'..'</strong><br />
                    ���� � ����� <?=$tomorrow['moon_zodiak']?><br />
                    <strong><?=$blago_moon_tomorrow?></strong>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>