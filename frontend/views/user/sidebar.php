<?php
/* @var $this yii\web\View */
/* @var $user common\models\ar\User */

use common\components\helpers\GlobalHelper;
?>

<div class="user_avatar">
    <img src="<?= $user->avatar; ?>" width="150">
</div>
<div class="user_registered"><strong>Регистрация:</strong> <?= GlobalHelper::dateFormat($user->created_at) ?></div>
<div class="user_lastvisit"><strong>Последний визит:</strong> <?= GlobalHelper::dateFormat( ($lv = $user->profile->last_visit) ? $lv : $user->last_login_at ) ?></div>