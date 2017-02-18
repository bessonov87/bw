<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email_confirm_token
 * @property string $email
 * @property integer $status
 * @property integer $user_group
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_at
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
 * @property Auth[] $auths
 * @property Comment[] $comments
 * @property FavoritePosts[] $favoritePosts
 * @property Files[] $files
 * @property Images[] $images
 * @property Post[] $posts
 * @property PostsRating[] $postsRatings
 * @property UserProfile $userProfile
 */
class User extends \yii\db\ActiveRecord
{
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
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at'], 'required'],
            [['status', 'user_group', 'created_at', 'updated_at', 'last_login_at', 'last_visit'], 'integer'],
            [['birth_date'], 'safe'],
            [['info'], 'string'],
            [['username', 'password_hash', 'password_reset_token', 'email_confirm_token', 'email', 'name', 'surname', 'country', 'city', 'avatar', 'signature', 'last_ip'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['sex'], 'string', 'max' => 1],
            [['email_confirm_token'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email_confirm_token' => 'Email Confirm Token',
            'email' => 'Email',
            'status' => 'Status',
            'user_group' => 'User Group',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_login_at' => 'Last Login At',
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
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritePosts()
    {
        return $this->hasMany(FavoritePosts::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostsRatings()
    {
        return $this->hasMany(PostsRating::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
}
