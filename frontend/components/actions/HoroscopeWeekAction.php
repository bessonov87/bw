<?php

namespace frontend\components\actions;

use common\components\AppData;
use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class HoroscopeWeekAction extends Action
{
    public $type = 'common';

    public function run()
    {
        $week = \Yii::$app->request->get('week');
        $znak = \Yii::$app->request->get('znak');

        if($week && !in_array($week, ['this', 'next'])){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if($znak && !in_array($znak, AppData::$engZnakiTranslit)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $horoscope = [];
        $time = time();
        $zodiak = 0;
        $weekNum = 0;
        if($week){
            if($week == 'this'){
                $weekNum = intval(date('W'));
            } elseif ($week == 'next'){
                $weekNum = intval(date('W', time() + 7 * 86400));
            }

            /*var_dump(date('W'));GlobalHelper::getMonday(1); die;
            var_dump(date('d.m.Y', GlobalHelper::getMonday(1))); die;*/

            $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
            $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_WEEK, 'week' => $weekNum, 'zodiak' => $zodiak])->one();
        }

        return $this->controller->render('week/week', [
            'week' => $week,
            'time' => $time,
            'zodiak' => $zodiak,
            'znak' => $znak,
            'horoscope' => $horoscope,
            'weekNum' => $weekNum,
        ]);
    }
}