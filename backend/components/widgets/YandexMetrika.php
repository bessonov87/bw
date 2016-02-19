<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;

class YandexMetrika extends Widget
{
    public $period = 'month';
    public $graphType = 'line';

    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('metrika-graph', [
            'data' => $this->getData($this->period),
            'type' => $this->graphType,
        ]);
    }

    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    public function getData($period){
        if($period == 'today') {
            $start = date("Ymd");
            $end = date("Ymd");
        } elseif($period == 'month') {
            $start = date("Ymd", time() - 60*60*24*30);
            $end = date("Ymd");
        }
        $metrikaUrl = "http://api-metrika.yandex.ru/stat/traffic/summary.json?id=".Yii::$app->params['YandexCounterID']."&pretty=1&date1=$start&date2=$end&oauth_token=".Yii::$app->params['YandexToken'];
        //var_dump($metrikaUrl);

        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$metrikaUrl);
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $metrika = curl_exec ($ch);
        curl_close($ch);

        return json_decode($metrika);
    }
}