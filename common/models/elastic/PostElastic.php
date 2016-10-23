<?php

namespace common\models\elastic;


/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $date
 * @property integer $category_id
 * @property string $short
 * @property string $full
 * @property string $title
 * @property integer $views
 */
class PostElastic extends \yii\elasticsearch\ActiveRecord
{
    public static function index() {
        return 'index';
    }

    public static function type() {
        return 'post';
    }

    public function rules()
    {
        return [
            [['post_id', 'title', 'short', 'full', 'date', 'category_id', 'views'], 'required'],

        ];
    }

    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return [
            'id',
            'post_id',
            'title',
            'short',
            'full',
            'date',
            'category_id',
            'views',
        ];
    }


}