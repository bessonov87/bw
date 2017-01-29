<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%share}}".
 *
 * @property integer $id
 * @property string $url
 * @property integer $vk
 * @property integer $ok
 * @property integer $fa
 * @property integer $go
 * @property integer $mr
 * @property integer $created_at
 * @property integer $updated_at
 */
class Share extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%share}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'created_at'], 'required'],
            [['vk', 'ok', 'fa', 'go', 'mr', 'created_at', 'updated_at'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'vk' => 'Vk',
            'ok' => 'Ok',
            'fa' => 'Fa',
            'go' => 'Go',
            'mr' => 'Mr',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
