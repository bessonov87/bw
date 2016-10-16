<?php

namespace common\models\ar;

use common\models\MoonCal as BaseMoonCal;

class MoonCal extends BaseMoonCal
{
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
