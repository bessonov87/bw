<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%moon_dni}}".
 *
 * @property integer $id
 * @property integer $num
 * @property string $text
 * @property integer $blago
 */
class MoonDni extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%moon_dni}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num', 'text', 'blago'], 'required'],
            [['num', 'blago'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num' => 'Num',
            'text' => 'Text',
            'blago' => 'Blago',
        ];
    }
}
