<?php
/* @var $this yii\web\View */
/* @var $message backend\models\Log */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Лог из базы данных';

?>
<div class="log_interval">
    <div class="interval_day"><?=Html::a('За сегодня', ['logs/db', 'interval' => 'today'])?></div>
    <div class="interval_hour"><?=Html::a('За последний час', ['logs/db', 'interval' => 'hour'])?></div>
</div>
<?php
if(is_array($messages)):
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
    echo LinkPager::widget(['pagination' => $pages]);
endif;
if(!$messages):
?>
    <div class="message">
        Нет записей
    </div>
<?php
endif;
?>