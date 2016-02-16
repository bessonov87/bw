<?php

namespace app\components\widgets;

use yii\base\Widget;
use frontend\models\SearchForm;

class SearchWidget extends Widget
{
    public $full = false;

    public function init(){
        parent::init();
    }

    public function run(){
        $model = new SearchForm();
        if($this->full){
            return $this->render('search-form-full', ['model' => $model]);
        }
        return $this->render('search-form', ['model' => $model]);
    }

    public function getViewPath() {
        return '@app/views/site';
    }
}