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
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
}