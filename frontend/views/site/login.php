<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= Html::encode($this->title) ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <p>Войдите на сайт, чтобы получить возможность добавлять комментарии, выставлять оценки и выполнять другие действия, доступные только авторизованным посетителям.</p>
            <p>Для входа вы можете использовать как классическую схему с использованием логина и пароля, так и популярные социальные сети, если вы там зарегистрированы.</p>

            <div class="login-form">
                <h4>С использованием логина/пароля:</h4>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                Если вы забыли пароль, вы можете <?= Html::a('его восстановить', ['site/request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button-2']) ?>
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
