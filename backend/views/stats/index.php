<?php

use app\components\widgets\YandexMetrika;
use backend\components\widgets\metrika\Browsers;

/** @var $this yii\web\View */

$this->title = 'Статистика сайта на основе данных сервиса Яндекс.Метрика';
?>
<div class="row">
    <div class="col-md-12">
        <?= YandexMetrika::widget() ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= Browsers::widget() ?>
    </div>
    <div class="col-md-8">

    </div>
</div>