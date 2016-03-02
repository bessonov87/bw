<?php

namespace frontend\components;

use yii\web\UrlManager;

/**
 * SlUrlManager расширяет метод createUrl стандартного UrlManager YII2
 *
 * Слэши, разделяющие категорию и подкатегорию, экранируются. Метод removePathSlashes заменяет '%2F' обратно на '/'
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class SlUrlManager extends UrlManager
{

    public function createUrl($params){
        return $this->removePathSlashes(parent::createUrl($params));
    }

    /**
     * Заменяет '%2F' обратно на '/'
     * @param $url
     * @return mixed
     */
    protected function removePathSlashes($url)
    {
        return preg_replace('|\%2F|i', '/', $url);
    }
}