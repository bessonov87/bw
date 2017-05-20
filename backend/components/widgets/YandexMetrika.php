<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;

/**
 * Class YandexMetrika Виджет, выводит график посещаемости за последний месяц на странице Dashboard
 * @package app\components\widgets
 */
class YandexMetrika extends Widget
{
    /**
     * @var string период графика по умолчанию
     */
    public $period = 'month';
    /**
     * @var string тип графика по умолчанию
     */
    public $graphType = 'line';

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

        return 'График Метрики Временно недоступен';

        /*return $this->render('metrika-graph', [
            'data' => $this->getData($this->period),
            'type' => $this->graphType,
        ]);*/
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    /**
     * Получение данных Метрики
     *
     * @param $period
     * @return mixed
     */
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
        $metrikaUrl = "https://api-metrika.yandex.ru/stat/v1/data?metrics=ym:s:visits&id=".Yii::$app->params['YandexCounterID']."&oauth_token=".Yii::$app->params['YandexToken'];

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