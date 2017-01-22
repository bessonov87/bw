<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%norms_fat_prot}}".
 *
 * @property integer $id
 * @property string $sex
 * @property integer $groupa
 * @property string $age
 * @property integer $energy
 * @property integer $protein
 * @property integer $fat
 * @property integer $carbohydrate
 */
class NormsFatProt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%norms_fat_prot}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'age'], 'required'],
            [['groupa', 'energy', 'protein', 'fat', 'carbohydrate'], 'integer'],
            [['sex', 'age'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sex' => 'Sex',
            'groupa' => 'Groupa',
            'age' => 'Age',
            'energy' => 'Energy',
            'protein' => 'Protein',
            'fat' => 'Fat',
            'carbohydrate' => 'Carbohydrate',
        ];
    }
}
