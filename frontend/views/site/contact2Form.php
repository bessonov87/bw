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
            <?php
                if(Yii::$app->user->isGuest) {
                    echo $form->field($model, 'name')->label('Имя');
                } else {
                    echo $form->field($model, 'name')->hiddenInput(['value' => Yii::$app->user->identity->username])->label(false);
                }
            ?>
            <?php
                if(Yii::$app->user->isGuest) {
                    echo $form->field($model, 'email');
                } else {
                    echo $form->field($model, 'email')->hiddenInput(['value' => Yii::$app->user->identity->email])->label(false);
                }
            ?>
            <?= $form->field($model, 'subject')->textInput()->label('Тема сообщения') ?>
            <?= $form->field($model, 'message')->textarea(['rows' => 10])->label('Текст сообщения') ?>
            <?= Html::submitButton('Отправить', ['class'=>'btn btn-success'])?>
            <?php ActiveForm::end() ?>
            <?php
            endif;

            if(Yii::$app->session->hasFlash('success')){
                echo 'Спасибо за обращение. В ближайшее время мы ознакомимся с вашим письмом и, если это требуется, дадим на него ответ.';
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
