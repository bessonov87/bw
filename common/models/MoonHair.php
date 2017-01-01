<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%moon_hair}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property integer $post_id
 * @property integer $month
 * @property integer $year
 * @property string $short
 * @property string $full
 * @property integer $approve
 * @property integer $views
 * @property string $days
 */
class MoonHair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%moon_hair}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'date', 'month', 'year', 'short', 'full'], 'required'],
            [['post_id', 'month', 'year', 'approve', 'views'], 'integer'],
            [['short', 'full', 'days'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['date'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'post_id' => 'Post ID',
            'month' => 'Month',
            'year' => 'Year',
            'short' => 'Short',
            'full' => 'Full',
            'approve' => 'Approve',
            'views' => 'Views',
            'days' => 'Days',
        ];
    }
}
