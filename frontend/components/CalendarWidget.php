<?php

namespace app\components;

use frontend\models\Post;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\GlobalHelper;

class CalendarWidget extends Widget
{
    public $month;
    public $year;
    public $date;
    public $noControls = false;

    public function init(){
        parent::init();
    }

    public function run(){
        if(is_null($this->month)) $this->month = date('m');
        if(is_null($this->year)) $this->year = date('Y');
        if(is_null($this->date)) $this->date = date('Y-m');

        /*$thisDate = new \DateTime($this->year.'-'.$this->month);
        $datePrev = $thisDate->add(new \DateInterval('P1M'))->getTimestamp();*/
        $datePrev = date('Y-m', strtotime($this->date.' -1 month'));
        $dateNext = date('Y-m', strtotime($this->date.' +1 month'));

        if(!$this->noControls) {
            $controls = Html::tag('div', '&laquo', ['class' => 'calendar_control', 'id' => 'calendar-prev']);
            $controls .= Html::tag('div', '&raquo', ['class' => 'calendar_control', 'id' => 'calendar-next']);
        }

        $result = $controls . Html::tag('div', $this->date, ['class' => 'calendar_body']);
        $result .= Html::tag('div', $this->date, ['id' => 'calendar-current-date', 'style' => 'display:none;']);
        return Html::tag('div', $result, ['class' => 'calendar_widget', 'id' => 'calendar_widget']);
    }
}