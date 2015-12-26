<?php

namespace frontend\controllers;

use yii\web\Controller;
use app\models\User;
//use yii\base\Controller;

class UserController extends Controller{

    // ВСЕ ПОЛЬЗОВАТЕЛИ
    public function actionIndex(){
        $users = User::find()->all();
        return $this->render('index', ['users' => $users]);
    }

}