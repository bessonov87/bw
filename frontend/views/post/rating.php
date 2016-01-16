<?php

/* @var $this yii\web\View */

if(Yii::$app->user->isGuest){
    $disableButtons = 'disabled';
    $titlePlus = $titleMinus = 'Голосовать могут только зарегистрированные пользователи.';
} else {
    $disableButtons = '';
    $titlePlus = 'Статья понравилась. +1';
    $titleMinus = 'Статья не понравилась. -1';
}
?>

<div class="post_rating">
    <button type="button" <?=$disableButtons?> class="post_rating_button_plus" title="<?=$titlePlus?>">
        <span><i class="fa fa-thumbs-o-up"></i></span>
    </button>

    <div class="post_rating_score">
        <span class="post_rating_score_<?=$rating['scoreClass']?>" title="Всего голосов <?=$rating['votes']?>: ↑<?=$rating['numPlus']?> и ↓<?=$rating['numMinus']?>"><?=$rating['score']?></span>
    </div>

    <button type="button" <?=$disableButtons?> class="post_rating_button_minus" title="<?=$titleMinus?>">
        <span><i class="fa fa-thumbs-o-down"></i></span>
    </button>

    <div class="post_rating_info"><?=$message?></div>

</div>