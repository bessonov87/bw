<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%moon_ogorod}}".
 *
 * @property integer $id
 * @property integer $month
 * @property integer $zodiak
 * @property integer $phase
 * @property string $text
 */
class MoonOgorod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%moon_ogorod}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['month', 'zodiak', 'phase', 'text'], 'required'],
            [['month', 'zodiak', 'phase'], 'integer'],
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
            'month' => 'Month',
            'zodiak' => 'Zodiak',
            'phase' => 'Phase',
            'text' => 'Text',
        ];
    }
}
