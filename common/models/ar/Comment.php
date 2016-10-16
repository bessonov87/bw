<?php

namespace common\models\ar;

use common\models\Comment as BaseComment;

class Comment extends BaseComment
{
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
}
