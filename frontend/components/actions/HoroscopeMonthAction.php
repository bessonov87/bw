<?php

namespace frontend\components\actions;

use common\components\AppData;
use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class HoroscopeMonthAction extends Action
{
    public $type = 'common';

    public function run()
    {
        $year = \Yii::$app->request->get('year', null);
        $month = \Yii::$app->request->get('month', null);
        $znak = \Yii::$app->request->get('znak', null);

        if($month && $year){
            $horoscopes = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $year, 'month' => $month])->count();
            if(!$horoscopes) {
                throw new NotFoundHttpException('Страница не найдена');
            }
        } elseif($year){
            $horoscopes = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $year])->count();
            if(!$horoscopes) {
                throw new NotFoundHttpException('Страница не найдена');
            }
        }

        if($znak && !in_array($znak, AppData::$engZnakiTranslit)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $horoscope = [];
        $zodiak = 0;

        if(!$month){
            if($year){
                $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_YEAR, 'year' => $year, 'zodiak' => $zodiak])->one();
            }

            $currentYear = $year ?: date('Y');
            $monthsCurrentYear = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $currentYear, 'zodiak' => $zodiak])->all();

            $nextYear = $year ? $year+1 : date('Y')+1;
            $monthsNextYear = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $nextYear, 'zodiak' => $zodiak])->all();

            return $this->controller->render('month/index', [
                'year' => $year,
                'horoscope' => $horoscope,
                'zodiak' => $zodiak,
                'monthsCurrentYear' => $monthsCurrentYear,
                'currentYear' => $currentYear,
                'monthsNextYear' => $monthsNextYear,
                'nextYear' => $nextYear,
            ]);
        } else {
            $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
            $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $year, 'month' => $month, 'zodiak' => $zodiak])->one();

            return $this->controller->render('month/month', [
                'year' => $year,
                'month' => $month,
                'zodiak' => $zodiak,
                'znak' => $znak,
                'horoscope' => $horoscope,
            ]);
        }

    }
}