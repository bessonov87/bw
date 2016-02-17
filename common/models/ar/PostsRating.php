<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "posts_rating".
 *
 * @property string $id
 * @property string $post_id
 * @property string $user_id
 * @property integer $score
 *
 * @property Post $post
 */
class PostsRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts_rating}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id'], 'required'],
            [['post_id', 'user_id', 'score'], 'integer'],
            [['post_id', 'user_id'], 'unique', 'targetAttribute' => ['post_id', 'user_id'], 'message' => 'Вы уже голосовали за эту статью.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'ID статьи',
            'user_id' => 'ID пользователя',
            'score' => 'Голос',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
