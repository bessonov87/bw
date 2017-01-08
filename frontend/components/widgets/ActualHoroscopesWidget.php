<?php

namespace app\components\widgets;

use common\components\helpers\GlobalHelper;
use yii\base\Widget;
use yii\helpers\Html;

class ActualHoroscopesWidget extends Widget
{
    public function run()
    {
        $year = date('Y');
        $month = date('m');
        $links[] = Html::a("Гороскоп на $year год", "/horoscope/na-god/$year/");
        if($month == 12){
            $nextYear = $year+1;
            $links[] = Html::a("Гороскоп на $nextYear год", "/horoscope/na-god/$nextYear/");
        }
        $links[] = Html::a("Гороскоп на ".GlobalHelper::rusMonth($month)." $year года", "/horoscope/na-mesjac/$year/$month/");
        if($month < 12){
            $nextMonth = $month + 1;
            $links[] = Html::a("Гороскоп на ".GlobalHelper::rusMonth($nextMonth)." $year года", "/horoscope/na-god/$year/".sprintf('%02d', $nextMonth)."/");
        }
        $links[] = Html::a("Гороскоп на неделю", "/horoscope/na-nedelju/");
        $links[] = Html::a("Гороскоп на сегодня", "/horoscope/na-segodnja/");

        return Html::ul($links, ['encode' => false]);
    }
}