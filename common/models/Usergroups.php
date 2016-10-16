<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%usergroups}}".
 *
 * @property integer $id
 * @property string $group_name
 * @property integer $captcha
 * @property string $icon
 */
class Usergroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usergroups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_name'], 'required'],
            [['captcha'], 'integer'],
            [['group_name', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => 'Group Name',
            'captcha' => 'Captcha',
            'icon' => 'Icon',
        ];
    }
}
