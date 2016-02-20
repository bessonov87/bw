<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property string $id
 * @property string $images
 * @property string $post_id
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
            [['id', 'images', 'post_id', 'user_id'], 'required'],
            [['id', 'post_id', 'user_id'], 'integer'],
            [['images'], 'string'],
            [['date'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'images' => 'Images',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'date' => 'Date',
        ];
    }
}
