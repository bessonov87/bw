<?php
/* @var $this yii\web\View */
/* @var $user common\models\ar\User */

use yii\helpers\Html;

$this->title = "Профиль пользователя ".$user->username.". ".Yii::$app->params['site']['shortTitle'];
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1>Профиль пользователя</h1></a></div>
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
                <p class="user_sex"><div>Пол:</div><span><?= ($user->profile->sex == "m") ? "мужской" : "женский" ?></span></p>
                <p class="user_birth"><div>Дата рождения:</div><span><?= ($user->profile->birth_date) ? $user->profile->birth_date : "не указана" ?></span></p>
                <p class="user_location"><div>Страна/город:</div><span><?= $user->location ?></span></p>
            </div>

            <div class="user_friends">
                <h3>Друзья:</h3>
                <div>У пользователя пока нет друзей</div>
            </div>

            <div class="user_activity">
                <h2>Активность:</h2>
                <h3>Комментарии:</h3>
                <div>У пользователя пока нет комментариев</div>
            </div>

        </div>
        <div class="clear"></div>
    </div>
</div>
