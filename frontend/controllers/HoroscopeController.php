<?php
namespace frontend\controllers;

use app\components\AppData;
use app\components\GlobalHelper;
use app\models\MoonCal;
use frontend\models\Post;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HoroscopeController extends Controller
{
    public function getViewPath() {
        return '@app/views/post';
    }

    public function actionMonth() {
        $month = Yii::$app->request->get('month');
        $moonMonthNum = GlobalHelper::engMonth($month, 'i', true);

        // Если номер месяца не определен, выбрасываем ошибку 404
        if(!$moonMonthNum) throw new NotFoundHttpException('Страница не найдена');

        // Определяем текущий год. Если сейчас декабрь, выводим следующий год
        $moonYear = (date('m') == 12 && $moonMonthNum != 12) ? date('Y')+1 : date('Y');

        // Ссылки на лунные календари стрижек
        $moonHairLinks = AppData::getMoonHairLinks($moonYear);

        // Дата для запроса
        $moonMonthYear = $moonYear.'-'.sprintf("%02d", $moonMonthNum);

        // Получаем данные на данный месяц
        $moonCal = MoonCal::find()
            ->where("date_format(date, '%Y-%m') = '$moonMonthYear'")
            ->orderBy('date')
            ->asArray()
            ->all();

        // Создаем объект класса Post и записываем в него необходимые для рендеринга данные
        $post = new Post();
        $post->title = "Лунный календарь на " . GlobalHelper::rusMonth($moonMonthNum) . " " . $moonYear . " года";
        $post->date = ($moonYear - 1).'-12-01 00:00:00';

        /* Todo: Каким-то образом засунуть ссылку на лунный календарь стрижек в similarPosts */

        $post->full = '<p>Ниже представлен подробный лунный календарь на ' . GlobalHelper::rusMonth($moonMonthNum) . ' ' . $moonYear . ' года. Исходя из представленных данных вы сможете узнать фазы луны на этот месяц, лунные дни, соответствующие календарным дням, а также общую информацию о благоприятности того или иного дня в ' . GlobalHelper::rusMonth($moonMonthNum, 'p') . '.</p>
            <p>&nbsp;</p>
            <p>Каждый из 30 лунных дней, представленных в лунном календаре, имеет некоторые свои особенности. Каждый из дней оказывает на человека определенное влияние, которое может быть как благоприятным, так и совсем отрицательным. Это, безусловно, нужно учитывать при формировании своей жизни, особенно каких-то важных действий и планов. Информация поможет вам более четко планировать и контролировать ход событий.</p>
            <p>&nbsp;</p>
            <p>Время событий лунного календаря – <strong>московское</strong>. Если вы проживаете в другом часовом поясе, это обязательно стоит учитывать. Прибавляйте или отнимайте свою разницу во времени.</p>
            <p>&nbsp;</p>
            <p>Время рядом со знаком Зодиака – точное время транзита Луны из одного знака в другой.</p>
            <p>&nbsp;</p>';

	    if($moonCal){
            $post->full .= '<table width="100%" cellpadding="10" cellspacing="0" border="1">
		    <tr><td><strong>Дата</strong></td><td><strong>День<br />недели</strong></td><td><strong>Лунные сутки</strong></td><td><strong>Начало<br />суток</strong></td><td><strong>Луна в знаке</strong></td><td colspan=\"2\"><strong>Фаза Луны</strong></td></tr>';

            $weekdays = array(0 => "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");
            $moon_phases = array(1 => "Новолуние", "Первая<br />четверть", "Полнолуние", "Последняя<br />четверть");
            $first_moon_phase = 0;

            foreach($moonCal as $row){
                $moonDayLink = "/horoscope/lunnyj-kalendar-na-god/" . date("j", strtotime($row['date'])) . "_" . GlobalHelper::engMonth(date("n", strtotime($row['date'])), 'r') . "_" . date("Y", strtotime($row['date'])) . "_goda.html";
                $moonDate = date("j", strtotime($row['date'])) . " " . GlobalHelper::rusMonth(date("m", strtotime($row['date'])), 'r');
                $moonWeekday = $weekdays[date("w", strtotime($row['date']))];
                $moonDay = ($row['moon_day2']) ? $row['moon_day'].'/'.$row['moon_day2'] : $row['moon_day'];
                $moonDayFrom = substr($row['moon_day_from'], 0, 5);

                $post->full .= "<tr><td><a href=\"" . $moonDayLink . "\">$moonDate</a></td>
                    <td>$moonWeekday</td>
                    <td>$moonDay-е</td>
                    <td>$moonDayFrom</td>
                    <td>$moon_zodiak</td><td>[image-$w]</td><td>$moon_phase</td></tr>";
            }
        }

        $post->full .= "</table><br /><br />";

        return $post->full;

        return 'Bla-Dla-Vla-'.$month.'-'.$moonYear;
    }

    public function actionDay() {
        return 'Fla-Tla-Hla-'.Yii::$app->request->get('day').'-'.Yii::$app->request->get('month').'-'.Yii::$app->request->get('year');
    }

    public function actionOgorod() {
        return 'Gla-Ola-Pla-'.Yii::$app->request->get('month');
    }

}