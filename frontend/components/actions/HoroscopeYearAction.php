<?php

namespace frontend\components\actions;

use common\components\AppData;
use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class HoroscopeYearAction extends Action
{
    public $type = 'common';

    public function run()
    {
        $year = \Yii::$app->request->get('year', null);
        $znak = \Yii::$app->request->get('znak', null);

        if($year){
            $horoscopes = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_YEAR, 'year' => $year])->count();
            if(!$horoscopes) {
                throw new NotFoundHttpException('Страница не найдена');
            }
        }

        if($znak && !in_array($znak, AppData::$engZnakiTranslit)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $horoscope = [];
        $zodiak = 0;

        $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
        $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_YEAR, 'year' => $year, 'zodiak' => $zodiak])->one();

        $years = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_YEAR])->all();
        $years = ArrayHelper::getColumn($years, 'year');
        $years = array_unique($years);

        return $this->controller->render('year/year', [
            'year' => $year,
            'zodiak' => $zodiak,
            'znak' => $znak,
            'horoscope' => $horoscope,
            'years' => $years,
        ]);
    }
}