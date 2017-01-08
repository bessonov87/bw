<?php

namespace common\models\ar;

use common\models\Goroskop as BaseGoroskop;

class Goroskop extends BaseGoroskop
{
    const TYPE_COMMON = 'common';
    const TYPE_VOSTOK = 'vostok';

    const PERIOD_DAY = 'day';
    const PERIOD_WEEK = 'week';
    const PERIOD_MONTH = 'month';
    const PERIOD_YEAR = 'year';

    public static function zodiakFilter()
    {
        return [
            0 => 'Все', 1 => 'Овен', 2 => 'Телец', 3 => 'Близнецы', 4 => 'Рак', 5 => 'Лев', 6 => 'Дева',
            7 => 'Весы', 8 => 'Скорпион', 9 => 'Стрелец', 10 => 'Козерог', 11 => 'Водолей', 12 => 'Рыбы'
        ];
    }

    public static function periodFilter()
    {
        return [
            self::PERIOD_DAY => 'День', self::PERIOD_WEEK => 'Неделя', self::PERIOD_MONTH => 'Месяц', self::PERIOD_YEAR => 'Год'
        ];
    }

    public static function typeFilter()
    {
        return [
            self::TYPE_COMMON => 'Общий', self::TYPE_VOSTOK => 'Восточный'
        ];
    }
}