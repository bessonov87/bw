<?php
namespace app\components\widgets;

use yii\base\Widget;
use common\models\ar\User;

/**
 * Информация о пользователе
 *
 * Выводится в сайдбаре в user-layout
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class UserWidget extends Widget
{
    /**
     * @var string логин пользователя
     */
    public $username;

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/user';
    }

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
        $user = User::find()
            ->where(['username' => \Yii::$app->request->get('username')])
            ->limit(1)
            ->one();

        if($user){
            return $this->render('sidebar', ['user' => $user]);
        }
    }
}