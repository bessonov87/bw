<?php

namespace app\components;

use yii\helpers\Html;

class PostHelper {

    /**
     * Генерация похожих статей
     *
     * @param $posts Статьи, выбранные в качестве похожих для текущей
     * @param $options Опции в формате массива
     *
     * Возможные опции:
     * boolean list - формировать упорядоченный/неупорядоченный список
     * string list_type - тип списка: упорядоченный (ol) или неупорядоченный (ul) (по умолчанию ul, если list = true)
     * string class - класс div обертки (по умолчанию similar_posts)
     */
    public static function similar($posts, $options = []){
        if(!is_array($posts)){
            return '';
        }
        $similar_class = !empty($options['class']) ? $options['class'] : 'similar_posts';
        $similar = '<div class="'.$similar_class.'">';
        if($options['list'] === true){
            $similar .= $options['listType'] === 'ol' ? '<ol>' : '<ul>';
            foreach($posts as $post){
                $similar .= '<li>'.$post->title.'</li>';
            }
            $similar .= $options['listType'] === 'ol' ? '</ol>' : '</ul>';
        } else {
            foreach($posts as $post){
                $similar .= '<div>'.$post->title.'</div>';
            }
        }
        $similar .= '</div>';

        return $similar;
    }

}