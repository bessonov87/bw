<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%images}}".
 *
 * @property integer $id
 * @property string $image_name
 * @property string $folder
 * @property integer $post_id
 * @property string $r_id
 * @property integer $user_id
 * @property integer $date
 *
 * @property User $user
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_name', 'user_id', 'date'], 'required'],
            [['post_id', 'user_id', 'date'], 'integer'],
            [['image_name', 'folder'], 'string', 'max' => 255],
            [['r_id'], 'string', 'max' => 6],
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
            'image_name' => 'Image Name',
            'folder' => 'Folder',
            'post_id' => 'Post ID',
            'r_id' => 'R ID',
            'user_id' => 'User ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
