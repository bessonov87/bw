<?php
/* @var $this yii\web\View */

if(Yii::$app->user->isGuest){
    $disableButton = 'disabled';
    $titleButton = 'Добавлять статьи в избранное могут только зарегистрированные пользователи';
} else {
    $disableButton = '';
    $titleButton = 'Добавить статью в избранное';
}
?>

<div class="post_favorite">
    <div class="post_favorite_info"><?= $message ?></div>
    <div class="post_favorite_star">
        <button type="button" <?=$disableButton?> class="post_favorite_button <?= $options['button_class'] ?>" title="<?= $titleButton ?>">
            <span></span>
        </button>
    </div>
    <div class="post_favorite_count">
        <?= $options['favorites_num'] ?>
    </div>
</div>
