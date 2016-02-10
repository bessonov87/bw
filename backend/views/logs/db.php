<?php
/* @var $this yii\web\View */
/* @var $message backend\models\Log */

$this->title = 'Лог из базы данных';

foreach($messages as $message):
?>
<div class="message">
    <div class="message_header">
        <div class="message_time"><?= date('d.m.Y H:i:s', round($message->log_time)) ?></div>
        <div class="message_title"><?= $message->category ?></div>
    </div>
    <div class="message_subheader">
        <div class="message_page"><?= $message->page ?></div>
        <div class="message_prefix"><?= $message->prefix ?></div>
    </div>
    <div class="message_text"><?= nl2br($message->message) ?></div>
</div>
<?php
endforeach;
?>