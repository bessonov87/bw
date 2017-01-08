<?php

namespace frontend\components\actions;

use common\components\AppData;
use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class HoroscopeDayAction extends Action
{
    public $type = 'common';

    public function run()
    {
        $den = \Yii::$app->request->get('den');
        $znak = \Yii::$app->request->get('znak');

        if($den && !in_array($den, ['segodnja', 'zavtra'])){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if($znak && !in_array($znak, AppData::$engZnakiTranslit)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $horoscope = [];
        $time = time();
        $zodiak = 0;
        if($den){
            if($den == 'segodnja'){
                 $time = time();
            } elseif ($den == 'zavtra'){
                $time = time() + 86400;
            }
            $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
            $date = date('Y-m-d', $time);
            $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_DAY, 'date' => $date, 'zodiak' => $zodiak])->one();
        }

        return $this->controller->render('day/day', [
            'den' => $den,
            'time' => $time,
            'zodiak' => $zodiak,
            'znak' => $znak,
            'horoscope' => $horoscope
        ]);
    }
}