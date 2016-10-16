<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $r_id
 * @property string $name
 * @property string $folder
 * @property integer $size
 * @property integer $user_id
 * @property integer $date
 * @property integer $download_count
 *
 * @property Post $post
 * @property User $user
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'name', 'size', 'user_id', 'date'], 'required'],
            [['post_id', 'size', 'user_id', 'date', 'download_count'], 'integer'],
            [['r_id'], 'string', 'max' => 6],
            [['name', 'folder'], 'string', 'max' => 255],
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
            'post_id' => 'Post ID',
            'r_id' => 'R ID',
            'name' => 'Name',
            'folder' => 'Folder',
            'size' => 'Size',
            'user_id' => 'User ID',
            'date' => 'Date',
            'download_count' => 'Download Count',
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
