<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use common\models\ar\User;

/**
 * Class UserWidget Виждет, выводит информацию о текущем пользователе Админпанели
 * @package app\components\widgets
 */
class UserWidget extends Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        $user = User::findByUsername(Yii::$app->user->identity->username);
        return $this->render('user-widget', ['user' => $user]);
    }

    public function getViewPath(){
        return '@app/views/site';
    }
}