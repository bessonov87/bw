<?php
/* @var $this yii\web\View */

use app\components\widgets\ServerInfo;
use app\components\widgets\SiteSummary;
use app\components\widgets\YandexMetrika;
use app\components\widgets\LastComments;

$this->title = 'Dashboard - '.Yii::$app->params['site']['shortTitle'];
?>
<section class="content">
<div class="row">
    <?= SiteSummary::widget() ?>
</div>
<div class="row">
    <div class="col-md-12">
        <?= YandexMetrika::widget() ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= ServerInfo::widget() ?>
    </div>
    <div class="col-md-8">
        <?= LastComments::widget() ?>
    </div>
</div>
</section>
