<?php
namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use common\models\ar\FavoritePosts;

/**
 * FavoriteWidget формирует блок добавления статьи в избранное
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
     * @var string page адрес статьи
     */
    public $page;
    /**
     * @var string сообщение о результате добавления статьи в избранное
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/post';
    }

    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run(){
        if(!$this->post_id && !$this->page) return '';
        if($this->post_id) {
            $condition = ['post_id' => $this->post_id];
        } else {
            $condition = ['page_hash' => $this->page];
        }

        /* TODO: Посчитать количество добавлений в избранное и есть ли в избранном у текущего пользователя */
        $favorites = FavoritePosts::find()
            ->where($condition)
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