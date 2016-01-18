<?php
namespace app\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class SidebarMenuWidget extends Widget
{
    public $items = [];

    public $cssClass = 'sidebar_menu';

    public function init() {
        parent::init();
    }

    public function run() {

        if(empty($this->items))
            return '***';

        $result = '';
        foreach($this->items as $item) {
            $showItem = false;
            if(isset($item['allowedOn'])){
                $allowedOnArray = explode(',', $item['allowedOn']);
                $currentPageCategory = Yii::$app->params['category'];
                if(is_array($currentPageCategory)){
                    foreach($currentPageCategory as $value){
                        if(in_array($value, $allowedOnArray)){
                            $showItem = true;
                            break;
                        }
                    }
                }
            } else {
                $showItem = true;
            }

            if($showItem) {
                $result .= Html::a($item['label'], $item['url']);
            }
        }

        return Html::tag('div', $result, ['class' => $this->cssClass]);

    }
}