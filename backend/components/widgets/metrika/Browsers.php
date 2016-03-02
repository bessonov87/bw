<?php

namespace backend\components\widgets\metrika;

use Yii;
use yii\base\Widget;
use common\components\helpers\GlobalHelper;

class Browsers extends Widget
{
    public function getViewPath(){
        return '@backend/views/stats/widgets';
    }

    public function getData(){
        $data = GlobalHelper::getMetrikaData(['preset' => 'tech_platforms', 'dimensions' => 'ym:s:browser']);
        $colors = $this->colorPalette();
        $i = 0;
        $browsers = [];
        foreach($data->data as $browser){
            if(empty($colors)) $colors = $this->colorPalette();
            $browserData['value'] = $browser->metrics[0];
            $browserData['label'] = $browser->dimensions[0]->name;
            $browserData['color'] = array_shift($colors);
            $browserData['highlight'] = $this->lightenColor($browserData['color']);
            $browsers[] = $browserData;
            //$browsers[] = json_encode($browserData);
            $i++;
        }
        //$browsers = implode(',', $browsers);
        return $browsers;
    }

    public function run(){
        return $this->render('browsers', ['data' => $this->getData()]);
    }

    public function colorPalette(){
        return [
            'red' => '#dd4b39',
            'yellow' => '#f39c12',
            'aqua' => '#00c0ef',
            'green' => '#00a65a',
            'blue' => '#0073b7',
            'lime' => '#01ff70',
            'black' => '#111111',
            'orange' => '#ff851b',
            'navy' => '#001f3f',
            'light-blue' => '#3c8dbc',
            'fuchsia' => '#f012be',
            'teal' => '#39cccc',
            'purple' => '#605ca8',
            'olive' => '#3d9970',
            'gray' => '#d2d6de',
            'maroon' => '#d81b60',
        ];
    }

    public function lightenColor($hex, $amt = 10){
        $colorVal = hexdec($hex);
        $rgbArray['red'] = 0xFF & ($colorVal -->> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;

        $darkenRgb = array_map(function($c){
            $c = $c + 10;
            return ($c > 255) ? 255 : $c;
        }, $rgbArray);

        $darkenHex['red'] = dechex($darkenRgb['red']);
        $darkenHex['green'] = dechex($darkenRgb['green']);
        $darkenHex['blue'] = dechex($darkenRgb['blue']);

        $darkenHex = array_map(function($c){
            if(strlen($c) == 1){
                $c = '0'.$c;
            }
            return $c;
        }, $darkenHex);

        return "#" . implode('', $darkenHex);
    }
}