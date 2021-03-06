<?php

namespace frontend\models\form;

use Yii;
use yii\base\Model;

/**
 * Форма обратной связи
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class Contact2Form extends Model
{
    public $name, $email, $subject, $message, $ip;

    public function rules(){
        return [
                [['name', 'email', 'subject', 'message'], 'required', 'message' => 'Поле не может быть пустым'],
                [['name', 'email', 'subject', 'message'], 'trim'],
                ['email', 'email'],
            ];
    }

    /**
     * Отправка письма администратору
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        $this->ip = Yii::$app->request->userIP;
        return \Yii::$app->mailer->compose(['html' => 'feedback-html', 'text' => 'feedback-text'], ['data' => $this])
                    ->setFrom([\Yii::$app->params['botEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo(\Yii::$app->params['feedbackEmail'])
                    ->setSubject('Письмо администрации - ' . \Yii::$app->params['site']['shortTitle'])
                    ->send();
    }
}