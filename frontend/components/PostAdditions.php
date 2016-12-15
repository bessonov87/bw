<?php

namespace app\components;

use yii\helpers\Html;
use common\models\ar\MoonCal;
use common\components\helpers\GlobalHelper;

/**
 * Class PostAdditions
 *
 * Методы для вставки дополнительного содержимого в полный текст статей в зависимости от их категорий и Id.
 * Метод вызываемый для вывода статей и вывода анонсов для конкретной категории задается в параметрах категории.
 * Метод, вызываемый при выводе статей должен начинаться со слова 'full', а вызываемый при выводе анонсов - со
 * слова 'short'.
 *
 * @package app\components
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class PostAdditions
{
    /**
     * Тестовый
     * @param $post
     */
    public static function fullFaceMask($post){
        $post->full .= '';
    }

    /**
     * Дополнение для лунного календаря стрижек и всех статей из данной категории
     *
     * @param object $post Объект класса Post (статья)
     */
    public static function fullMoonHair($post){
        // Если это не статья с ID 1266 (статья-категория)
        if($post->id != 1266){
            $nextMonthHairLink = '';
            $currentMonthMoon = '';
            $showCurrent = true;
            $showNext = true;
            $currentMonth = date('n');
            $currentYear = date('Y');
            $currentMonthHairLink = '';
            // Ссылка на календарь стрижек на текущий месяц
            $currentLink = AppData::getMoonHairLinks($currentYear, $currentMonth);
            // Проверяем id статьи по ссылке и, если он совпадает с id статьи, не выводим ссылку на текущий месяц
            $currentLinkId = substr($currentLink, 0, 4);
            if($currentLinkId == $post->id){
                $showCurrent = false;
            }
            // Блок со ссылкой на текущий месяц лунного календаря стрижек
            if($showCurrent && $currentLink){
                $currentMonthHairLink = '<li class="li_links">Благоприятные дни для стрижек на текущий месяц
                    <span class="span_links">
                        <a href="' . $currentLink . '">
                            Лунный календарь стрижек на ' . GlobalHelper::rusMonth($currentMonth) . ' ' . $currentYear . ' года
                        </a>
                    </span></li>';
            }

            // Определяем следующий месяц и год, если текущий месяц - декабрь
            if($currentMonth != 12){
                $nextMonth = $currentMonth + 1;
                $nextYear = $currentYear;
            } else {
                $nextMonth = 1;
                $nextYear = $currentYear + 1;
            }
            // Ссылка на календарь стрижек на текущий месяц
            $nextLink = AppData::getMoonHairLinks($nextYear, $nextMonth);
            // Проверяем id статьи по ссылке и, если он совпадает с id статьи, не выводим ссылку на текущий месяц
            $nextLinkId = substr($nextLink, 0, 4);
            if($nextLinkId == $post->id){
                $showNext = false;
            }
            // Блок со ссылкой на следующий месяц лунного календаря стрижек
            if($showNext && $nextLink){
                $nextMonthHairLink = '<li class="li_links">Когда стричь волосы в следующем месяце
                    <span class="span_links">
                        <a href="' . $nextLink . '">
                            Лунный календарь стрижек на ' . GlobalHelper::rusMonth($nextMonth) . ' ' . $nextYear . ' года
                        </a>
                    </span></li>';
            }
            // Блок со ссылкой на текущий месяц общего лунного календаря
            if($link = AppData::getMoonCalLinks($currentYear, $currentMonth)) {
                $currentMonthMoon = '<li class="li_links">Луна в знаках, фазы и лунные дни на текущий месяц
                    <span class="span_links">
                        <a href="' . $link . '">Лунный календарь на ' . GlobalHelper::rusMonth($currentMonth) . ' ' . $currentYear . ' года</a>
                    </span></li>';
            }

            $linksBlock = '<p>&nbsp;</p><ul class="ul_links"><h3>Актуальные календари</h3>' . $currentMonthHairLink . $nextMonthHairLink . $currentMonthMoon . '</ul>';

            $post->full .= $linksBlock;
        }
        // Иначе, если статья-категория (Id 1266)
        else if($post->id == 1266){

            $currentMonth = date('n');
            $currentYear = date('Y');
            $currentDay = date('d');
            $calCurrMonth = date('Y-m');
            $currCalText = '';
            $nextCalText = '';

            if($currentMonth != 12) {
                $nextMonth = $currentMonth + 1;
                $nextYear = $currentYear;
            } else {
                $nextMonth = 1;
                $nextYear = $currentYear + 1;
            }
            $calNextMonth = $nextYear . '-' . sprintf('%02D', $nextMonth);

            // Заголовок
            $topH2 = '<h2>Лунный календарь стрижек на ' . $currentYear . ' год. Благоприятные дни для стрижки волос в ' . $currentYear . ' году</h2>';
            $post->full = str_replace('{top_h2}', $topH2, $post->full);

            // Список ссылок на месяцы
            $moonCal = '<h2 align="center">Лунный календарь стрижек на ' . $currentYear . ' год по месяцам</h2>';

            $year = ($currentMonth == 12) ? $currentYear+1 : $currentYear;
            $allMonths = '';
            for($d=1;$d<=12;$d++) {
                $currentFlag = '';
                $calLinkClass = '';
                if($d == $currentMonth) {
                    $calLinkClass = '_big';
                    $currentFlag = '<strong>Сейчас:</strong> ';
                }
                if($d == 12) $year = $currentYear;
                $allMonths[] = $currentFlag.'<a href="'.AppData::getMoonHairLinks($year, $d).'" class="moon_link'.$calLinkClass.'">Лунный календарь стрижек на '.GlobalHelper::rusMonth($d).' '.$year.' года</a>';
            }

            $moonCal .= Html::ul($allMonths, ['encode' => false]) . '<p>&nbsp;</p>';

            $post->full .= $moonCal;

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

            $today = date("Y-m-d");
            $tomorrow = date('Y-m-d', time() + 86400);

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

            $today_box = '
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
					            <img src="/bw15/images/moon/phase_' . $phase_image[$moons[$today]['w']] . '.png" width="150">
					        </div>
					        <div class="today_moon_info">
						        <span style="font-size:16px;"><strong>Дата:</strong> ' . $moons[$today]['moon_date'] . ' (' . $moons[$today]['moon_weekday'] . ')</span><br />
                                ' . $moons[$today]['moon_day'] . ' лунный день<br />
                                <strong>'.$rost_moon.'</strong><br />
                                Луна в знаке ' . $moons[$today]['moon_zodiak'] . '<br />
                                <strong>'.$blago_moon.'</strong>
					</div>
					<div style="clear:both;"></div>
				</div>
				</div>
				<div id="tomorrow_block">
				    <div class="today_info">
					    <div class="today_moon"><img src="/bw15/images/moon/phase_' . $phase_image[$moons[$tomorrow]['w']] . '.png" width="150"></div>
					        <div class="today_moon_info">
						        <span style="font-size:16px;"><strong>Дата:</strong> ' . $moons[$tomorrow]['moon_date'] . ' (' . $moons[$tomorrow]['moon_weekday'] . ')</span><br />
						' . $moons[$tomorrow]['moon_day'] . ' лунный день<br />
						<strong>'.$rost_moon_tomorrow.'</strong><br />
						Луна в знаке ' . $moons[$tomorrow]['moon_zodiak'] . '<br />
						<strong>'.$blago_moon_tomorrow.'</strong>
					</div>
					<div style="clear:both;"></div>
				</div>
				</div>
			</div>
			<script>

			</script>
			</div>';

            $post->full = str_replace("[today]", $today_box, $post->full);
        }
    }

    /**
     * Дополнение для общего лунного календаря и всех статей из данной категории
     *
     * @param object $post Объект класса Post (статья)
     */
    public static function fullMoonCalendar($post) {
        if($post->id == 1758) {
            $currentYear = date('Y');
            $currentMonth = date('n');

            $calendarYear = ($currentMonth == 12) ? ++$currentYear : $currentYear;

            $moonCal = '<h2 align="center">Лунный календарь на ' . $calendarYear . ' год по месяцам</h2><br />
            <table width="100%" class="moon_calendar_table">
			<tr>';

            for($d=1;$d<=12;$d++)
            {
                if($currentMonth == 12 && $d == 12) {
                    $mLink = AppData::getMoonCalLinks($currentYear, $d);
                    $moonCal .= '<td><a href="'.$mLink.'">Лунный календарь на ' . GlobalHelper::rusMonth($d) . ' ' . $currentYear . ' года</a></td>';
                } else {
                    $mLink = AppData::getMoonCalLinks($calendarYear, $d);
                    $moonCal .= '<td><a href="'.$mLink.'">Лунный календарь на ' . GlobalHelper::rusMonth($d) . ' ' . $calendarYear . ' года</a></td>';
                }
                if($d % 2 == 0) $moonCal .= '</tr><tr>';
            }

            $moonCal .= '</tr></table><br />';

            $post->title = str_replace("YEAR", $calendarYear, $post->title);
            $post->full = str_replace("[YEAR]", $calendarYear, $post->full);
            $post->full = str_replace("[MOON-MONTH]", $moonCal, $post->full);
        }
    }
}