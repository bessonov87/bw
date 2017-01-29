<?php

namespace app\components\widgets;

use yii\base\Widget;

class SharerWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function run(){
        return $this->render('sharer');
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site';
    }
}