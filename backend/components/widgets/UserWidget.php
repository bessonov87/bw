<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 15.02.2016
 * Time: 18:32
 */

namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use common\models\User;


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