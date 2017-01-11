<?php

namespace common\models\ar;

use common\models\Sovmestimost as BaseSovmestimost;
use yii\behaviors\TimestampBehavior;

class Sovmestimost extends BaseSovmestimost
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }
}