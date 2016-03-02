<?php

namespace app\components\widgets;

use yii\base\Widget;
use frontend\models\form\SearchForm;

/**
 * SearchWidget поиск по сайту
 *
 * TODO Расширенные параметры поиска
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class SearchWidget extends Widget
{
    /**
     * @var bool выводить полную форму (на странице с результатами поиска) или урезанную версию (в шапке сайта)
     */
    public $full = false;

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
        $model = new SearchForm();
        if($this->full){
            return $this->render('search-form-full', ['model' => $model]);
        }
        return $this->render('search-form', ['model' => $model]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath() {
        return '@app/views/site';
    }
}