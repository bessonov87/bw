<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%advert}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $block_number
 * @property string $code
 * @property string $location
 * @property string $replacement_tag
 * @property integer $category
 * @property integer $approve
 * @property integer $on_request
 */
class Advert extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advert}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'block_number', 'code', 'location'], 'required'],
            [['block_number', 'category', 'approve', 'on_request'], 'integer'],
            [['code'], 'string'],
            [['title', 'location'], 'string', 'max' => 255],
            [['replacement_tag'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'block_number' => 'Block Number',
            'code' => 'Code',
            'location' => 'Location',
            'replacement_tag' => 'Replacement Tag',
            'category' => 'Category',
            'approve' => 'Approve',
            'on_request' => 'On Request',
        ];
    }
}
