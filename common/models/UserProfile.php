<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property string $user_id
 * @property string $name
 * @property string $surname
 * @property string $birth_date
 * @property string $country
 * @property string $avatar
 * @property string $info
 * @property string $signature
 * @property string $last_visit
 * @property string $last_ip
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
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['birth_date', 'last_visit'], 'safe'],
            [['info'], 'string'],
            [['name', 'surname'], 'string', 'max' => 50],
            [['country'], 'string', 'max' => 3],
            [['avatar'], 'string', 'max' => 100],
            [['signature'], 'string', 'max' => 255],
            [['last_ip'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'birth_date' => 'Birth Date',
            'country' => 'Country',
            'avatar' => 'Avatar',
            'info' => 'Info',
            'signature' => 'Signature',
            'last_visit' => 'Last Visit',
            'last_ip' => 'Last Ip',
        ];
    }
}
