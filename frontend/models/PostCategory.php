<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class PostCategory extends ActiveRecord
{
    public static function tableName(){
        return '{{%post_category}}';
    }
}