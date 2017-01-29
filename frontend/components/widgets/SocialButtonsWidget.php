<?php

namespace app\components\widgets;

use yii\base\Widget;

/**
 * Социальные кнопки
 *
 * На данный момент кнопки выводятся с использованием стороннего ресурса (Pluso)
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class SocialButtonsWidget extends Widget
{
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
        return '';
        //return $this->render('social');
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/post';
    }
}