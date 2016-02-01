<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Связь с администрацией';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= Html::encode($this->title) ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <?php
            if(!Yii::$app->session->hasFlash('success')):
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
            <?php
            endif;

            if(Yii::$app->session->hasFlash('success')){
                echo 'Спасибо за обращение';
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
