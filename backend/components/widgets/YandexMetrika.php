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
        $today=date("Ymd");
        $metrika_url = "http://api-metrika.yandex.ru/stat/traffic/summary.json?id=".Yii::$app->params['YandexCounterID']."&pretty=1&date1=$today&date2=$today&oauth_token=".Yii::$app->params['YandexToken'];
        //$metrika_url = 'https://api-metrika.yandex.ru/stat/traffic/summary?id=e55e67446a994432980f572fb4fa1149&oauth_token=134c6f1287224bb3ac736eb418707820';
        var_dump($metrika_url);

        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$metrika_url);
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $metrika = curl_exec ($ch);
        curl_close($ch);

        $metrika_o = json_decode($metrika);

        var_dump($metrika_o);
    }
}