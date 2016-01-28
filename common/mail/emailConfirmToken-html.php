<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_confirm_token]);
?>
<div class="email-confirm">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>,</p>

    <p>Перейдите по ссылке ниже, чтобы подтвердить свой email адрес и активировать учетную запись на нашем сайте:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>

    <p>Если вы не можете перейти по данной ссылке, введите в профиле код, представленный ниже.</p>

    <p><?= $user->email_confirm_token ?></p>
</div>