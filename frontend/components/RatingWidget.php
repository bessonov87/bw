<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\PostsRating;

class RatingWidget extends Widget
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

        $ratings = PostsRating::find()
            ->where(['post_id' => $this->post_id])
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

        $rating['scoreClass'] = ($rating['score'] > 0) ? 'positive' : 'negative';

        return $this->render('rating', ['rating' => $rating]);
    }
}