<?php
namespace app\components\widgets;

use common\models\LoginForm;
use yii\base\Widget;

class LoginWidget extends Widget
{

    public function init(){
        parent::init();
    }

    public function run(){
        $model = new LoginForm();
        return $this->render('login-block', ['model' => $model]);
    }

    public function getViewPath(){
        return '@app/views/site';
    }

}