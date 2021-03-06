<?php

namespace app\components\widgets;

use yii\base\Widget;
use common\models\ar\PostsRating;

/**
 * RatingWidget формирует блок рейтинга статьи
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class RatingWidget extends Widget
{
    /**
     * @var integer id статьи
     */
    public $post_id;
    /**
     * @var string page адрес статьи
     */
    public $page;
    /**
     * @var string сообщение о результате выставления рейтинга
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

        $ratings = PostsRating::find()
            ->where($condition)
            ->asArray()
            ->all();

        // Подсчитываем общую сумму и количество плюсов и минусов
        $rating['score'] = 0;
        $rating['numPlus'] = 0;
        $rating['numMinus'] = 0;
        $rating['votes'] = count($ratings);
        foreach($ratings as $rate){
            $rating['score'] += $rate['score'];
            if($rate['score'] == '1'){
                $rating['numPlus']++;
            } elseif($rate['score'] == '-1') {
                $rating['numMinus']++;
            }
        }

        if($rating['score'] > 0){
            $rating['score'] = '+'.$rating['score'];
        }

        $rating['scoreClass'] = ($rating['score'] > 0) ? 'positive' : (($rating['score'] == 0) ? 'null' : 'negative');

        return $this->render('rating', ['rating' => $rating, 'message' => $this->message]);
    }
}