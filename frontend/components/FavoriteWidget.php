<?php
namespace app\components;

use Yii;
use yii\base\Widget;

class FavoriteWidget extends Widget
{
    public $post_id;

    public function getViewPath(){
        return '@app/views/post';
    }

    public function init(){
        parent::init();
    }

    public function run(){
        if(!$this->post_id) return '';

        /* TODO: Посчитать количество добавлений в избранное и есть ли в избранном у текущего пользователя */

        $options['button_class'] = ($inFavorite) ? 'favorite_button_yellow' : 'favorite_button_grey';

        return '<div class="post_favorite">
            <div class="post_favorite_star">
                <button type="button" class="post_favorite_button favorite_button_grey" title="Добавить статью в избранное">
                    <span></span>
                </button>
            </div>
            <div class="post_favorite_count">
                54
            </div>
        </div>';
    }
}