<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favorite_posts".
 *
 * @property string $id
 * @property string $user_id
 * @property string $post_id
 * @property string $link
 * @property string $title
 * @property string $date
 * @property integer $external
 *
 * @property User $user
 * @property Post $post
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
            [['user_id', 'post_id'], 'required'],
            [['user_id', 'post_id', 'external'], 'integer'],
            [['date'], 'safe'],
            [['link'], 'string', 'max' => 200],
            [['title'], 'string', 'max' => 250],
            [['user_id', 'post_id'], 'unique', 'targetAttribute' => ['user_id', 'post_id'], 'message' => 'Вы уже добавили данную статью в избранное.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'post_id' => 'ID статьи',
            'link' => 'Ссылка',
            'title' => 'Заголовок',
            'date' => 'Дата добавления',
            'external' => 'Внешняя?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
