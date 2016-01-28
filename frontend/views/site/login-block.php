<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;

?>
<div class="login_block">
    <?php
    if(Yii::$app->user->isGuest):
    ?>

        <a href="#inline_login" class="fancybox" title="Авторизация">
            <span class="login_lock"><i class="fa fa-lock fa-4x"></i></span>
        </a>
        <br />Для входа нажмите на замок<br />
        <a href="/site/signup" title="Регистрация">Регистрация</a><br />
        <a href="/site/request-password-reset" title="Восстановление пароля">Забыли пароль?</a>

        <div style="display:none"><div id="inline_login" align="center">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => '/site/login']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div></div>

    <?php
    endif;
    ?>

    <?php
    if(!Yii::$app->user->isGuest):
        $user = Yii::$app->user->identity;
        echo Html::tag('div', 'Привет, '.$user->username.'!');
        if($user->status == User::STATUS_NOT_ACTIVE){
            echo Html::a('Активировать', ['site/confirm-email']);
        }

    endif;
    ?>
</div>
