<?php

namespace frontend\controllers;

use common\models\ar\Auth;
use frontend\components\behaviors\UrlBehavior;
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

/**
 * User controller
 */
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
            'url' => [
                'class' => UrlBehavior::className(),
                'exceptions' => ['edit'],
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

    /**
     * Редактирование профиля пользователя
     *
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
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
                    /*Yii::$app->session->setFlash('success', 'Профиль успешно изменен.');
                    $this->redirect('/user/'.$username.'/');*/
                    Yii::$app->session->setFlash('success','Профиль успешно изменен',false);
                    $this->redirect(['user/profile', 'username' => $username]);
                    //$this->redirect(array('index','param'=>'Профиль успешно изменен'));
                }
            }
        }

        return $this->render('edit', ['model' => $model, 'user' => $this->user]);
    }

    /**
     * Привязка аккаунтов социальных сетей к учетной записи пользователя
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionSocial(){
        //var_dump(Yii::$app->request->get('username'));
        $username = \Yii::$app->request->get('username');
        if($username !== \Yii::$app->user->identity->username){
            throw new ForbiddenHttpException('Доступ запрещен');
        }
        $userId = \Yii::$app->user->getId();
        $auths = Auth::find()->where(['user_id' => $userId])->all();

        return $this->render('social', ['auths' => $auths]);
    }

    /**
     * Получает объект класса User по username
     *
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
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