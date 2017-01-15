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
if($period == 'znaki') {
    $znakiTitle = 'Все знаки Зодиака';
    $aTitleStart = 'Знак Зодиака';
} elseif($period == 'sovmest') {
    $znakiTitle = 'Остальные знаки Зодиака';
    $aTitleStart = 'Совместимость:';
} else {
    $znakiTitle = 'Гороскоп на '.$period.' для '.$otherText.' <a href="/horoscope/znaki-zodiaka/" title="Знаки Зодиака">знаков Зодиака</a>';
    $aTitleStart = 'Гороскоп на '.$period;
}

?>

<div class="goroskop_table">
    <div class="row goroskop_table_header">
        <div class="col-md-12">
            <div class="goroskop_znaki_title"><?=$znakiTitle?></div>
        </div>
    </div>
    <div class="row goroskop_znaki">
        <?php for ($i=1;$i<=12;$i++) {
            $rusZnak = GlobalHelper::rusZodiac($i);
            $aTitle = $aTitleStart.' '.$rusZnak;
            $url = $baseUrl . AppData::$engZnakiTranslit[$i].'/';
            if($period == 'sovmest'){
                $url .= 'sovmestimost/';
            }
            echo '<div class="col-md-2 goroskop_znak">
                      <a class="'.AppData::$engZnaki[$i].'" title="'.$aTitle.'" href="'.$url.'">
                          <strong>'.$rusZnak.'</strong><span>'.AppData::$znakiDates[$i].'</span>
                      </a>
                  </div>';
        } ?>
    </div>
</div>
