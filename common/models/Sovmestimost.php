<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sovmestimost}}".
 *
 * @property integer $id
 * @property integer $man
 * @property integer $woman
 * @property string $text
 * @property integer $created_at
 *
 * @property ZnakiZodiaka $man0
 * @property ZnakiZodiaka $woman0
 */
class Sovmestimost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sovmestimost}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['man', 'woman', 'text'], 'required'],
            [['man', 'woman', 'created_at'], 'integer'],
            [['text'], 'string'],
            [['man', 'woman'], 'unique', 'targetAttribute' => ['man', 'woman'], 'message' => 'The combination of Man and Woman has already been taken.'],
            [['man'], 'exist', 'skipOnError' => true, 'targetClass' => ZnakiZodiaka::className(), 'targetAttribute' => ['man' => 'znak_id']],
            [['woman'], 'exist', 'skipOnError' => true, 'targetClass' => ZnakiZodiaka::className(), 'targetAttribute' => ['woman' => 'znak_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'man' => 'Man',
            'woman' => 'Woman',
            'text' => 'Text',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMan0()
    {
        return $this->hasOne(ZnakiZodiaka::className(), ['znak_id' => 'man']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWoman0()
    {
        return $this->hasOne(ZnakiZodiaka::className(), ['znak_id' => 'woman']);
    }
}
