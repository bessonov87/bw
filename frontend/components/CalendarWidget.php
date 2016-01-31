<?php

namespace app\components;

use frontend\models\Post;
use yii\base\Widget;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
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