<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>
Это письмо отправил(а) <?= Html::encode($data->name) ?>
==================================================

<?= Html::encode($data->message) ?>

==================================================
IP адрес отправителя: <?= $data->ip ?>
Email адрес отправителя: <?= $data->email ?>