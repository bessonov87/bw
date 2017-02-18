<?php
namespace frontend\models\form;

use common\models\ar\User;
use yii\base\Model;
use Yii;

/**
 * Форма регистрации
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
            }
            if (!$user->save()) {
                \Yii::error("Can not save User {$user->email}. Errors: ".json_encode($user->getErrors()), __METHOD__);
            }
        } else {
            \Yii::error("Validation error. Page: signup. Errors: ".json_encode($this->getErrors()), __METHOD__);
        }

        return null;
    }
}
