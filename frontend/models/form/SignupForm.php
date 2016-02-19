<?php
namespace frontend\models\form;

use common\models\ar\User;
use common\models\ar\UserProfile;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordRepeat;
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\ar\User', 'message' => 'Данное имя пользователя уже занято.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\ar\User', 'message' => 'Этот email адрес уже зарегистрирован в системе. Возможно, вы регистрировались ранее. Попробуйте восстановить пароль для входа на сайт.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],

            ['captcha', 'captcha'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повтор пароля',
            'captcha' => 'Проверочный код',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            // Если необходима активация email адресов
            if(Yii::$app->params['emailActivation'] == true){
                $user->status = $user::STATUS_NOT_ACTIVE;
                $user->generateEmailConfirmToken();
                $user->sendEmailConfirm();
            }
            $transaction = Yii::$app->db->beginTransaction();
            if ($r = $user->save()) {
                $profile = new UserProfile();
                $profile->user_id = $user->id;
                if($profile->save()){
                    $transaction->commit();
                    return $user;
                } else {
                    $transaction->rollBack();
                }
            } else {
                $transaction->rollBack();
            }
        }

        return null;
    }
}
