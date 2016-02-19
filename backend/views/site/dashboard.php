<?php
/* @var $this yii\web\View */

use app\components\widgets\ServerInfo;
use app\components\widgets\SiteSummary;
use app\components\widgets\YandexMetrika;

$this->title = 'Dashboard - '.Yii::$app->params['site']['shortTitle'];
?>
&nbsp;

<?= SiteSummary::widget() ?>

<?= ServerInfo::widget() ?>

<?= YandexMetrika::widget() ?>