<?php

namespace app\components\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;

/**
 * Вывод похожих статей
 *
 * @param $posts array Статьи, выбранные в качестве похожих для текущей
 * @param $options array Опции в формате массива
 *
 * Возможные опции:
 * boolean list - формировать упорядоченный/неупорядоченный список
 * string list_type - тип списка: упорядоченный (ol) или неупорядоченный (ul) (по умолчанию ul, если list = true)
 * string class - класс div обертки (по умолчанию similar_posts)
 * boolean manual - ручная установка ссылок на статьи (в данном случае в $post->similarPosts вручную в свойстве url
 * указывается полностью вся ссылка). Таким образом, для формирования ссылки берется только title и url.
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class SimilarPostsWidget extends Widget {

    /**
     * @var array список ссылок
     */
    public $links = null;
    /**
     * @var array список статей
     */
    public $posts = null;
    /**
     * @var bool "ручная" установка ссылок на статьи
     */
    public $manual = false;
    /**
     * @var bool выводить в виде html-списка
     */
    public $list = true;
    /**
     * @var string тип html-списка
     */
    public $listType = 'ol';
    /**
     * @var string класс
     */
    public $class = 'similar_posts';
    /**
     * @var int максимальная длина заголовка
     */
    public $maxTitle = 150;

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
        if(!is_array($this->posts) && !is_array($this->links)){
            return '';
        }

        $list = $this->posts ? $this->postsSimilar() : $this->linksSimilar();

        $similar = Html::tag('div', $list, ['class' => $this->class]);

        return $similar;
    }

    /**
     * Похожие по списку ссылок
     * @return array|string
     */
    protected function linksSimilar()
    {
        if($this->list === true){
            $list = [];
            if(!is_array($this->links)){
                return '';
            }
            foreach($this->links as $link){
                $list[] = Html::a($this->cutTitle($link['title']), $link['url']);
            }
            $listType = ($this->listType == 'ul') ? 'ul' : 'ol';
            if($list) {
                $list = Html::$listType($list, ['encode' => false]);
            } else {
                $list = '';
            }
        } else {
            $list = '';
            foreach($this->links as $link){
                $list .= Html::tag('div', Html::a($this->cutTitle($link['title']), $link['url']));
            }
        }

        return $list;
    }

    /**
     * Похожие статьи
     * @return array|string
     */
    protected function postsSimilar()
    {
        if($this->list === true){
            $list = [];
            if(!is_array($this->posts)){
                return '';
            }
            foreach($this->posts as $post){
                $link = (!$this->manual) ? $post->link : $link = $post->url;
                $list[] = Html::a($this->cutTitle($post->title), $link);
            }
            $listType = ($this->listType == 'ul') ? 'ul' : 'ol';
            if($list) {
                $list = Html::$listType($list, ['encode' => false]);
            } else {
                $list = '';
            }
        } else {
            $list = '';
            foreach($this->posts as $post){
                $list .= Html::tag('div', $this->cutTitle($post->title));
            }
        }

        return $list;
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