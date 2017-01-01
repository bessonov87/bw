<?php

namespace backend\controllers;

use common\components\helpers\GlobalHelper;
use common\models\ar\MoonCal;
use common\models\MoonHair;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;

class MoonController extends Controller
{
    public function actionDni()
    {
        $year = \Yii::$app->request->get('year', null);
        $month = \Yii::$app->request->get('month', null);
        $day = \Yii::$app->request->get('day', null);

        $dayDate = null;
        $date = null;
        $calendar = '';
        $dayForm = '';
        if($year && $month){

            $date = $year.'-'.sprintf('%02d', $month);
            $dateText = GlobalHelper::ucfirst(GlobalHelper::rusMonth($month)) . ' ' . $year;
            if($day){
                $h3Class = '';
                $dayDate = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $day);
                if(!$model = MoonCal::findOne(['date' => $dayDate])){
                    $model = new MoonCal();
                }

                if($model->load(\Yii::$app->request->post()) && $model->validate()){
                    if(!$model->moon_day2 && $model->moon_day2 !== 0){
                        $model->moon_day2 = 0;
                    }
                    if($model->save()) {
                        return $this->redirect(['moon/dni', 'year' => $year, 'month' => $month]);
                    } else {
                        var_dump($model->getErrors());
                    }
                }

                if($model->isNewRecord){
                    $model->date = $dayDate;
                    $model->moon_day2_from = '00:00';
                    $model->moon_day2_sunset = '00:00';
                    $model->phase_from = '00:00';
                } else {
                    $h3Class = $model->blago == 1 ? 'text-success' : 'text-danger';
                }
                $dayForm = '<h3 class="text-right '.$h3Class.'" style="margin-top:0;">'.$dayDate.'</h3>';
                $dayForm .= $this->renderPartial('_moon_day_from', ['model' => $model]);
            }

            $results = MoonCal::find()->where('to_char("date", \'YYYY-MM\') = \''.$date.'\'')->all();
            $results = ArrayHelper::index($results, 'date');
            //var_dump($results); die;

            for($i=1;$i<=date('t', strtotime($date));$i++){
                $dat = $date . '-' . sprintf('%02d', $i);
                if(isset($results[$dat])){
                    $moonDay = $results[$dat];
                    $class = $moonDay->blago == 1 ? 'moon-success' : 'moon-danger';
                } else {
                    $class = '';
                }
                $link = Html::a($i, ['moon/dni', 'year' => $year, 'month' => $month, 'day' => $i], ['class' => 'moon-link '.$class]);
                $calendar .= '<div class="col-md-2">'.$link.'</div>';
            }

            $calendar = '<h3 style="text-align: center; margin-top: 0;">'.$dateText.'</h3><div class="row">'.$calendar.'</div>';

        }

        return $this->render('dni', [
            'calendar' => $calendar,
            'date' => $date,
            'day' => $dayDate,
            'dayForm' => $dayForm,
        ]);
    }

    public function actionHair()
    {
        $year = \Yii::$app->request->get('year', null);
        $month = \Yii::$app->request->get('month', null);

        $calendars = [];
        $months = '';
        $calForm = '';
        if($year) {
            $moonHair = MoonHair::find()
                ->where(['like', 'date', $year])
                ->orderBy(['date' => SORT_DESC])
                ->all();
            $moonHair = ArrayHelper::index($moonHair, 'date');

            foreach ($moonHair as $mh) {
                $date = $mh->date;
                $cal_id = $mh->id;
                $cal_post_id = $mh->post_id;
                $calendars[$date]['id'] = $cal_id;
                $calendars[$date]['post_id'] = $cal_post_id;
            }

            //var_dump($calendars); die;
            $items = [];
            for($x=1;$x<=12;$x++){
                $mY = $year.'-'.sprintf('%02d', $x);
                $mClass = isset($calendars[$mY]) ? 'moon-success' : 'moon-danger';
                $mText = GlobalHelper::ucfirst(GlobalHelper::rusMonth($x) . ' ' . $year);
                $items[] = Html::a($mText, ['moon/hair', 'year' => $year, 'month' => $x], ['class' => $mClass, 'data-pjax' => 0]);
            }

            $months = Html::ul($items, ['class' => 'months-list', 'encode' => false]);
        }

        $moonHairModel = null;
        if($year && $month){
            $key = $year.'-'.sprintf('%02d', $month);
            $moonHairModel = isset($moonHair[$key]) ? $moonHair[$key] : new MoonHair();
            $moonHairModel->date = $key;
            $moonHairModel->year = $year;
            $moonHairModel->month = $month;
        }

        return $this->render("hair", [
            'calendars' => $calendars,
            'calForm' => $calForm,
            'months' => $months,
            'moonHairModel' => $moonHairModel
        ]);
    }
}