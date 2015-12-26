<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    const ACTIVE = 1;

    public static function tableName(){
        return 'user';
    }

}