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
        <div class="row message_header">
            <div class="col-md-3 message_time"><?= date('d.m.Y H:i:s', round($message->log_time)) ?></div>
            <div class="col-md-4 message_title"><?= $message->category ?></div>
            <div class="col-md-5 message_prefix"><?= $message->prefix ?></div>
        </div>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse-<?=$message->id?>"><i class="fa fa-plus-square-o" aria-hidden="true"></i> <?= $message->page ?></a>
                    </h4>
                </div>
                <div id="collapse-<?=$message->id?>" class="panel-collapse collapse">
                    <div class="panel-body"><?= nl2br($message->message) ?></div>
                </div>
            </div>
        </div>
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