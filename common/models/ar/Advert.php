<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "advert".
 *
 * @property string $id
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
            [['title'], 'string', 'max' => 200],
            [['location'], 'string', 'max' => 10],
            [['replacement_tag'], 'string', 'max' => 20],
            [['block_number'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'block_number' => 'Номер блока',
            'code' => 'Код вставки',
            'location' => 'Место',
            'replacement_tag' => 'Тэг замены',
            'category' => 'Категория',
            'approve' => 'Разрешен?',
            'on_request' => 'On Request',
        ];
    }
}
