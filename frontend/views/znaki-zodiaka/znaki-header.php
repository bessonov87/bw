<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\ZnakiZodiaka $znakModel
 */

use common\components\AppData;
use common\components\helpers\GlobalHelper;

$engZnak = AppData::$engZnaki[$znakModel->znak_id];
$engZnakTranslit = AppData::$engZnakiTranslit[$znakModel->znak_id];
$znakCode = '&#98'.sprintf('%02d', $znakModel->znak_id-1).';';
$znakRus = GlobalHelper::rusZodiac($znakModel->znak_id);
$znakRod = GlobalHelper::rusZodiac($znakModel->znak_id, 'r');
$year = date('Y');
?>

<div class="row goroskop_vse">
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-6"><p><strong>Период:</strong> <?=AppData::$znakiDates[$znakModel->znak_id]?></p></div>
            <div class="col-md-6"><p><strong>Планета:</strong> <?=$znakModel->planet?></p></div>
        </div>
        <div class="row">
            <div class="col-md-6"><p><strong>Символ:</strong> <?=$znakCode?></p></div>
            <div class="col-md-6"><p><strong>Цвет:</strong> <?=$znakModel->color?></p></div>
        </div>
        <div class="row">
            <div class="col-md-6"><p><strong>Стихия:</strong> <?=$znakModel->element?></p></div>
            <div class="col-md-6"></div>
        </div>
        <div class="row">
            <div class="col-md-12"><p><strong>Камень:</strong> <?=$znakModel->stone?></p></div>
        </div>
        <div class="row">
            <div class="col-md-12"><p><strong>Противоположность:</strong> <?=$znakModel->opposite?></p></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sign-image" style="float: left;">
            <img title="Знак Зодиака <?=$znakRus?>" width="180" src="/bw15/images/horoscope/signs/<?=$engZnak?>.png" alt="Знак Зодиака <?=$znakRus?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="art-cats" style="float: right; width: 265px; padding-left: 10px;">
            <ul>
                <li><a title="Характер <?=$znakRod?>" href="/znaki-zodiaka/<?=$engZnakTranslit?>/">Характер <?=$znakRod?></a></li>
                <li><a title="Мужчина-<?=$znakRus?>" href="/znaki-zodiaka/<?=$engZnakTranslit?>/man/"><?=$znakRus?>-мужчина</a></li>
                <li><a title="Женщина-<?=$znakRus?>" href="/znaki-zodiaka/<?=$engZnakTranslit?>/woman/"><?=$znakRus?>-женщина</a></li>
                <li><a title="Женщина-<?=$znakRus?>" href="/znaki-zodiaka/<?=$engZnakTranslit?>/child/"><?=$znakRus?>-ребенок</a></li>
                <li><a title="Совместимость <?=$znakRod?>" href="/znaki-zodiaka/<?=$engZnakTranslit?>/sovmestimost/">Совместимость <?=$znakRod?></a></li>
                <li><a href="/znaki-zodiaka/<?=$engZnakTranslit?>/career/">Деньги и карьера <?=$znakRod?></a></li>
                <li><a href="/znaki-zodiaka/<?=$engZnakTranslit?>/sex/">Сексуальность <?=$znakRod?></a></li>
                <li><a href="/znaki-zodiaka/<?=$engZnakTranslit?>/health/">Здоровье <?=$znakRod?></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
    <div class="col-md-12"><strong>Гороскопы:</strong> <a title="Гороскоп на <?=$year?> год <?=$znakRus?>" href="/horoscope/na-god/<?=$year?>/<?=$engZnakTranslit?>/">Гороскоп <?=$znakRod?> на <?=$year?> год</a>, <a title="Гороскоп на сегодня <?=$znakRus?>" href="/horoscope/na-segodnja/<?=$engZnakTranslit?>/">Гороскоп <?=$znakRod?> на сегодня</a></div>
</div>