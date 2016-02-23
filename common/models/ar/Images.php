<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property string $id
 * @property string $image_name
 * @property string $folder
 * @property string $post_id
 * @property string $r_id
 * @property string $user_id
 * @property string $date
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
            [['image_name', 'folder', 'user_id'], 'required'],
            [['user_id', 'date'], 'integer'],
            [['post_id', 'r_id'], 'safe'],
            [['image_name', 'folder'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_name' => 'Images',
            'folder' => 'Папка',
            'post_id' => 'Post ID',
            'r_id' => 'R ID',
            'user_id' => 'User ID',
            'date' => 'Date',
        ];
    }
}
