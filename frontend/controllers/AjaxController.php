<?php
namespace frontend\controllers;

use frontend\models\PostsRating;
use Yii;
use yii\web\Controller;
use app\components\CalendarWidget;
use app\components\RatingWidget;

class AjaxController extends Controller
{
    /**
     * Календарь на месяц
     *
     * @return string
     * @throws \Exception
     */
    public function actionCalendar(){
        if(Yii::$app->request->get('date')){
            return CalendarWidget::widget(['date' => Yii::$app->request->get('date'), 'noControls' => true]);
        }
    }

    public function actionRating(){
        if((Yii::$app->request->get('score') == 1 || Yii::$app->request->get('score') == -1) && Yii::$app->request->get('post_id')){
            $postId = Yii::$app->request->get('post_id');
            $score = Yii::$app->request->get('score');
            if(!Yii::$app->user->isGuest){
                $rating = new PostsRating();
                $rating->post_id = $postId;
                $rating->user_id = Yii::$app->user->identity->getId();
                $rating->score = $score;
                try {
                    if ($rating->save()) {
                        $message = 'Спасибо! Ваш голос засчитан';
                    } else {
                        $message = current($rating->errors)[0];
                    }
                } catch(yii\db\IntegrityException $e) {
                    if(strpos($e->errorInfo[2], 'foreign key')){
                        $message = 'Ошибка. Неверный ID статьи';
                    }
                }
            } else {
                $message = 'Голосовать могут только зарегистрированные пользователи';
            }
        } else {
            return 'Ошибка';
        }
        return RatingWidget::widget(['post_id' => $postId, 'message' => $message]);
    }
}