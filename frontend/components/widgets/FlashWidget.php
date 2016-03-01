<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class FlashWidget extends Widget
{
    public function run(){
        $content = '';
        $flashes = \Yii::$app->session->getAllFlashes(false);
        if(!empty($flashes)){
            foreach($flashes as $type => $flash){
                $content .= Html::tag('div', $flash, ['class' => 'alert alert-'.$type]);
            }
            $content .= Html::tag('div', 'Закрыть <i class="fa fa-times"></i>', ['class' => 'flash-message-close']);
            $js = '$(".flash-message").slideDown();';
            $js .= '$(".flash-message-close").on("click", function(){
            $(".flash-message").fadeOut();
        });';

            $this->view->registerJs($js);
            echo Html::tag('div', $content, ['class' => 'flash-message']);
        }
    }
}