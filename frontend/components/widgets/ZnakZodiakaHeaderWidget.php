<?php

namespace app\components\widgets;

use yii\base\Widget;

class ZnakZodiakaHeaderWidget extends Widget
{
    public $znakModel = null;

    public function run()
    {
        if(!$this->znakModel){
            return '';
        }

        return $this->render('znaki-header', [
            'znakModel' => $this->znakModel
        ]);
    }

    public function getViewPath()
    {
        return '@frontend/views/znaki-zodiaka/';
    }
}