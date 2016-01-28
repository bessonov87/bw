<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-email', 'token' => $user->email_confirm_token]);
?>
Здравствуйте, <?= Html::encode($user->username) ?>,

Скопируйте ссылку и вставьте в адресную строку браузера, чтобы подтвердить свой email адрес и активировать учетную запись на нашем сайте:</p>

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?>

Или в своем профиле на нашем сайте введите код, представленный ниже:

<?= $user->email_confirm_token ?>