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

        // Записываем id текущей категории в виде массива в глобальный параметр
        Yii::$app->params['category'] = [47];

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
        $post->id = 999999;
        $post->title = "Лунный календарь на " . GlobalHelper::rusMonth($moonMonthNum) . " " . $moonYear . " года";
        $post->date = ($moonYear - 1).'-12-01 00:00:00';

        /* Todo: Каким-то образом засунуть ссылку на лунный календарь стрижек в similarPosts */
        $similarPost = new Post();
        $similarPost->title = 'Лунный календарь стрижек на ' . GlobalHelper::rusMonth($moonMonthNum) . ' ' . $moonYear . ' года';
        $similarPost->url = AppData::getMoonHairLinks($moonYear, $moonMonthNum);

        $post->similarPosts = [0 => $similarPost];

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
		    <tr><td><strong>Дата</strong></td><td><strong>День<br />недели</strong></td><td><strong>Лунные сутки</strong></td><td><strong>Начало<br />суток</strong></td><td><strong>Луна в знаке</strong></td><td colspan="2"><strong>Фаза Луны</strong></td></tr>';

            $weekdays = array(0 => "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");
            $moonPhases = array(1 => "Новолуние", "Первая<br />четверть", "Полнолуние", "Последняя<br />четверть");
            $firstMoonPhase = 0;
            $w = 1;
            $phaseImageNum = 0;

            foreach($moonCal as $row){
                $moonDayLink = "/horoscope/lunnyj-kalendar-na-god/" . date("j", strtotime($row['date'])) . "_" . GlobalHelper::engMonth(date("n", strtotime($row['date'])), 'r') . "_" . date("Y", strtotime($row['date'])) . "_goda.html";
                $moonDate = date("j", strtotime($row['date'])) . " " . GlobalHelper::rusMonth(date("m", strtotime($row['date'])), 'r');
                $moonWeekday = $weekdays[date("w", strtotime($row['date']))];
                $moonDay = ($row['moon_day2']) ? $row['moon_day'].'/'.$row['moon_day2'] : $row['moon_day'];
                $moonDayFrom = substr($row['moon_day_from'], 0, 5);
                $moonZodiac = GlobalHelper::rusZodiac($row['zodiak']);
                $moonZodiacFromUt = substr($row['zodiak_from_ut'], 0, 5);
                if($moonZodiacFromUt != "00:00") $moonZodiac = $moonZodiac . " с " . $moonZodiacFromUt;
                $moonPhase = $row['phase'];
                $moonPhaseFrom = substr($row['phase_from'], 0, 5);

                // Определяем фазу Луны
                if($moonPhase) {
                    $firstMoonPhase++;
                    $phaseImageNum = $moonPhase * 2 - 1;
                    $phaseImage[$w] = $phaseImageNum;
                    if($firstMoonPhase == 1 && $w != 1)
                    {
                        $wDifference = $w - 1;
                        for($e=1;$e<=$wDifference;$e++)
                        {
                            if($phaseImageNum != 1) $phaseImage[$e] = $phaseImageNum - 1;
                            else $phaseImage[$e] = 8;
                        }
                    }
                    $moonPhase = $moonPhases[$moonPhase] . " с " . $moonPhaseFrom;
                }
                else
                {
                    $moonPhase = "";
                    $phaseImage[$w] = $phaseImageNum + 1;
                }

                $post->full .= "<tr><td><a href=\"" . $moonDayLink . "\">$moonDate</a></td>
                    <td>$moonWeekday</td>
                    <td>$moonDay-е</td>
                    <td>$moonDayFrom</td>
                    <td>$moonZodiac</td>
                    <td>[image-$w]</td>
                    <td>$moonPhase</td>
                    </tr>";
                $w++;
            }


        }

        $post->full .= "</table><p>&nbsp;</p>[yandex]<p>&nbsp;</p>";

        // Определяем изображения для изображения фазы Луны
        $badArray = array(1, 3, 5, 7);
        $numDays = count($moonCal);
        for($w=1;$w<=$numDays;$w++)
        {

            if(in_array($phaseImage[$w], $badArray)) $allDays[$w] = 0;
            else $allDays[$w] = 1;
            $post->full = str_replace("[image-$w]", '<img src="/bw15/images/moon/' . $phaseImage[$w] . '.png" width="25">', $post->full);
        }

        // Благоприятные и неблагоприятные дни
        $lastDay = $allDays[0];
        $j = 1;
        $f = 0;
        $badDays = '';
        foreach($allDays as $key => $oneDay)
        {
            $thisDay = $oneDay;
            if($f == 0 && $thisDay == 1) $goodDays[$j]['start'] = $key;
            else if($thisDay == 1 && $thisDay != $lastDay) $goodDays[$j]['start'] = $key;
            else if($thisDay == 0 && $lastDay = 1)
            {
                $badDays .= $key . ", ";
                if($key != 1)
                {
                    $goodDays[$j]['finish'] = $key - 1;
                    $j++;
                }
            }
            else if($thisDay == 0) $badDays .= $key . ", ";
            $lastDay = $thisDay;
            $f++;
        }

        $post->full .= "<h3>Неблагоприятные дни " . GlobalHelper::rusMonth($moonMonthNum, 'r') . " " . $moonYear . " года:</h3>" . substr($badDays, 0, strlen($badDays) - 2) . " " . GlobalHelper::rusMonth($moonMonthNum, 'r');
        $post->full .= "<br /><br /><p>Эти дни очень рискованные и требуют большей, чем обычно осторожности и внимательности. Также неблагоприятные дни лунного календаря можно назвать стрессовыми, так как в это время возможно возникновение проблем со здоровьем и психологических проблем. Не стоит на это время планировать какие-то важные дела и начинания. Их лучше переносить на благоприятные периоды, особенно периоды растущей луны.</p>";
        $post->full .= "<br /><h3>Благоприятные дни " . GlobalHelper::rusMonth($moonMonthNum, 'r') . " " . $moonYear . " года:</h3>";
        $post->full .= '<ul>';
        foreach($goodDays as $goodInterval)
        {
            if(!$goodInterval['finish']) $goodInterval['finish'] = $w-1;
            if($goodInterval['start'] == $goodInterval['finish']) $post->full .= '<li>'. $goodInterval['finish'] . " " . GlobalHelper::rusMonth($moonMonthNum, 'r') . " " . $moonYear . " года;</li>";
            else $post->full .= "<li>с " . $goodInterval['start'] . " по " . $goodInterval['finish'] . " " . GlobalHelper::rusMonth($moonMonthNum, 'r') . " " . $moonYear . " года;</li>";
        }
        $post->full .= '</ul>';

        $post->full .= "<p>Любые новые дела можно и даже нужно начинать в периоды растущей Луны. Это наиболее благоприятное время для абсолютно всех позитивных начинаний, будь то начала здорового и активного образа жизни, борьба с вредными привычками, диеты, новый бизнес, переход на новое место работы и т.д. Дела, начатые в этот период, обязательно принесут удачу. Результаты от таких начинаний будут только положительными. Однако стоит отметить, что все зависит не только от Луны, но и от вас самих. Луна может вам дать импульс и направление, но не даст вам все на \"блюдечке с голубой каёмочкой\". Здесь можно даже перефразировать известную поговорку: \"На Луну надейся, а сам не плошай\".</p><br />";

        //return $this->render('full', ['post' => $post, 'manualSimilar' => true]);
        return $post->full;
        //return 'Bla-Dla-Vla-'.$month.'-'.$moonYear;
    }

    public function actionDay() {
        return 'Fla-Tla-Hla-'.Yii::$app->request->get('day').'-'.Yii::$app->request->get('month').'-'.Yii::$app->request->get('year');
    }

    public function actionOgorod() {
        return 'Gla-Ola-Pla-'.Yii::$app->request->get('month');
    }

}