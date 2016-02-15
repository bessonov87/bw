<?php
namespace app\components\widgets;

use yii\base\Widget;
use common\models\Advert;

class AdvertWidget extends Widget
{
    public $block_number = null;

    public function init(){
        parent::init();
    }

    public function run(){
        if(!$this->block_number){
            return '';
        }

        $advert = Advert::findOne(['block_number' => $this->block_number]);

        return ($advert) ? $advert->code : '';
    }

}