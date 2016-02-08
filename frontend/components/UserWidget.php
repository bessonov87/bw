<?php
namespace app\components;

use yii\base\Widget;
use common\models\User;

class UserWidget extends Widget
{
    public $username;

    public function getViewPath(){
        return '@app/views/user';
    }

    public function init(){
        parent::init();
    }

    public function run(){
        $user = User::find()
            ->where(['username' => \Yii::$app->request->get('username')])
            ->joinWith('profile')
            ->limit(1)
            ->one();

        if($user){
            return $this->render('sidebar', ['user' => $user]);
        }
    }
}