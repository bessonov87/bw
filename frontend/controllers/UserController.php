<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\User;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

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

        if(!$user){
            throw new NotFoundHttpException('Такого пользователя не существует. Проверьте правильно ли вы скопировали или ввели адрес в адресную строку. Если вы перешли на эту страницу по ссылке с данного сайта, сообщите пожалуйста о неработающей ссылке нам с помощью обратной связи.');
        }

        return $this->render('profile', ['user' => $user]);
    }
}