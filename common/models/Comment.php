<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $reply_to
 * @property integer $post_id
 * @property integer $user_id
 * @property integer $date
 * @property string $text_raw
 * @property string $text
 * @property string $ip
 * @property integer $is_register
 * @property integer $approve
 *
 * @property Post $post
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reply_to', 'post_id', 'user_id', 'date', 'is_register', 'approve'], 'integer'],
            [['post_id', 'user_id', 'date', 'text_raw', 'text', 'ip'], 'required'],
            [['text_raw', 'text'], 'string'],
            [['ip'], 'string', 'max' => 255],
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
            'reply_to' => 'Reply To',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'text_raw' => 'Text Raw',
            'text' => 'Text',
            'ip' => 'Ip',
            'is_register' => 'Is Register',
            'approve' => 'Approve',
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
