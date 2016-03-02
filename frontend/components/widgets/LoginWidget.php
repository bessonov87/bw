<?php
namespace app\components\widgets;

use yii\base\Widget;
use common\models\LoginForm;

/**
 * LoginWidget выводит блок "Вход на сайт" в сайдбаре
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class LoginWidget extends Widget
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
        $model = new LoginForm();
        return $this->render('login-block', ['model' => $model]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site';
    }

}