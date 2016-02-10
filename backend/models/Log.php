<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property string $id
 * @property string $level
 * @property string $category
 * @property string $log_time
 * @property string $prefix
 * @property string $message
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'category', 'log_time', 'prefix', 'message'], 'required'],
            [['message'], 'string'],
            [['level', 'category', 'log_time', 'prefix'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'category' => 'Category',
            'log_time' => 'Log Time',
            'prefix' => 'Prefix',
            'message' => 'Message',
        ];
    }

    /**
     * Получает из сообщения лога адрес страницы, обращение к которой вызвало ошибку
     *
     * @return string
     */
    public function getPage(){
        if(!strstr($this->message, '_SERVER')){
            return 'Unknown';
        }

        preg_match("@'REQUEST_URI' => '/(.*)'@", $this->message, $matches);
        if(isset($matches[1])){
            return Yii::$app->params['frontendBaseUrl'].$matches[1];
        }

        return 'Unknown';
    }
}
