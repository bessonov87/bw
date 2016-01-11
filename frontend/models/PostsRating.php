<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class PostsRating extends ActiveRecord
{


    public static function tableName(){
        return 'posts_rating';
    }
}