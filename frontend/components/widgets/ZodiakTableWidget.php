<?php

namespace app\components\widgets;

use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class ZodiakTableWidget extends Widget
{
    public $baseUrl = null;

    public $znak = 0;

    public $period;

    public $year = null;

    public $month = null;

    public $den = null;

    public $week = null;

    public function run()
    {
        if(!$this->baseUrl || !$this->period){
            throw new InvalidConfigException('baseUrl and period is required');
        }

        switch ($this->period){
            case Goroskop::PERIOD_YEAR:
                $period = $this->year . ' год'; break;
            case Goroskop::PERIOD_MONTH:
                $period = GlobalHelper::rusMonth($this->month).' '.$this->year.' года'; break;
            case Goroskop::PERIOD_WEEK:
                $period = $this->week == 'next' ? 'следующую неделю' : 'неделю'; break;
            case Goroskop::PERIOD_DAY:
                $period = $this->den == 'zavtra' ? 'завтра' : 'сегодня'; break;
            default:
                $period = '';
        }

        return $this->render('zodiak-table', [
            'baseUrl' => $this->baseUrl,
            'znak' => $this->znak,
            'period' => $period,
        ]);
    }

    public function getViewPath()
    {
        return '@frontend/views/horoscope/';
    }
}