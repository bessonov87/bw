<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */

use yii\helpers\Html;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= Html::encode($this->title) ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">

            <div class="user_profile">
                <div class="user_rating">

                </div>
                <h2 class="user_login"><?= $user->username ?></h2>
                <p class="user_name"><?= $user->profile->name ?></p>
            </div>

            <div class="user_about">
                <img src="<?= $user->avatar ?>">
                <h3>О себе</h3>
                <p class="user_info"><?= $user->profile->info ?></p>
            </div>

            <div class="user_personal">
                <h2>Личное:</h2>
            </div>

        </div>
        <div class="clear"></div>
    </div>
</div>
