<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?
    /*if(Yii::$app->session->hasFlash('success')){
        echo Yii::$app->session->getFlash('success');
    }*/
?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'options' => ['class' => 'form-contact']
]); ?>
<?= $form->field($model, 'name')->label('Имя') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'subject')->textInput()->label('Тема сообщения') ?>
<?= $form->field($model, 'message')->textarea()->label('Текст сообщения') ?>
<?= Html::submitButton('Отправить', ['class'=>'btn btn-success'])?>
<?php ActiveForm::end() ?>
