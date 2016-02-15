<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $id
 * @property string $reply_to
 * @property string $post_id
 * @property string $user_id
 * @property string $date
 * @property string $author
 * @property string $email
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
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reply_to', 'post_id', 'user_id', 'is_register', 'approve'], 'integer'],
            [['date'], 'safe'],
            [['text_raw', 'text'], 'required'],
            [['text_raw', 'text'], 'string'],
            [['author', 'email', 'ip'], 'string', 'max' => 40]
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
            'author' => 'Author',
            'email' => 'Email',
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
