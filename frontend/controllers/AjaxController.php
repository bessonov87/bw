<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\IntegrityException;
use common\models\ar\FavoritePosts;
use common\models\ar\PostsRating;
use app\components\widgets\CalendarWidget;
use app\components\widgets\RatingWidget;
use app\components\widgets\FavoriteWidget;

/**
 * Обрабатывает все AJAX запросы приложения
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
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
        return '';
    }

    /**
     * Выставление оценки для статьи
     *
     * @return string
     * @throws \Exception
     */
    public function actionRating(){
        $message = '';
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
                        $err = $rating->errors;
                        $message = current($err)[0];
                    }
                } catch(IntegrityException $e) {
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

    /**
     * Добавление статьи в избранное
     *
     * @return string
     * @throws \Exception
     */
    public function actionFavorite() {
        $message = '';
        $postId = 0;
        if(!Yii::$app->request->get('post_id'))
            return 'Ошибка';
        if(!Yii::$app->user->isGuest) {
            $postId = (int)Yii::$app->request->get('post_id');
            $favorite = new FavoritePosts();
            $favorite->post_id = $postId;
            $favorite->user_id = Yii::$app->user->identity->getId();
            try {
                if ($favorite->save()) {
                    $message = 'Статья добавлена в избранное!';
                } else {
                    $err = $favorite->errors;
                    $message = current($err)[0];
                }
            } catch(IntegrityException $e) {
                if(strpos($e->errorInfo[2], 'foreign key')){
                    $message = 'Ошибка. Неверный ID статьи';
                }
            }
        } else {
            $message = 'Добавлять статьи в избранное могут только зарегистрированные пользователи';
        }
        return FavoriteWidget::widget(['post_id' => $postId, 'message' => $message]);
    }
}