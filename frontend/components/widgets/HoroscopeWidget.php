<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;

class HoroscopeWidget extends Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        $xmlString = Yii::$app->cache->get('daily_horoscope');
        if(!$xmlString) {
            /*подключаем xml файл*/
            $xmlString = file_get_contents("http://astrolis.ru/goroskop_na_segodnja.php");
            Yii::$app->cache->set('daily_horoscope', $xmlString, 3600);
        }
        $xml = simplexml_load_string($xmlString);

        /*проходим циклом по xml документу*/
        return $this->renderFile('@app/views/site/horoscope.php', ['xml' => $xml]);

    }
}