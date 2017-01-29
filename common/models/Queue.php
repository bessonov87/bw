<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%queue}}".
 *
 * @property integer $id
 * @property string $taskData
 * @property integer $priority
 * @property string $taskType
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $message
 */
class Queue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%queue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taskData', 'taskType', 'created_at'], 'required'],
            [['taskData'], 'string'],
            [['priority', 'created_at', 'updated_at', 'status'], 'integer'],
            [['taskType', 'message'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'taskData' => 'Task Data',
            'priority' => 'Priority',
            'taskType' => 'Task Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'message' => 'Message',
        ];
    }
}
