<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\form\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= Html::encode($this->title) ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <p>Зарегистрированные пользователи получают возможность добавлять комментарии, выставлять оценки и выполнять другие действия, доступные только авторизованным посетителям.</p>
            <p>Для регистрации вы можете использовать как классическую схему с использованием логина и пароля, так и популярные социальные сети, если вы там зарегистрированы.
                Для успешной регистрации с помощью социальных сетей, вам необходимо разрешить доступ к просмотру своего электронного адреса (email).</p>

            <div class="signup-form">
                <h4>С использованием логина/пароля:</h4>
                <p>Пожалуйста заполните все поля формы:</p>

                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username', ['enableAjaxValidation' => true]) ?>

                <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'passwordRepeat')->passwordInput() ?>

                <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::classname(), [
                    // configure additional widget properties here
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <div class="ext-auth"><h4>Через социальные сети:</h4>
                <?= \app\components\widgets\AuthChoice::widget() ?>
            </div>

        </div>
        <div class="clear"></div>
    </div>
</div>
