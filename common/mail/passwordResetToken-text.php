<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\ar\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Здравствуйте, <?= Html::encode($user->username) ?>,

Скопируйте ссылку и вставьте в адресную строку браузера. На открывшейся странице вы сможете восстановить пароль к своей учетной записи:

<?= $resetLink ?>
