<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<p>Это письмо отправил(а) <strong><?= Html::encode($name) ?></strong></p>
<p>==================================================</p>
<p><?= Html::encode($text) ?></p>
<p>==================================================</p>
<p>IP адрес отправителя: <?= $ip ?></p>