<?php

namespace app\components;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;

/**
 * Вывод похожих статей
 *
 * @param $posts Статьи, выбранные в качестве похожих для текущей
 * @param $options Опции в формате массива
 *
 * Возможные опции:
 * boolean list - формировать упорядоченный/неупорядоченный список
 * string list_type - тип списка: упорядоченный (ol) или неупорядоченный (ul) (по умолчанию ul, если list = true)
 * string class - класс div обертки (по умолчанию similar_posts)
 * boolean manual - ручная установка ссылок на статьи (в данном случае в $post->similarPosts вручную в свойстве url
 * указывается полностью вся ссылка). Таким образом, для формирования ссылки берется только title и url.
 */
class SimilarPostsWidget extends Widget {

    public $posts;
    public $manual = false;
    public $list = true;
    public $listType = 'ol';
    public $class = 'similar_posts';
    public $maxTitle = 150;

    /*public $options = [
        'manual' => false,
        'list' => true,
        'listType' => 'ul',
        'class' => 'similar_posts'
    ];*/

    public function init(){
        parent::init();
    }

    public function run(){
        if(!is_array($this->posts)){
            return '';
        }

        if($this->list === true){
            foreach($this->posts as $post){
                $link = (!$this->manual) ? $post->link : $link = $post->url;
                $list[] = Html::a($this->cutTitle($post->title), $link);
            }
            $listType = ($this->listType == 'ul') ? 'ul' : 'ol';
            $list = Html::$listType($list, ['encode' => false]);
        } else {
            $list = '';
            foreach($this->posts as $post){
                $list .= Html::tag('div', $this->cutTitle($post->title));
            }
        }

        $similar = Html::tag('div', $list, ['class' => $this->class]);

        return $similar;
    }

    /**
     * Обрезка заголовка статьи до заданного количества символов
     *
     * @param $title
     * @return string
     */
    protected function cutTitle($title){
        if(strlen($title) <= $this->maxTitle) return $title;
        $newTitle = '';
        foreach(explode(' ', $title) as $word){
            if((strlen($newTitle) + strlen($word)) > $this->maxTitle){
                return $newTitle.'...';
            }
            $newTitle .= $word.' ';
        }
    }

}