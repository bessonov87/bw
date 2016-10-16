<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property string $sex
 * @property string $name
 * @property string $surname
 * @property string $birth_date
 * @property string $country
 * @property string $city
 * @property string $avatar
 * @property string $info
 * @property string $signature
 * @property integer $last_visit
 * @property string $last_ip
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birth_date'], 'safe'],
            [['info'], 'string'],
            [['last_visit'], 'integer'],
            [['sex'], 'string', 'max' => 1],
            [['name', 'surname', 'country', 'city', 'avatar', 'signature', 'last_ip'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'sex' => 'Sex',
            'name' => 'Name',
            'surname' => 'Surname',
            'birth_date' => 'Birth Date',
            'country' => 'Country',
            'city' => 'City',
            'avatar' => 'Avatar',
            'info' => 'Info',
            'signature' => 'Signature',
            'last_visit' => 'Last Visit',
            'last_ip' => 'Last Ip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
