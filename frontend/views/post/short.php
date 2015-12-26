<?php
use yii\jui\DatePicker;

$this->title = $title;
if($page > 1) $this->title .= '. Страница '.$page;
?>
<h2><?= $title ?></h2>

<?
echo DatePicker::widget([
    'language' => 'ru',
    'name' => 'country',
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
    ]
]);
?>