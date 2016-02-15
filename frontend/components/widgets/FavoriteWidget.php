<?php
namespace app\components\widgets;

use app\models\FavoritePosts;
use Yii;
use yii\base\Widget;

/**
 * FavoriteWidget формирует блок добавления статьи в избранное
 *
 * Описание класса
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class FavoriteWidget extends Widget
{
    /**
     * @var integer ID статьи
     */
    public $post_id;
    /**
     * @var string сообщение о результате добавления статьи в избранное
     */
    public $message;

    public function getViewPath(){
        return '@app/views/post';
    }

    public function init(){
        parent::init();
    }

    public function run(){
        if(!$this->post_id) return '';

        /* TODO: Посчитать количество добавлений в избранное и есть ли в избранном у текущего пользователя */
        $favorites = FavoritePosts::find()
            ->where(['post_id' => $this->post_id])
            ->asArray()
            ->all();

        // количество добавлений статьи в избранное
        $options['favorites_num'] = count($favorites);
        // есть ли в избранном у текущего пользователя
        $inFavorite = false;
        if(!Yii::$app->user->isGuest) {
            foreach ($favorites as $fav) {
                if ($fav['user_id'] == Yii::$app->user->identity->getId())
                    $inFavorite = true;
            }
        }
        $options['button_class'] = ($inFavorite) ? 'favorite_button_yellow' : 'favorite_button_grey';
        return $this->render('favorite', ['options' => $options, 'message' => $this->message]);
    }
}