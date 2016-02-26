<?php

namespace frontend\controllers;

use common\models\ar\UserProfile;
use frontend\models\form\EditProfileForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\ar\User;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class UserController extends Controller{

    public $defaultAction = 'all';
    public $layout = 'user-layout';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['edit'],
                'rules' => [
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    // ВСЕ ПОЛЬЗОВАТЕЛИ
    public function actionAll(){
        $users = User::find()->all();
        return $this->render('index', ['users' => $users]);
    }

    /**
     * Отображает страниу с информацией о пользователе
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProfile(){
        return $this->render('profile', ['user' => $this->user]);
    }

    public function actionEdit(){
        $username = \Yii::$app->request->get('username');
        if($username !== \Yii::$app->user->identity->username){
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $userId = \Yii::$app->user->getId();
        $model = $this->findModel($userId);

        if($model->load(Yii::$app->request->post())) {
            $avatar = UploadedFile::getInstance($model, 'image');
            if($model->validate()) {
                if($avatar) $model->uploadAvatar($avatar);
                if($model->saveProfile()){
                    Yii::$app->session->setFlash('success', 'Профиль успешно изменен.');
                    $this->redirect('/user/'.$username.'/');
                }
            }
        }

        return $this->render('edit', ['model' => $model, 'user' => $this->user]);
    }

    public function getUser(){
        $user = User::find()
            ->where(['username' => \Yii::$app->request->get('username')])
            ->joinWith('profile')
            ->limit(1)
            ->one();

        if(!$user){
            throw new NotFoundHttpException('Такого пользователя не существует. Проверьте правильно ли вы скопировали или ввели адрес в адресную строку. Если вы перешли на эту страницу по ссылке с данного сайта, сообщите пожалуйста о неработающей ссылке нам с помощью обратной связи.');
        }

        return $user;
    }

    /**
     * Finds the EditProfileForm model, which extend UserProfile model (based on its primary key value).
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var $model EditProfileForm */
        if (($model = EditProfileForm::findOne($id)) !== null) {
            if($model->birth_date) {
                $birth_date = strtotime($model->birth_date);
                $model->birthYear = date('Y', $birth_date);
                $model->birthMonth = date('m', $birth_date);
                $model->birthDay = date('j', $birth_date);
            }
            return $model;
        } else {
            throw new NotFoundHttpException('Страница не найдена или недоступна.');
        }
    }
}