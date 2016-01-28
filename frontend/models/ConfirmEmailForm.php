<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ConfirmEmailForm extends Model
{
    public $token;
    public $userFound = false;

    /**
     * @var \common\models\User
     */
    private $_user = null;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if ($token != 'none') {
            if (!empty($token) && is_string($token)) {
                if($this->_user = User::findByEmailConfirmToken($token)){
                    $this->userFound = true;
                }
            }
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['token', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Код подтверждения',
        ];
    }

    /**
     * Активация пользователя
     *
     * @return boolean
     */
    public function activateUser()
    {
        $user = $this->_user;
        $user->setActive();
        $user->removeEmailConfirmToken();

        return $user->save(false);
    }
}
