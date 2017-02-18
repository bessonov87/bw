<?php

namespace frontend\controllers;

use common\components\AppData;
use common\components\helpers\GlobalHelper;
use common\models\MoonCal;
use common\models\MoonDni;
use common\models\MoonFazy;
use common\models\MoonZnaki;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HoroscopeController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \frontend\components\actions\HoroscopeAction::className(),
            ],
            'day' => [
                'class' => \frontend\components\actions\HoroscopeDayAction::className(),
            ],
            'week' => [
                'class' => \frontend\components\actions\HoroscopeWeekAction::className(),
            ],
            'month' => [
                'class' => \frontend\components\actions\HoroscopeMonthAction::className(),
            ],
            'year' => [
                'class' => \frontend\components\actions\HoroscopeYearAction::className(),
            ],
        ];
    }

    public function actionMoonCalendar()
    {
        $y = date('Y');

        $months = $this->getExistsMonthsList($y);

        return $this->render('calendar', [
            'months' => $months
        ]);
    }

    public function actionHairCalendar()
    {
        $y = date('Y');

        $months = $this->getExistsMonthsList($y);

        return $this->render('hair-calendar', [
            'months' => $months
        ]);
    }

    public function actionMoonYearCalendar()
    {
        $year = \Yii::$app->request->get('year');

        if(!$year || $year < 2016){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if(date('m') == 12 && date('j') > 15 && $year - 1 == date('Y')){
            return $this->redirect(['horoscope/moon-calendar']);
        }

        if(!MoonCal::find()->where(['date' => $year.'-01-01'])->one()){
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('year-calendar', [
            'year' => $year,
            'months' => $this->getExistsMonthsList($year),
        ]);
    }

    public function actionMoonMonthCalendar()
    {
        $year = \Yii::$app->request->get('year');
        $month = \Yii::$app->request->get('month');
        $monthNum = GlobalHelper::engMonth($month, 'i', true);

        if(!$year || !$month || !$monthNum){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $oldCalendars = AppData::$moonCalMonthLinks;
        if(isset($oldCalendars[$year]) && isset($oldCalendars[$year][$monthNum])){
            return $this->redirect(AppData::$moonCalLinksBase.$oldCalendars[$year][$monthNum], 301);
        }

        if(!MoonCal::find()->where(['date' => $year.'-'.sprintf('%02d', $monthNum).'-01'])->one()){
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('month-calendar', [
            'year' => $year,
            'month' => $monthNum,
            'monthEng' => $month,
            'monthData' => $this->getMonthData($year, $monthNum),
        ]);
    }

    public function actionHairMonthCalendar()
    {
        $year = \Yii::$app->request->get('year');
        $month = \Yii::$app->request->get('month');
        $monthNum = GlobalHelper::engMonth($month, 'i', true);

        if(!$year || !$month || !$monthNum){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $oldCalendars = AppData::$moonHairMonthLinks;
        if(isset($oldCalendars[$year]) && isset($oldCalendars[$year][$monthNum])){
            return $this->redirect(AppData::$moonHairLinksBase.$oldCalendars[$year][$monthNum], 301);
        }

        if(!MoonCal::find()->where(['date' => $year.'-'.sprintf('%02d', $monthNum).'-01'])->one()){
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('hair-month-calendar', [
            'year' => $year,
            'month' => $monthNum,
            'monthEng' => $month,
            'monthData' => $this->getMonthData($year, $monthNum, true),
        ]);
    }

    public function actionMoonDayCalendar()
    {
        $year = \Yii::$app->request->get('year');
        $month = \Yii::$app->request->get('month');
        $monthNum = GlobalHelper::engMonth($month, 'i', true);
        $day = \Yii::$app->request->get('day');

        if(!$year || !$month || !$monthNum || !$day){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $date = $year.'-'.sprintf('%02d', $monthNum).'-'.sprintf('%02d', $day);

        $month_array = $this->getMonthData($year, $monthNum);

        if(!array_key_exists($date, $month_array)){
            throw new NotFoundHttpException("Страница не найдена!");
        }

        $moon_zodiak = $month_array[$date]['moon_zodiak'];
        $moonZnaki = MoonZnaki::find()->where(['num' => GlobalHelper::rusZodiac($moon_zodiak, 'i', true)])->asArray()->one();
        $znaki_text = $moonZnaki['text'];
        $znaki_blago = $moonZnaki['blago'];
        if($znaki_blago == 1) $znaki_blago = "<span style=\"font-style:italic; font-weight:bold; color:#090;\">Положительное влияние</span>";
        else if($znaki_blago == 2) $znaki_blago = "<span style=\"font-style:italic; font-weight:bold; color:#c00;\">Отрицательное влияние</span>";
        else if($znaki_blago == 3) $znaki_blago = "<span style=\"font-style:italic; font-weight:bold;\">Нейтральное влияние</span>";

        $lunar_day = $month_array[$date]['moon_day'];
        $moonDni = MoonDni::find()->where(['num' => intval($lunar_day)])->asArray()->one();
        $dni_text = $moonDni['text'];
        $dni_blago = $moonDni['blago'];
        if($dni_blago == 1) $dni_blago = "<span style=\"font-style:italic; font-weight:bold; color:#090;\">Положительное влияние</span>";
        else if($dni_blago == 2) $dni_blago = "<span style=\"font-style:italic; font-weight:bold; color:#c00;\">Отрицательное влияние</span>";
        else if($dni_blago == 3) $dni_blago = "<span style=\"font-style:italic; font-weight:bold;\">Нейтральное влияние</span>";

        $moon_faza = $month_array[$date]['phase_image'];
        $moonFazy = MoonFazy::find()->where(['num' => $moon_faza])->asArray()->one();
        $fazy_text = $moonFazy['text'];
        $fazy_blago = $moonFazy['blago'];
        if($fazy_blago == 1) $fazy_blago = "<span style=\"font-style:italic; font-weight:bold; color:#090;\">Влияние положительное</span>";
        else if($fazy_blago == 2) $fazy_blago = "<span style=\"font-style:italic; font-weight:bold; color:#c00;\">Влияние отрицательное</span>";
        else if($fazy_blago == 3) $fazy_blago = "<span style=\"font-style:italic; font-weight:bold;\">Влияние нейтральное</span>";

        $today = date("Y-m-d");
        $tomorrow = date('Y-m-d', time() + 86400);
        $moonCalTodayTomorrow = MoonCal::find()
            ->where(['date' => $today])
            ->orWhere(['date' => $tomorrow])
            ->all();
        $moonCalTodayTomorrow = ArrayHelper::index($moonCalTodayTomorrow, 'date');
        // TODO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        return $this->render('day-calendar', [
            'year' => $year,
            'month' => $monthNum,
            'monthEng' => $month,
            'day' => $day,
            'month_array' => $month_array,
            'znaki_text' => $znaki_text,
            'znaki_blago' => $znaki_blago,
            'dni_text' => $dni_text,
            'dni_blago' => $dni_blago,
            'fazy_text' => $fazy_text,
            'fazy_blago' => $fazy_blago,
            'moonCalTodayTomorrow' => $moonCalTodayTomorrow,
        ]);
    }

    protected function getExistsMonthsList($y)
    {
        if(date('m') == 12 && date('j') > 15){
            $y++;
        }
        $start_date = ($y - 1).'-12-01';
        $end_date = $y.'-12-31';
        $days = MoonCal::find()->where(['between', 'date', $start_date, $end_date])->asArray()->all();
        $months = [];
        foreach ($days as $day){
            list($year, $month, $day) = explode('-', $day['date']);
            $months[$year][intval($month)] = true;
        }

        return $months;
    }

    /**
     * Массив данных для генерации лунного календаря на месяц
     * @param $year
     * @param $month
     * @param $withHair
     * @return array
     */
    protected function getMonthData($year, $month, $withHair = false)
    {
        $date = $year.'-'.sprintf('%02d', $month);
        $days = MoonCal::find()->where('to_char("date", \'YYYY-MM\') = \''.$date.'\'')->asArray()->all();

        $moon_phases = [1 => 'Новолуние', 2 => '1 четверть', 3 => 'Полнолуние', 4 => '4 четверть'];
        $weekdays = [0 => 'Вс', 1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб'];
        $first_moon_phase = 0;
        $w = 1;
        $phase_image_num = 0;
        $month_array = [];
        $phase_image = [];
        foreach($days as $rows) {
            $moon_date_base = $rows['date'];
            $moon_date = date("j", strtotime($moon_date_base)) . " " . GlobalHelper::rusMonth(date("m", strtotime($moon_date_base)));
            $moon_day = $rows['moon_day'];
            $moon_day_from = substr($rows['moon_day_from'], 0, 5);
            $moon_day_sunset = substr($rows['moon_day_sunset'], 0, 5);
            $moon_day2 = $rows['moon_day2'];
            $moon_day2_from = substr($rows['moon_day2_from'], 0, 5);
            $moon_zodiak = GlobalHelper::rusZodiac($rows['zodiak']);
            $moon_zodiak_from_ut = substr($rows['zodiak_from_ut'], 0, 5);
            $moon_phase = $rows['phase'];
            $moon_phase_from = substr($rows['phase_from'], 0, 5);
            $moon_percent = $rows['moon_percent'];

            $moon_weekday = $weekdays[date("w", strtotime($moon_date_base))];

            if ($moon_day2) $moon_day = $moon_day . "/" . $moon_day2;

            if ($moon_phase) {
                $first_moon_phase++;
                $phase_image_num = $moon_phase * 2 - 1;
                $phase_image[$w] = $phase_image_num;
                if ($first_moon_phase == 1 && $w != 1) {
                    $w_difference = $w - 1;
                    for ($e = 1; $e <= $w_difference; $e++) {
                        if ($phase_image_num != 1) $phase_image[$e] = $phase_image_num - 1;
                        else $phase_image[$e] = 8;
                    }
                }

                $moon_phase = $moon_phases[$moon_phase] . " с " . $moon_phase_from;
            } else {
                $moon_phase = "";
                $phase_image[$w] = $phase_image_num + 1;
            }

            $month_array[$w]['date'] = $moon_date_base;
            $month_array[$w]['moon_weekday'] = $moon_weekday;
            $month_array[$w]['moon_day'] = $moon_day;
            $month_array[$w]['moon_day_from'] = $moon_day_from;
            $month_array[$w]['moon_day_sunset'] = $moon_day_sunset;
            $month_array[$w]['moon_day2'] = $moon_day2;
            $month_array[$w]['moon_day2_from'] = $moon_day2_from;
            $month_array[$w]['moon_zodiak'] = $moon_zodiak;
            $month_array[$w]['moon_zodiak_from_ut'] = $moon_zodiak_from_ut;
            $month_array[$w]['moon_phase'] = $moon_phase;
            $month_array[$w]['moon_phase_from'] = $moon_phase_from;
            $month_array[$w]['moon_percent'] = $moon_percent;
            if($withHair) {
                $month_array[$w]['blago'] = $rows['blago'];
                $month_array[$w]['blago_level'] = $rows['blago_level'];
                $month_array[$w]['hair_text'] = $rows['hair_text'];
            }

            $w++;
        }

        foreach ($month_array as $w => $month_day){
            $month_day['phase_image'] = $phase_image[$w];
            $month_array[$w] = $month_day;
        }

        return ArrayHelper::index($month_array, 'date');
    }

    /**
     * Редиректы со старых страниц лунного календаря на день
     * вида https://beauty-women.ru/horoscope/lunnyj-kalendar-na-god/18_oktjabrja_2014_goda.html
     * на новые вида https://beauty-women.ru/horoscope/lunnyj-kalendar-na-god/2014/oktjabr/18/
     * @param $day
     * @param $monthr
     * @param $year
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRedirectMoonCalendar($day, $monthr, $year)
    {
        if(!$year || !$monthr || !$day){
            throw new NotFoundHttpException("Страница не найдена");
        }
        $monthNum = GlobalHelper::engMonth($monthr, 'r', true);
        $engMonth = GlobalHelper::engMonth($monthNum);
        if(!$year || !$engMonth || !$day){
            throw new NotFoundHttpException("Страница не найдена");
        }

        $newLink = Url::to(['horoscope/moon-day-calendar', 'year' => $year, 'month' => $engMonth, 'day' => $day]);
        if(!$newLink){
            throw new NotFoundHttpException("Страница не найдена");
        }
        return $this->redirect($newLink, 301);
    }

}