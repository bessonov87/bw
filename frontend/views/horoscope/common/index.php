<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$this->title = "Онлайн гороскопы по знакам Зодиака. Астрология для всех";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп, жизни, человека, время, события, Прогнозы, вопросы, астрологов, предсказания"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Онлайн гороскопы по знакам Зодиака на год, месяц, неделю и на каждый день"
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/index', 'type' => 'common', 'period' => 'index'])]);

$options = [
    'title' => "Онлайн гороскопы по знакам Зодиака",
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$horoscopes = [
    ['img' => 'horoscopes/yearly-horoscope-all.png', 'title' => 'Гороскопы на год', 'url' => '/horoscope/na-god/'],
    ['img' => 'horoscopes/monthly-horoscope-all.png', 'title' => 'Гороскопы на месяц', 'url' => '/horoscope/na-mesjac/'],
    ['img' => 'horoscopes/weekly-horoscope-all.png', 'title' => 'Гороскопы на неделю', 'url' => '/horoscope/na-nedelju/'],
    ['img' => 'horoscopes/daily-horoscope-all.png', 'title' => 'Ежедневный гороскоп', 'url' => '/horoscope/na-segodnja/'],
    //['img' => 'horoscopes/daily-horoscope-all.png', 'title' => 'Восточный гороскоп', 'url' => '/horoscope/vostok/'],
    ['img' => 'sovmestimost.png', 'title' => 'Гороскоп совместимости', 'url' => '/znaki-zodiaka/sovmestimost/'],
    ['img' => 'sovmestimost.png', 'title' => 'Лунный календарь '.date('Y'), 'url' => '/horoscope/lunnyj-kalendar-na-god/'],
    ['img' => 'sovmestimost.png', 'title' => 'Лунный календарь стрижек '.date('Y'), 'url' => '/horoscope/lunnyj-kalendar-strizhek/'],
    ['img' => 'sovmestimost.png', 'title' => 'Луна в знаках Зодиака', 'url' => '/horoscope/luna-v-znakah/'],
    ['img' => 'sovmestimost.png', 'title' => 'Лунные дни', 'url' => '/horoscope/lunnye-dni/'],
    //['img' => '', 'title' => '', 'url' => Url::to([''])],
];

$options['content'] = '<img style="float: left; padding-bottom: 8px; padding-right: 8px;" src="/bw15/images/horoscope/horoscopes/all-horoscope.png" alt="Онлайн гороскопы для всех знаков Зодиака" width="180" />
<p><strong>Гороскоп</strong> представляет астрологическую карту положения планет во время интересующего события. Так гороскоп может быть рассчитан для какого-либо события, человека или даже для целой страны. Чтобы построить астрологическую карту для человека, нужно знать дату, время и место его рождения. Учитывая вариативность этих данных и то, что планеты находятся в непрерывном движении, гороскопы людей существенно отличаются.</p>
<p>&nbsp;</p>
<p>Сегодня слово гороскоп приняло немного другое значение. Этим понятием именуют астрологические прогнозы, которые составляются на основе астрологических карт. Но, несмотря на эту неопределенность, астрологические прогнозы во все времена были и остаются достаточно популярными, так как помогают нам хоть немного, но заглянуть в будущее. Здесь и далее на сайте Astrolis.Ru гороскопами мы будем именовать именно астрологические прогнозы, как это сейчас принято.</p>
<p>&nbsp;</p>';

$options['content'] .= '<div class="row horoscope-table">';
foreach ($horoscopes as $horoscope) {
    $options['content'] .= '<div class="col-md-3">
        <div class="cat-img"><a href="'.$horoscope['url'].'"><img src="/bw15/images/horoscope/'.$horoscope['img'].'" alt="'.$horoscope['title'].'"></a></div>
        <div class="cat-link"><a href="'.$horoscope['url'].'">'.$horoscope['title'].'</a></div>
    </div>';
}
$options['content'] .= '</div>';

$options['content'] .= '<p>&nbsp;</p>
<p>С незапамятных времен люди полагались на астрологические предсказания, которые призваны помочь им найти ответы как на самые серьезные, так и на более приземленные вопросы жизни. Прогнозы астрологов (или, как их сейчас принято называть, Гороскопы) помогают людям узнать о перспективах в любви, браке, личной жизни, карьере, финансах, вопросах недвижимости, образования и здравоохранения, а также в некоторых других аспектах их жизни.</p>
<p>&nbsp;</p>
<p>Существуют множество <strong>разновидностей гороскопов</strong>. Самыми известными из них являются натальный, нумерологический, китайский гороскоп и <a title="Гороскоп совместимости знаков Зодиака" href="/znaki-zodiaka/sovmestimost/">гороскоп совместимости</a>.</p>';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);