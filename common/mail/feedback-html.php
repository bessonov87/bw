<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<p>Это письмо отправил(а) <strong><?= Html::encode($data->name) ?></strong></p>
<p>==================================================</p>
<p><?= Html::encode($data->message) ?></p>
<p>==================================================</p>
<p>IP адрес отправителя: <?= $data->ip ?></p>
<p>Email адрес отправителя: <?= $data->email ?></p>