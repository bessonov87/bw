<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\User;
use yii\helpers\Html;

class UserController extends Controller{

    public $defaultAction = 'all';
    public $layout = 'user-layout';

    // ВСЕ ПОЛЬЗОВАТЕЛИ
    public function actionAll(){
        $users = User::find()->all();
        return $this->render('index', ['users' => $users]);
    }

    public function actionProfile(){
        $user = User::find()
            ->where(['username' => \Yii::$app->request->get('username')])
            ->joinWith('profile')
            ->limit(1)
            ->one();

        return $this->render('profile', ['user' => $user]);
    }
}