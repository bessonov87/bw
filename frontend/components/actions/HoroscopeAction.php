<?php

namespace frontend\components\actions;

use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class HoroscopeAction extends Action
{
    protected $startYear = 2017;

    protected $periods = ['index', 'year', 'month', 'week', 'day'];

    protected $types = ['common', 'vostok'];

    public $type = null;

    public $period = null;

    public function run()
    {
        $type = \Yii::$app->request->get('type');
        if(!$type || !in_array($type, $this->types)){
            throw new NotFoundHttpException('Страница не найдена');
        }
        $this->type = $type;

        $period = \Yii::$app->request->get('period');
        if(!$period || !in_array($period, $this->periods)){
            throw new NotFoundHttpException('Страница не найдена');
        }
        $this->period = $period;

        switch ($period){
            case 'index':
                return $this->renderIndexPage();
            case 'year':
                return $this->renderYearHoroscope();
            case 'month':
                return $this->renderMonthHoroscope();
            case 'week':
                return $this->renderWeekHoroscope();
            case 'day':
                return $this->renderDayHoroscope();
            default:
                throw new NotFoundHttpException('Страница не найдена');
        }
    }

    protected function renderIndexPage(){
        return $this->controller->render('common/index');
    }

    /**
     * ГОРОСКОПЫ НА ГОД
     * @return string
     * @throws NotFoundHttpException
     */
    public function renderYearHoroscope()
    {
        $year = \Yii::$app->request->get('year');
        $znak = \Yii::$app->request->get('znak');

        if($year && $year < $this->startYear){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if(!$year){
            return $this->controller->render('common/years-index');
        } else {
            $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
            $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_YEAR, 'year' => $year, 'zodiak' => $zodiak])->one();
            if(!$horoscope){
                throw new NotFoundHttpException('Страница не найдена');
            }
            return $this->controller->render('common/year', ['year' => $year, 'horoscope' => $horoscope]);
        }
    }

    /**
     * ГОРОСКОПЫ НА МЕСЯЦ
     * @return string
     * @throws NotFoundHttpException
     */
    public function renderMonthHoroscope()
    {
        $year = \Yii::$app->request->get('year');
        $month = \Yii::$app->request->get('month');
        $znak = \Yii::$app->request->get('znak');

        if($year && $year < $this->startYear){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if($month && ($month < 1 || $month > 12)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if(!$year && !$month){
            return $this->controller->render('common/months-index');
        } elseif ($year && !$month){
            $horoscopes = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $year])->all();
            if(!$horoscopes){
                throw new NotFoundHttpException('Страница не найдена');
            }
            return $this->controller->render('common/months-year-index', ['year' => $year, 'horoscopes' => $horoscopes]);
        } else {
            $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
            $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_MONTH, 'year' => $year, 'month' => $month, 'zodiak' => $zodiak])->one();
            if(!$horoscope){
                throw new NotFoundHttpException('Страница не найдена');
            }
            return $this->controller->render('common/month', ['year' => $year, 'month' => $month, 'horoscope' => $horoscope]);
        }
    }

    /**
     * ГОРОСКОПЫ НА НЕДЕЛЮ
     * @return string
     * @throws NotFoundHttpException
     */
    public function renderWeekHoroscope()
    {
        $year = \Yii::$app->request->get('year');
        $week = \Yii::$app->request->get('week');
        $znak = \Yii::$app->request->get('znak');

        if($year && $year < $this->startYear){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if($week && ($week < 1 || $week > 52)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if(!$year && !$week){
            return $this->controller->render('common/weeks-index');
        } elseif ($year && !$week){
            $horoscopes = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_WEEK, 'year' => $year])->all();
            if(!$horoscopes){
                throw new NotFoundHttpException('Страница не найдена');
            }
            return $this->controller->render('common/weeks-year-index', ['year' => $year, 'horoscopes' => $horoscopes]);
        } else {
            $zodiak = $znak ? GlobalHelper::engZodiak($znak, true) : 0;
            $horoscope = Goroskop::find()->where(['type' => $this->type, 'period' => Goroskop::PERIOD_WEEK, 'year' => $year, 'week' => $week, 'zodiak' => $zodiak])->one();
            if(!$horoscope){
                throw new NotFoundHttpException('Страница не найдена');
            }
            return $this->controller->render('common/week', ['year' => $year, 'week' => $week, 'horoscope' => $horoscope]);
        }
    }

    /**
     * ГОРОСКОПЫ НА ДЕНЬ
     * @return string
     * @throws NotFoundHttpException
     */
    public function renderDayHoroscope()
    {

    }

}