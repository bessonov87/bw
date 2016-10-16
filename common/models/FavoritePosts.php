<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%favorite_posts}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property string $link
 * @property string $title
 * @property integer $date
 * @property integer $external
 *
 * @property Post $post
 * @property User $user
 */
class FavoritePosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%favorite_posts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'date'], 'required'],
            [['user_id', 'post_id', 'date', 'external'], 'integer'],
            [['link', 'title'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'post_id' => 'Post ID',
            'link' => 'Link',
            'title' => 'Title',
            'date' => 'Date',
            'external' => 'External',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
