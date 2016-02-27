<?php
/* @var $this yii\web\View */
/* @var $comment common\models\ar\Comment */

use common\components\helpers\GlobalHelper;
use yii\helpers\Html;

//if($_SERVER['REMOTE_ADDR'] == '37.26.135.215') var_dump($comment['text']);

?>

<div class="comment-box" id="comment-<?= $comment['id'] ?>">
    <div class="comment-header">
        <div class="comment-autor"><strong><a href="/user/<?= $comment['user']['username'] ?>/"><?= $comment['user']['username'] ?></a></strong> написал(а)</div>
        <div class="comment-reply"><a href="#addComment" data-reply-id="<?= $comment['id'] ?>" data-reply-user-id="<?= $comment['user']['id'] ?>" data-reply-user-name="<?= $comment['user']['username'] ?>" class="comm-reply-link">Ответить</a></div>
        <div class="clear"></div>
    </div>
    <div class="comment-foto"><img src="<?= GlobalHelper::avatarSrc($comment['user']) ?>"></div>
    <div class="comment-body">
        <div class="comment-text"><?= nl2br(Html::encode(GlobalHelper::br2nl($comment['text']))) ?></div>
    </div>
    <div class="clear"></div>
    <div class="comment-info">
        <div class="comment-id">#<?= $comment['id'] ?> (<a href="#comment-<?= $comment['id'] ?>" class="comment-link" title="Ссылка на комментарий">Ссылка</a>)</div>
        <div class="comment-date"><strong>Добавлен:</strong> <?= $comment['date'] ?></div>
        <div class="clear"></div>
    </div>
</div>