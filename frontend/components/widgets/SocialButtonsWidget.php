<?php

namespace app\components;

use yii\base\Widget;

class SocialButtonsWidget extends Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('social');
    }

    public function getViewPath(){
        return '@app/views/post';
    }
}