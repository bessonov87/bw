<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 10.01.17
 * Time: 22:34
 */

namespace common\models\ar;

use common\models\ZnakiZodiaka as BaseZnakiZodiaka;
use yii\behaviors\TimestampBehavior;

class ZnakiZodiaka extends BaseZnakiZodiaka
{
    const TYPE_COMMON = 'common';
    const TYPE_MAN = 'man';
    const TYPE_WOMAN = 'woman';
    const TYPE_CHILD = 'child';
    const TYPE_CAREER = 'career';
    const TYPE_HEALTH = 'health';
    const TYPE_SEX = 'sex';

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
}