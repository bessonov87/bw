<?php
/* @var $this yii\web\View */

use app\components\GlobalHelper;
use yii\helpers\Url;
?>

<div class="comment-box" id="comment-<?= $comment->id ?>">
    <div class="comment-header">
        <div class="comment-autor"><strong><a href="/user/<?= $comment->user->username ?>/"><?= $comment->user->username ?></a></strong> написал(а)</div>
        <div class="comment-reply"><a href="#addComment" data-reply-id="<?= $comment->id ?>" data-reply-user-id="<?= $comment->user->id ?>" data-reply-user-name="<?= $comment->user->username ?>" class="comm-reply-link">Ответить</a></div>
        <div class="clear"></div>
    </div>
    <div class="comment-foto"><img src="<?= GlobalHelper::avatarSrc($comment->user) ?>"></div>
    <div class="comment-body">
        <div class="comment-text"><?= $comment->text ?></div>
    </div>
    <div class="clear"></div>
    <div class="comment-info">
        <div class="comment-id">#<?= $comment->id ?> (<?= Url::to() ?>)</div>
        <div class="comment-date"><strong>Добавлен:</strong> <?= $comment->date ?></div>
        <div class="clear"></div>
    </div>
</div>

<? //var_dump($comment->user->profile) ?>