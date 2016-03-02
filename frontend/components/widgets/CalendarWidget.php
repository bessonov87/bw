<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\db\Query;
use yii\helpers\ArrayHelper;

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
    /**
     * @var string месяц календаря в формате yyyy-mm
     */
    public $date;
    /**
     * @var bool выводить кнопки управления или нет
     */
    public $noControls = false;

    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();
    }

    /**
     * @inheritdoc
     */
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