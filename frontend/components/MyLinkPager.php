<?php
namespace app\components;

use Yii;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use common\components\helpers\GlobalHelper;


class MyLinkPager extends LinkPager
{
    public $cat = '';
    public $date = '';

    protected function renderPageButton($label, $page, $class, $disabled, $active){
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        $url = '';
        if($this->cat){
            $url .= '/'.GlobalHelper::getCategoryUrlById($this->cat[0]);
        }
        if(array_key_exists('date', Yii::$app->params)){
            $url .= '/'.Yii::$app->params['date'];
        }
        if($page != 0){
            $url .= '/page/'.($page+1);
        }
        $url .= '/';

        return Html::tag('li', Html::a($label, $url, $linkOptions), $options);
        //return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}