<?php

namespace app\components\widgets;

use common\components\helpers\GlobalHelper;
use Yii;
use yii\base\Widget;

/**
 * Class SiteSummary Виджет, выводит информацию о статьях, пользователях, комментариях и ошибках
 * @package app\components\widgets
 */
class SiteSummary extends Widget
{
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
        return $this->render('site-summary', ['summary' => $this->summary]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    /**
     * Получение информации о статьях, пользователях, комментариях и ошибках из базы данных
     * @return mixed
     */
    public function getSummary(){
        return GlobalHelper::getSiteSummary();
    }
}