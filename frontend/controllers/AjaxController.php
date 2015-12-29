<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\components\CalendarWidget;

class AjaxController extends Controller
{
    public function actionCalendar(){
        if(Yii::$app->request->get('date')){
            return CalendarWidget::widget(['date' => Yii::$app->request->get('date'), 'noControls' => true]);
        }
    }
}