<?php
/**
 * @var \yii\web\View $this
 */

use common\components\helpers\GlobalHelper;
use common\components\AppData;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => Html::a('Знаки Зодиака', '/znaki-zodiaka/'), 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => Html::a('Совместимость знаков Зодиака', '/znaki-zodiaka/sovmestimost/'), 'encode' => false];

$this->title = "Таблица совместимости знаков Зодиака";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "таблица совместимости, астрологические прогнозы, гороскоп совместимости, идеальная пара"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Узнай кто является идеальной парой."
]);

$options = [
    'title' => $this->title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

$options['content'] .= '<p>Астрология – наука, основанная на отношениях между созвездиями и людьми. Дисциплина была 
разработана древними народами, такими как майя. Правда ее научная сторона часто оспаривается учеными, потому что она 
включает в себя аффективные и эмоциональные элементы.</p><p>&nbsp;</p><p>Каждый человек рождается под конкретным 
астрологическим знаком, который влияет на его поведение, энергетику и соотношение с другими людьми. Из расположенной 
ниже таблицы вы узнаете, с какими астрологическими знаками вы наиболее совместимы.</p><p>&nbsp;</p>';

$options['content'] .= '<div><table id="tableone" class="table-sovm" cellspacing="0">
<thead>
<tr>
    <th colspan="2" rowspan="2"><img src="/bw15/images/horoscope/tablitsa/cupid.png" border="0" alt="" width="110"></th>
    <th colspan="12"><img src="/bw15/images/horoscope/tablitsa/man.jpg" border="0" alt=""></th>
</tr>
<tr>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/aries.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/taurus.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/gemini.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/cancer.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/leo.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/virgo.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/libra.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/scorpio.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/sagitarius.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/capricorn.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/aquarius.jpg" border="0" alt=""></th>
    <th style="vertical-align: bottom;"><img src="/bw15/images/horoscope/tablitsa/pisces.jpg" border="0" alt=""></th>
</tr>
</thead>
<tfoot>
<tr>
    <td colspan="2">&nbsp;</td>
    <td>♈</td><td>♉</td><td>♊</td><td>♋</td><td>♌</td><td>♍</td><td>♎</td><td>♏</td><td>♐</td><td>♑</td><td>♒</td><td>♓</td>
</tr>
</tfoot>
<tbody>';

        for ($i=1; $i<=12; $i++) {
            $znakRusWoman = GlobalHelper::rusZodiac($i);
            $znakRodWoman = GlobalHelper::rusZodiac($i, 'r');
            $engZnakTranslitWoman = AppData::$engZnakiTranslit[$i];
            $engZnakWoman = AppData::$engZnaki[$i];
            $options['content'] .= '<tr>';
            if ($i == 1) {
                $options['content'] .= '<td style="background-color: #ffbbdd;" rowspan="12" class="">
                    <img src="/bw15/images/horoscope/tablitsa/woman.jpg" border="0" alt="">
                </td>';
            }
            $options['content'] .= '<td style="background-color: #ffbbdd; padding: 1px 5px;" align="right" class="betterhover">
                    <div style="font-size: 16px;">
                        <img src="/bw15/images/horoscope/tablitsa/' . $engZnakWoman . '_w.jpg" border="0" alt="">
                    </div>
                </td>';
            for ($x = 1; $x <= 12; $x++) {
                $znakRusMan = GlobalHelper::rusZodiac($x);
                $znakRodMan = GlobalHelper::rusZodiac($x, 'r');
                $engZnakTranslitMan = AppData::$engZnakiTranslit[$x];
                $engZnakMan = AppData::$engZnaki[$x];
                $title = "Cовместимость $znakRodWoman-женщины и $znakRodMan-мужчины";
                $href = "/znaki-zodiaka/sovmestimost/$engZnakTranslitWoman-woman/$engZnakTranslitMan-man/";
                $alt = "$znakRusWoman-женщина и $znakRusMan-мужчина";
                $options['content'] .= '<td><a href="' . $href . '" title="' . $title . '"><img src="/bw15/images/horoscope/tablitsa/hearts2.png" border="0" alt="' . $alt . '"></a></td>';
            }
            $options['content'] .= '</tr>';
        }
$options['content'] .= '</tbody></table></div>';

$options['content'] .= '* - <em>Для определения совместимости двух знаков Зодиака, наведите курсор мышки на перекрестие 
строки, определяющей знак женщины и столбца, определяющего знак мужчины. Здесь будет ссылка. Кликайте на картинку с 
сердцами и вы перейдете на страницу с подробным описанием вашей совместимости.</em>';

$options['content'] .= '<p>&nbsp;</p><p>Несмотря на общие астрологические показатели совместимости, не нужно принимать близко к 
сердцу эти данные. Любовь сильнее любого астрологического прогноза. К тому совместимость зависит не только от 
созвездия, немаловажную роль в совместимости играет дата и место рождения партнеров. Эти обобщения могут иметь сходство 
с реальностью, но они не являются догмой.</p>
<p>&nbsp;</p><p>Существует 12 знаков зодиака, которые делятся на четыре группы:</p>
<p>&nbsp;</p>
<h3>Знаки Огня: Овен, Лев, Стрелец.</h3>
<p>О таком человеке можно сказать следующее: врожденный лидер, активный, импульсивный и уверенный в себе. Выделяется 
доминирующим и стремительным характером, а также может быть гордым и взволнованным.</p>
<p>&nbsp;</p>
<h3>Знаки Земли: Телец, Дева, Козерог.</h3>
<p>Характеризуются прагматичным и реалистичным отношением. Они, как правило, сохраняют то, что получают, и несут за это 
ответственность.</p>
<p>&nbsp;</p>
<h3>Воздушные знаки: Близнецы, Весы, Водолей.</h3>
<p>Эти знаки являются настоящими коммуникаторами, им хочется все обсуждать, но при этом они испытывают трудности, если 
нужно показать свои чувства.</p>
<p>&nbsp;</p>
<h3>Водные знаки: Рак, Скорпион, Рыбы.</h3>
<p>Чувствительные, эмоциональные и интуитивные. Они могут показаться застенчивым, но на заднем плане являются большими 
мечтателями.</p>
<p>&nbsp;</p>

';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);