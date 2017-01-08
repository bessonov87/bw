<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%goroskop}}".
 *
 * @property integer $id
 * @property integer $zodiak
 * @property integer $created_at
 * @property string $text
 * @property string $date
 * @property integer $week
 * @property integer $month
 * @property integer $year
 * @property string $period
 * @property string $type
 * @property integer $approve
 * @property integer $views
 */
class Goroskop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goroskop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zodiak', 'created_at', 'week', 'month', 'year', 'approve', 'views'], 'integer'],
            [['text', 'year', 'period', 'type'], 'required'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['period', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zodiak' => 'Zodiak',
            'created_at' => 'Created At',
            'text' => 'Text',
            'date' => 'Date',
            'week' => 'Week',
            'month' => 'Month',
            'year' => 'Year',
            'period' => 'Period',
            'type' => 'Type',
            'approve' => 'Approve',
            'views' => 'Views',
        ];
    }
}
