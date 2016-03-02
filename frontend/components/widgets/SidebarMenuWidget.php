<?php
namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * SidebarMenuWidget формирует меню в сайдбаре
 *
 * Пункты меню передаются в свойство items. Должны иметь формат:
 * 'items' => [
 *      ['label' => 'Текст ссылки', 'url' => ['маршрут']],      // Ссылка в виде маршрута (controllerID/actionID)
 *      ['label' => 'Текст ссылки', 'url' => 'адрес ссылки'],   // Ссылка в виде строки
 * ];
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class SidebarMenuWidget extends Widget
{
    /**
     * @var array список элементов меню
     */
    public $items = [];
    /**
     * @var string класс обертки меню
     */
    public $cssClass = 'sidebar_menu';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run() {
        if(empty($this->items)) {
            return '';
        }
        $result = '';
        foreach($this->items as $item) {
            $showItem = false;
            if(isset($item['allowedOn'])){
                $allowedOnArray = explode(',', $item['allowedOn']);
                $currentPageCategory = (array_key_exists('category', Yii::$app->params)) ? Yii::$app->params['category'] : '';
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