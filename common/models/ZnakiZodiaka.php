<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%znaki_zodiaka}}".
 *
 * @property integer $id
 * @property integer $znak_id
 * @property string $element
 * @property string $planet
 * @property string $opposite
 * @property string $stone
 * @property string $color
 * @property string $compatibility
 * @property string $common
 * @property string $man
 * @property string $woman
 * @property string $child
 * @property string $career
 * @property string $health
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Sovmestimost[] $sovmestimosts
 * @property Sovmestimost[] $sovmestimosts0
 * @property ZnakiZodiaka[] $women
 * @property ZnakiZodiaka[] $men
 */
class ZnakiZodiaka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%znaki_zodiaka}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['znak_id', 'element', 'planet', 'opposite', 'stone', 'color', 'compatibility', 'common', 'man', 'woman', 'child', 'career', 'health'], 'required'],
            [['znak_id', 'created_at', 'updated_at'], 'integer'],
            [['common', 'man', 'woman', 'child', 'career', 'health'], 'string'],
            [['element', 'planet', 'opposite', 'stone', 'color', 'compatibility'], 'string', 'max' => 255],
            [['znak_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'znak_id' => 'Znak ID',
            'element' => 'Element',
            'planet' => 'Planet',
            'opposite' => 'Opposite',
            'stone' => 'Stone',
            'color' => 'Color',
            'compatibility' => 'Compatibility',
            'common' => 'Common',
            'man' => 'Man',
            'woman' => 'Woman',
            'child' => 'Child',
            'career' => 'Career',
            'health' => 'Health',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSovmestimosts()
    {
        return $this->hasMany(Sovmestimost::className(), ['man' => 'znak_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSovmestimosts0()
    {
        return $this->hasMany(Sovmestimost::className(), ['woman' => 'znak_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWomen()
    {
        return $this->hasMany(ZnakiZodiaka::className(), ['znak_id' => 'woman'])->viaTable('{{%sovmestimost}}', ['man' => 'znak_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMen()
    {
        return $this->hasMany(ZnakiZodiaka::className(), ['znak_id' => 'man'])->viaTable('{{%sovmestimost}}', ['woman' => 'znak_id']);
    }
}
