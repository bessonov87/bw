<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= Html::encode($this->title) ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <p>Пожалуйста, введите email, который вы использовали при регистрации на сайте. На него будет отправлено письмо со ссылкой на страницу установки нового пароля.</p>
            <p>Старый пароль восстановить невозможно, так как все пароли хранятся в зашифрованном виде.</p>

            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email') ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>