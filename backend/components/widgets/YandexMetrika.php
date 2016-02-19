<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;

class YandexMetrika extends Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('metrika-graph', ['data' => $this->data]);
    }

    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    public function getData(){

    }
}