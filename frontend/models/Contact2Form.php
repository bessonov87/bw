<?php

namespace app\models;

use yii\base\Model;

class Contact2Form extends Model
{
    public $name, $email, $subject, $message;

    public function rules(){
        return [
                [['name', 'email', 'subject', 'message'], 'required', 'message' => 'Поле не может быть пустым'],
                [['name', 'email', 'subject', 'message'], 'trim'],
                ['email', 'email'],
            ];
    }
}