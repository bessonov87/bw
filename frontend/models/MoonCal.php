<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "moon_cal".
 *
 * @property string $id
 * @property string $date
 * @property integer $moon_day
 * @property string $moon_day_from
 * @property string $moon_day_sunset
 * @property integer $moon_day2
 * @property string $moon_day2_from
 * @property string $moon_day2_sunset
 * @property integer $zodiak
 * @property string $zodiak_from_ut
 * @property integer $phase
 * @property string $phase_from
 * @property string $moon_percent
 * @property integer $blago
 */
class MoonCal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%moon_cal}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'moon_day', 'moon_day_from', 'moon_day_sunset', 'moon_day2_sunset', 'zodiak', 'phase', 'moon_percent', 'blago'], 'required'],
            [['date', 'moon_day_from', 'moon_day_sunset', 'moon_day2_from', 'moon_day2_sunset', 'zodiak_from_ut', 'phase_from'], 'safe'],
            [['moon_day', 'moon_day2', 'zodiak', 'phase', 'blago'], 'integer'],
            [['moon_percent'], 'string', 'max' => 5],
            [['date'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'moon_day' => 'Moon Day',
            'moon_day_from' => 'Moon Day From',
            'moon_day_sunset' => 'Moon Day Sunset',
            'moon_day2' => 'Moon Day2',
            'moon_day2_from' => 'Moon Day2 From',
            'moon_day2_sunset' => 'Moon Day2 Sunset',
            'zodiak' => 'Zodiak',
            'zodiak_from_ut' => 'Zodiak From Ut',
            'phase' => 'Phase',
            'phase_from' => 'Phase From',
            'moon_percent' => 'Moon Percent',
            'blago' => 'Blago',
        ];
    }
}
