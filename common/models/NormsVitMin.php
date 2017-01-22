<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%norms_vit_min}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $alt_name
 * @property string $unit
 * @property double $value
 * @property string $sex
 */
class NormsVitMin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%norms_vit_min}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alt_name', 'unit', 'value', 'sex'], 'required'],
            [['value'], 'number'],
            [['name', 'alt_name', 'unit', 'sex'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'alt_name' => 'Alt Name',
            'unit' => 'Unit',
            'value' => 'Value',
            'sex' => 'Sex',
        ];
    }
}
