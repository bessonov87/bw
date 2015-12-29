<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-pink"><?= Html::encode($this->title) ?></div>
    <div id="content-item-content">
        <div id="content-small-10">
            <div class="alert alert-danger" style="font-size: 16px;">
                <?= nl2br(Html::encode($message)) ?>
            </div>
        </div>
        <div class="clear"></div>
        <div id="content-item-footer">
            <p>
                Пожалуйста, свяжитесь с нами, если вы считаете, что ошибка произошла на стороне серевера. Спасибо.
            </p>
        </div>
    </div>
</div>
