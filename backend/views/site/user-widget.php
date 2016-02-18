<?php
/* @var $this yii\web\View */
/* @var $user common\models\ar\User */
?>

<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <img src="<?=Yii::$app->params['frontendBaseUrl'].substr($user->avatar, 1)?>" class="img-circle" alt="<?=$user->username?>"/>
    </div>
    <div class="pull-left info">
        <p><?= Yii::$app->user->identity->username ?></p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>
