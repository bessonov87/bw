<?php
/**
 * @var \yii\web\View $this
 * @var string $baseUrl
 * @var int $znak
 * @var string $period
 */

use common\components\helpers\GlobalHelper;
use common\components\AppData;

$otherText = $znak ? 'других' : 'всех';

?>

<div class="goroskop_table">
    <div class="row goroskop_table_header">
        <div class="col-md-12">
            <div class="goroskop_znaki_title">Гороскоп на <?=$period?> для <?=$otherText?> <a href="/horoscope/znaki-zodiaka/" title="Знаки Зодиака">знаков Зодиака</a></div>
        </div>
    </div>
    <div class="row goroskop_znaki">
        <?php for ($i=1;$i<=12;$i++) {
            $rusZnak = GlobalHelper::rusZodiac($i);
            $url = $baseUrl . AppData::$engZnakiTranslit[$i].'/';
            echo '<div class="col-md-2 goroskop_znak">
                        <a class="'.AppData::$engZnaki[$i].'" title="Гороскоп на '.$period.' '.$rusZnak.'" href="'.$url.'"><strong>'.$rusZnak.'</strong><span>'.AppData::$znakiDates[$i].'</span></a>
                    </div>';
        } ?>
    </div>
</div>
