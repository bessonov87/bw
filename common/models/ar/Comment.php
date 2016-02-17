<?php

namespace common\models\ar;

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
 * @property string $text
 * @property string $text_raw
 * @property string $ip
 * @property integer $is_register
 * @property integer $approve
 *
 * @property User $user
 * @property Post $post
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
            [['reply_to', 'post_id', 'user_id', 'is_register', 'approve'], 'integer'],
            [['date', 'text_raw'], 'safe'],
            [['text'], 'required'],
            [['text'], 'string'],
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
            'reply_to' => 'Ответ на',
            'post_id' => 'ID статьи',
            'user_id' => 'User',
            'date' => 'Добавлен',
            'author' => 'Автор',
            'email' => 'Email',
            'text' => 'Text',
            'ip' => 'IP',
            'is_register' => 'Is Register',
            'approve' => 'Approve',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->joinWith('profile');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
