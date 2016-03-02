<?php

namespace app\components\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * FlashWidget выводит flash сообщения в специальном div, фиксированном в верхней части страницы
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class FlashWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function run(){
        $content = '';
        $flashes = \Yii::$app->session->getAllFlashes(false);
        if(!empty($flashes)){
            foreach($flashes as $type => $flash){
                if($type == 'error') $type = 'danger';
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