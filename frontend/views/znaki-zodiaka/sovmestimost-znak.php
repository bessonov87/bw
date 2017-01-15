<?php
/**
 * @var \yii\web\View $this
 * @var string $znak
 * @var string $znakMan
 * @var string $znakWoman
 * @var ZnakiZodiaka $znakModel
 */

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;
use common\components\AppData;
use common\models\ar\ZnakiZodiaka;
use app\components\widgets\ZnakZodiakaHeaderWidget;

$this->params['breadcrumbs'][] = ['label' => Html::a('Знаки Зодиака', '/znaki-zodiaka/'), 'encode' => false];

$zodiak = '';
$oneZnak = false;
if($znakMan){
    $znak = $znakMan;
    $zodiak = GlobalHelper::engZodiak($znakMan, true);
    $title = 'Совместимость '.GlobalHelper::rusZodiac($zodiak, 'r').'-мужчины со всеми знаками Зодиака';
    $engZnak = AppData::$engZnaki[$zodiak];
    $text = '<img style="float: left; padding-right: 8px;" src="/bw15/images/horoscope/signs/'.$engZnak.'.png" alt="Совместимость Овна-женщины со всеми знаками Зодиака" width="130" height="130">';
    $text .= AppData::$sovmestimost[$znak]['man'];
    $text .= '<table class="znaki-zodiaka-table" cellspacing="0" width="100%">';
    for($i=1;$i<=12;$i++){
        $engZnakTranslitWoman = AppData::$engZnakiTranslit[$i];
        $manCode = '&#98'.sprintf('%02d', $zodiak-1);
        $womanCode = '&#98'.sprintf('%02d', $i-1);
        $text .= '<tr>
        <td>
        <div style="float: left;">
            <a class="sovm-link" href="/znaki-zodiaka/sovmestimost/'.$engZnakTranslitWoman.'-woman/'.$znak.'-man/">
                '.GlobalHelper::rusZodiac($zodiak).'-мужчина + '.GlobalHelper::rusZodiac($i).'-женщина
            </a>
        </div>
        <div class="sovm-znaki">'.$manCode.' + '.$womanCode.'</div>
        <div class="clear"></div>
        <div class="sovm-text">'.AppData::$sovmestimostZnakov[$i][$zodiak].'</div>
        <div class="sovm-next-link">
            <a title="Совместимость '.GlobalHelper::rusZodiac($i, 'r').'-женщины и '.GlobalHelper::rusZodiac($zodiak, 'r').'-мужчины" 
               href="/znaki-zodiaka/sovmestimost/'.$engZnakTranslitWoman.'-woman/'.$znak.'-man/">Далее &gt;&gt;&gt;</a>
        </div>
        </td>
        </tr>';
    }
    $text .= '</table>';
} elseif($znakWoman){
    $znak = $znakWoman;
    $zodiak = GlobalHelper::engZodiak($znakWoman, true);
    $title = 'Совместимость '.GlobalHelper::rusZodiac($zodiak, 'r').'-женщины со всеми знаками Зодиака';
    $engZnak = AppData::$engZnaki[$zodiak];
    $text = '<img style="float: left; padding-right: 8px;" src="/bw15/images/horoscope/signs/'.$engZnak.'.png" alt="Совместимость Овна-женщины со всеми знаками Зодиака" width="130" height="130">';
    $text .= AppData::$sovmestimost[$znak]['woman'];
    $text .= '<table class="znaki-zodiaka-table" cellspacing="0" width="100%">';
    for($i=1;$i<=12;$i++){
        $engZnakTranslitMan = AppData::$engZnakiTranslit[$i];
        $manCode = '&#98'.sprintf('%02d', $i-1);
        $womanCode = '&#98'.sprintf('%02d', $zodiak-1);
        $text .= '<tr>
        <td>
        <div style="float: left;">
            <a class="sovm-link" href="/znaki-zodiaka/sovmestimost/'.$znak.'-woman/'.$engZnakTranslitMan.'-man/">
                '.GlobalHelper::rusZodiac($zodiak).'-женщина + '.GlobalHelper::rusZodiac($i).'-мужчина
            </a>
        </div>
        <div class="sovm-znaki">'.$womanCode.' + '.$manCode.'</div>
        <div class="clear"></div>
        <div class="sovm-text">'.AppData::$sovmestimostZnakov[$zodiak][$i].'</div>
        <div class="sovm-next-link">
            <a title="Совместимость '.GlobalHelper::rusZodiac($zodiak, 'r').'-женщины и '.GlobalHelper::rusZodiac($i, 'r').'-мужчины" 
               href="/znaki-zodiaka/sovmestimost/'.$znak.'-woman/'.$engZnakTranslitMan.'-man/">Далее &gt;&gt;&gt;</a>
        </div>
        </td>
        </tr>';
    }
    $text .= '</table>';
} elseif($znak) {
    $oneZnak = true;
    $zodiak = GlobalHelper::engZodiak($znak, true);
    $engZnak = AppData::$engZnaki[$zodiak];
    $title = 'Совместимость '.GlobalHelper::rusZodiac($zodiak, 'r').' со всеми знаками Зодиака';
    $text1 = '<h3>'.GlobalHelper::rusZodiac($zodiak).'-мужчина</h3>';
    $text1 .= AppData::$sovmestimost[$znak]['man'];
    $text1 .= '<div class="zodiak-sovmestimost-link">
    <a href="/znaki-zodiaka/sovmestimost/'.$znak.'-man/">Совместимость мужчины-'.GlobalHelper::rusZodiac($zodiak, 'r').' со всеми знаками Зодиака</a></div>';
    $text2 = '<br><hr><h3>'.GlobalHelper::rusZodiac($zodiak).'-женщина</h3>';
    $text2 .= AppData::$sovmestimost[$znak]['woman'];
    $text2 .= '<div class="zodiak-sovmestimost-link">
    <a href="/znaki-zodiaka/sovmestimost/'.$znak.'-woman/">Совместимость женщины-'.GlobalHelper::rusZodiac($zodiak, 'r').' со всеми знаками Зодиака</a></div><br><hr>';
    $text = $text1 . $text2;
} else {
    throw new \yii\web\NotFoundHttpException('Страница не найдена.');
}

$znakRus = GlobalHelper::rusZodiac($zodiak);
$znakRod = GlobalHelper::rusZodiac($zodiak, 'r');
$engZnak = AppData::$engZnaki[$zodiak];

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Астрология и гороскопы"
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/index', 'type' => 'common', 'period' => 'index'])]);

$options = [
    'title' => $title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

if($oneZnak){
    $options['content'] .= ZnakZodiakaHeaderWidget::widget(['znakModel' => $znakModel]);
}

$options['content'] .= '<div class="goroskop_text">';
$options['content'] .= $text.'</div>';

$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/znaki-zodiaka/',
    'znak' => $znak,
    'period' => 'sovmest'
]);

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);
