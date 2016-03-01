<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = "Аккаунты в социальных сетях, привязанные к пользователю ".Yii::$app->user->identity->username;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1>Аккаунты в социальных сетях</h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <div>На этой странице отображается список привязанных к аккаунту пользователя социальных сетей, а также
            предоставляется возможность привязать к своей учетной записи на сайте любое количество аккаунтов в
            социальных сетях. Привязав аккаунт социальной сети, вы сможете использовать его для быстрого входа на сайт
            (буквально в один клик) без ввода логина и пароля.</div>
            <hr>
            <h4>Привязанные аккаунты социальных сетей:</h4>
            <?php
            if(!$auths){
                echo "<div style='text-align: center'>К вашей учетной записи не привязан ни один аккаунт в социальных сетях.</div>";
            }
            foreach($auths as $auth){
                /** @var $auth common\models\ar\Auth */
                $source = $auth->source;
                $socId = $auth->source_id;
                $text = '<i class="icon-social icon-'.$source.'"></i> ID: '.$socId;
                echo Html::tag('span', $text, ['class' => 'auth-label auth-' . $source]);
            }
            ?>
            <hr>
            <div class="ext-auth-bind"><h4>Привязать аккаунты социальных сетей:</h4>
                <?= \app\components\widgets\AuthChoice::widget() ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>