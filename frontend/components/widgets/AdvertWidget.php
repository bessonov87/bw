<?php
namespace app\components\widgets;

use yii\base\Widget;
use common\models\Advert;

/**
 * AdvertWidget подключает рекламу
 *
 * В качестве параметра в методе AdvertWidget::widget() должен передаваться номер блока, под которым он сохранен в
 * таблице advert базы данных приложения
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class AdvertWidget extends Widget
{
    public $block_number = null;

    public function init(){
        parent::init();
    }

    /**
     * Ищет рекламный блок по его номеру и возвращает код для втавки на страницу
     *
     * @return string
     */
    public function run(){
        if(!$this->block_number){
            return '';
        }

        $advert = Advert::findOne(['block_number' => $this->block_number]);

        return ($advert) ? $advert->code : '';
    }

}