<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;

/**
 * HoroscopeWidget формирует гороскоп на день, который выводится в сайдбаре
 *
 * Гороскоп на день берется с сайта astrolis.ru. После получения данных в формате XML с сайта, они на 1 час кешируются.
 * Если в кеше нет данных с ключом daily_horoscope, на сайт отправляется запрос.
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class HoroscopeWidget extends Widget
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
        $xmlString = Yii::$app->cache->get('daily_horoscope');
        if(!$xmlString) {
            /*подключаем xml файл*/
            $xmlString = file_get_contents("http://astrolis.ru/goroskop_na_segodnja.php");
            Yii::$app->cache->set('daily_horoscope', $xmlString, 3600);
        }
        $xml = simplexml_load_string($xmlString);
        return $this->renderFile('@app/views/site/horoscope.php', ['xml' => $xml]);
    }
}