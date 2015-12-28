<?php

namespace frontend\components;

use yii\web\UrlManager;

class SlUrlManager extends UrlManager
{

    public function createUrl($params){
        return $this->removePathSlashes(parent::createUrl($params));
    }

    protected function removePathSlashes($url)
    {
        return preg_replace('|\%2F|i', '/', $url);
    }
}