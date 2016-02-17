<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\ar\Post;

/**
 * PopularWidget формирует список популярных статей
 *
 * В зависимости от переданных параметров, популярных статьи могут выводиться в виде нумерованного или
 * ненумерованного списка, а также в виде тизеров. Изображения для тизера, если выбран данный тип, берется из статьи
 * автоматически.
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class PopularWidget extends Widget
{
    /**
     * @var int количество статей в списке
     */
    public $numPosts = 10;
    /**
     * @var string css класс обертки списка
     */
    public $listClass = 'popular';
    /**
     * @var string тип списка статей (ol, ul)
     */
    public $listType;
    /**
     * @var bool оборачивать в div контейнер
     */
    public $container = true;
    /**
     * @var string css класс контейнера
     */
    public $containerClass;
    /**
     * @var bool список в виде тизеров
     */
    public $tizerStyle = false;
    /**
     * @var int ширина изображения в тизере
     */
    public $imageWidth = 70;
    /**
     * @var int максимальная длина заголовка статьи
     */
    public $maxTitle = 120;
    /**
     * @var array допустимые типы списка
     */
    private $_listTypes = ['ol', 'ul'];
    /**
     * @var string тип списка по умолчанию
     */
    private $_defaultListType = 'ol';

    public function init(){
        parent::init();
    }

    public function run(){
        // Получаем список из numPosts постов отсортированных по количеству просмотров
        $posts = Post::find()
            ->where(['!=', 'category_art', '1'])
            ->andWhere(['approve' => '1'])
            ->orderBy(['views' => SORT_DESC])
            ->limit($this->numPosts)
            ->with('postCategories')
            ->all();
        // Если listType не соответствует списку возможных типов из массива _listTypes, присваиваем ему значение по умолчанию
        if(!in_array($this->listType, $this->_listTypes)){
            $this->listType = $this->_defaultListType;
        }
        // Пробегаемся по выбранным numPosts постам
        foreach($posts as $post){
            // Проверяем соответствует ли заголовок статьи максимальной длине (maxTitle). Если нет, укорачиваем его
            $linkTitle = (strlen($post['title']) <= $this->maxTitle) ? $post['title'] : $this->cutTitle($post['title']);
            // Формируем ссылку
            $link = Html::a($linkTitle, $post->link);
            // Если популярные статьи нужно выводить в виде тизеров
            if($this->tizerStyle){
                $postHtml = $post->full;
                preg_match('/(img|src)=("|\')[^"\'>]+/i', $postHtml, $media);
                $src = preg_replace('/(img|src)("|\'|="|=\')(.*)/i', "$3", $media[0]);
                if(!$src) $src = '/bw15/images/post_no_image.jpg';
                $image = Html::tag('div', Html::img($src, ['width' => $this->imageWidth]), ['class' => $this->listClass.'_image']);
                $link = Html::tag('div', $link, ['class' => $this->listClass.'_link']);
                $populars[] = Html::tag('div', $image.$link, ['class' => $this->listClass.'_item']);
            } else { // Иначе добавляем в итоговый массив только ссылку на статью
                $populars[] = $link;
            }
        }
        // Определяем тип списка и вызываем соответствующий метод Html-хелпера для создания списка
        $list = $this->listType;
        $result = Html::$list($populars, ['encode' => false, 'class' => $this->listClass]);
        // Если необходимо, заворачиваем список в контейнер div
        if($this->container){
            $result = Html::tag('div', $result, ['class' => ($this->containerClass)?$this->containerClass:'container_'.$this->listClass]);
        }

        return $result;
    }

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