<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\ar\Post;
use common\components\helpers\GlobalHelper;

/**
 * CalendarWidget отвечает за формирование календаря в сайдбаре
 *
 * В зависимости от значения свойства noControls, календарь будет (если false) или не будет (если true)
 * формироваться с кнопка перехода на следующий и предыдущий месяцы. При первоначальном формировании календаря, он
 * должен выводиться с кнопками управления, при ajax запросах кнопки управления остаются, обновляется непосредствено
 * сам календарь.
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
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
        if(is_null($this->date)) $this->date = date('Y-m');

        $rows = (new Query())
            ->select('COUNT(*) as count, DAY(date) as day')
            ->from('{{%post}}')
            ->where("DATE_FORMAT( DATE, '%Y-%m' ) = :month", [':month' => $this->date])
            ->groupBy("DAY( `date` )")
            ->all();
        $rows = ArrayHelper::index($rows, 'day');

        return $this->renderFile('@app/views/site/calendar.php', ['posts' => $rows,'date' => $this->date, 'noControls' => $this->noControls]);
    }
}