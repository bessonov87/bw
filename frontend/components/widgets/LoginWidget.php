<?php
namespace app\components\widgets;

use yii\base\Widget;
use common\models\LoginForm;

/**
 * LoginWidget
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
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