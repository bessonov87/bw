<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email_confirm_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_BANNED = 1;
    const STATUS_TEMPORARY_BANNED = 2;
    const STATUS_SUPERUSER = 7;
    const STATUS_NOT_ACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'integer', 'max' => self::STATUS_ACTIVE, 'min' => self::STATUS_DELETED],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return static::find()
            ->where(['id' => $id])
            ->andWhere(['not in', 'status', [self::STATUS_DELETED, self::STATUS_BANNED]])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->where(['username' => $username])
            ->andWhere(['not in', 'status', [self::STATUS_DELETED, self::STATUS_BANNED]])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Поиск пользователя по токену подтверждения email
     *
     * @param string $token
     * @return null|static
     */
    public static function findByEmailConfirmToken($token) {
        if(!static::isEmailConfirmTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'email_confirm_token' => $token,
            'status' => self::STATUS_NOT_ACTIVE,
        ]);
    }

    /**
     * Проверка токена подтверждения email на валидность
     *
     * Валидность определяется временем действия, задаваемым в параметрах приложения
     * в свойстве user.emailConfirmTokenExpire
     *
     * @param $token
     * @return bool
     */
    public static function isEmailConfirmTokenValid($token){
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.emailConfirmTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function setActive() {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Генерация токена подтверждения email
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Очистка токена подтверждения email
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    public function sendEmailConfirm(){
        if(!$this->email_confirm_token){
            $this->generateEmailConfirmToken();
        }
        return \Yii::$app->mailer->compose(['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-text'], ['user' => $this])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Код подтверждения email адреса для сайта ' . \Yii::$app->name)
            ->send();
    }

    /**
     * Зависимость профиля
     */
    public function getProfile(){
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * Адрес страницы пользователя
     */
    public function getMyPage(){
        return '/user/'.$this->username.'/';
    }

    /**
     * Аватар пользователя
     */
    public function getAvatar(){
        if(!$this->profile->avatar){
            $avatar = ($this->profile->sex == 'm') ? 'noavatar_male.png' : 'noavatar_female.png';
        } else {
            $avatar = $this->profile->avatar;
        }
        return Yii::$app->params['paths']['avatar'].$avatar;
    }
}
