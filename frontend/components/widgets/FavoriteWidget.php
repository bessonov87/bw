<?php
namespace app\components\widgets;

use app\models\FavoritePosts;
use Yii;
use yii\base\Widget;

class FavoriteWidget extends Widget
{
    public $post_id;
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

        //var_dump($favorites);

        $options['button_class'] = ($inFavorite) ? 'favorite_button_yellow' : 'favorite_button_grey';

        return $this->render('favorite', ['options' => $options, 'message' => $this->message]);
    }
}