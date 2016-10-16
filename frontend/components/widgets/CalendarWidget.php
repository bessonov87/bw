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

        $startOfMonth = strtotime($this->date);
        $endOfMonth = strtotime("+1 month", $startOfMonth);

        $rows = (new Query())
            ->select('id, date')
            ->from('{{%post}}')
            ->where(['between', 'date', $startOfMonth, $endOfMonth])
            ->all();

        $result = [];
        foreach ($rows as $post){
            $day = (int)date('j', $post['date']);
            $result[$day]['day'] = $day;
            $result[$day]['count'] = isset($result[$day]['count']) ? ++$result[$day]['count'] : 1;
        }

        $rows = $result;
        unset($result);

        return $this->renderFile('@app/views/site/calendar.php', ['posts' => $rows,'date' => $this->date, 'noControls' => $this->noControls]);
    }
}