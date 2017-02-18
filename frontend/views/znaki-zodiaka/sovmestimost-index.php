<?php
/**
 * @var \yii\web\View $this
 * @var string $znak
 * @var string $type
 * @var string $text
 */

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;
use common\models\ar\ZnakiZodiaka;
use app\components\widgets\ZnakZodiakaHeaderWidget;
use common\components\AppData;

$this->params['breadcrumbs'][] = ['label' => Html::a('Знаки Зодиака', '/znaki-zodiaka/'), 'encode' => false];

$title = 'Совместимость знаков Зодиака. Совместимость мужчин и женщин Овна, Тельца, Близнецов, Рака, Льва, Девы, Весов, Скорпиона, Стрельца, Козерога, Водолея, Рыбы.';

$this->title = $title.' Совместимость онлайн бесплатно';
$this->params['breadcrumbs'][] = $title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "совместимость знаков Зодиака, совместимость мужчин и женщин всех знаков Зодиака, совместимость онлайн бесплатно"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Совместимость знаков Зодиака онлайн бесплатно. Совместимость мужчин и женщин Овна, Тельца, Близнецов, Рака, Льва, Девы, Весов, Скорпиона, Стрельца, Козерога, Водолея, Рыбы."
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

$texts = [
    1 => 'Овен – первый знак зодиака. Люди, родившиеся под этим знаком, являются прирожденными лидерами. Они готовы во всем брать на себя инициативу. Овны никогда не идут на полумеры.',
    2 => 'Телец – человек сильный и молчаливый. В первую очередь, Телец производит впечатление чрезвычайно тихого и сдержанного человека. Люди этого знака не импульсивные и никогда не злятся без причины.',
    3 => 'Близнецы – третий знак зодиака. Люди, рожденные под этим знаком, очень любят говорить. Однако это не просто пустая болтовня. Движущей силой общения для близнецов является их интеллект.',
    4 => 'Во время разговора по лицу Рака можно с легкостью увидеть, как у него меняется настроение. Вообще склонность к частым перепадам настроения – одна из основных черт характера Рака.',
    5 => 'Львы стремятся всегда быть в центре внимания, на первых ролях. Поэтому для них жизненно необходимо общество других людей. Львы очень любят себя и яростно защищают то, что они считают своим.',
    6 => 'Типичные чертой характера Девы является перфекционизм. Для них все вокруг должно быть просто идеально, в том числе и внешность, в которой все должно быть прекрасно, от одежды до парфюмерии.',
    7 => 'Весы – седьмой знак зодиака. Главной чертой характера Весов является вежливость. Они любят людей, поэтому не приемлют грубость как со своей стороны, так и со стороны окружающих.',
    8 => 'Скорпион является одним из трех водных знаков зодиака. Первое, что можно заметить в людях этого знака, – это их глаза. Перед интенсивным магическим взглядом Скорпиона очень трудно устоять.',
    9 => 'Стрельцы очень остроумные люди и представляют собой интересный сплав юмора и интеллекта. Люди этого знака достаточно активны, и им трудно долго усидеть на одном месте.',
    10 => 'Козероги по жизни движутся медленно, но при этом везде успевают. Это связано с тем, что эти люди не стараются идти напролом, а хорошо обдумывают многие свои действия.',
    11 => 'Водолеи добрые и миролюбивые люди. Их интересует все новое и неизведанное, будь то новая книга в магазине, новый коллега на работе или новый официант в привычном кафе.',
    12 => 'В людях этого знака проявляется одна из двух основных черт характера. Они могут либо плыть по течению, либо против него. Третьего не дано.',
];

$options['content'] = '';

$options['content'] .= '<p>Тема совместимости знаков зодиака весьма популярна в наше время. Зная особенности того или 
иного зодиакального символа, намного легче выстроить отношения с любимым человеком или просто найти общий язык с 
друзьями и коллегами. Выбрать правильный подход к партнеру – уже половина успеха. Но игнорирование этих знаний может 
убить любые отношения еще в их начале.</p><p>&nbsp;</p>
<p><img style="display: block; margin: 0 auto;" width="400" src="/bw15/images/horoscope/sovmest.jpg" alt="Гороскоп совместимости знаков Зодиака" align="none"></p>
<p>&nbsp;</p><p>Абсолютно не совместимых пар по знакам зодиака нет. Счастье в любви и в браке зависит еще от многих 
факторов – генетическая предрасположенность, воспитание, работа над собой и жизненный опыт. Но влияние звезд и планет 
так или иначе сказывается на судьбе человека. Качества, данные ему от природы, могут бурно проявляться или же дремать 
в глубине души. Их развитие зависит от конкретных обстоятельств и окружающей среды.</p>
<p>&nbsp;</p><p>Классической считается теория совместимости знаков по стихиям. Огонь покровительствует воинственным 
Овнам, властным Львам и целеустремленным Стрельцам. Стихия воздуха родная для веселых Близнецов, рассудительных Весов 
и интеллектуалов-Водолеев. Водная стихия покровительствует таинственному Раку, страстному Скорпиону и мечтателям-Рыбам. 
И, наконец, на твердой земле прекрасно себя чувствуют уверенный Телец, целомудренная Дева и загадочный Козерог.</p>
<p>&nbsp;</p>
<p>Знаки огня хорошо совместимы со знаками родной стихии, а также со знаками воздуха. А вот водные знаки неплохо ладят 
с представителями знаков земли и, конечно же, воды. Но и здесь есть свои нюансы. Несмотря на сходство темперамента и 
мировоззрения, людям одного знака будет непросто жить под общей крышей. Например, у пары Овен-Овен будут возникать 
постоянные конфликты на почве ревности. Гордая Львица будет конкурировать с успешным и самолюбивым мужем-Львом. Два 
Водолея могут витать в облаках и не замечать друг друга. Отношения Рака и Рачихи наверняка испортит взаимная 
подозрительность и замкнутость, ну а легкомысленные Близнецы вообще разбегутся в разные стороны.</p>
<p>&nbsp;</p>
<p>Отношения делает гармоничными взаимопонимание и дополнение друг друга. Залогом удачного брака являются глубокие 
чувства и желание идти на компромисс. Поэтому прямой закономерность между влиянием планет и отношениями нет. Но 
напомним, что подопечным огненной стихии близкими по духу придутся Овен, Лев, Стрелец (огонь), и Близнецы, Весы и 
Водолей (воздух). Знаки водной стихии скорее найдут общий язык с Раком, Скорпионом и Рыбами (вода), и Тельцом, Девой, 
Козерогом (земля).</p><p>&nbsp;</p>
<p>Только <strong>НИКОГДА</strong> не принимайте решение о разрыве отношений на основании исключетельно плохой 
астрологической совместимости.</p><p>&nbsp;</p>
<p>Чтобы узнать свою совместимость с 
другими знаками Зодиака выбирайте в таблице ниже свой знак и пол. На открывшейся страницы вы найдете ссылки на статьи, из 
которых сможете узнать, с представителями какого из знаков вы наиболее совместимы. Также предлагаем вам еще один способ 
проверки, кто вам подходит. На странице <a href="/znaki-zodiaka/sovmestimost/tablitsa/">Таблица совместимости знаков 
Зодиака</a> представлена удобная таблица определения, какие знаки совместимы в любви, а какие нет.</p><p>&nbsp;</p>
<table class="znaki-zodiaka-table" cellspacing="0" width="100%">
<tbody>';

for ($i=1;$i<=12;$i++) {
    $znakRus = GlobalHelper::rusZodiac($i);
    $znakRod = GlobalHelper::rusZodiac($i, 'r');
    $engZnak = AppData::$engZnaki[$i];
    $engZnakTranslit = AppData::$engZnakiTranslit[$i];
    $options['content'] .= '<tr>
    <td width="130"><img src="/bw15/images/horoscope/signs/'.$engZnak.'.png" alt="" width="120"></td>
    <td>
    <div style="font-size: 16px; font-weight: bold; padding-bottom: 5px;">Гороскоп совместимости '.$znakRod.'</div>
    <div class="clear"></div>
    <div style="font-size: 14px;">'.$texts[$i].'</div>
    <div style="float: left; padding-right: 40px;">
        <a style="font-size: 14px; color: #cc0099;" 
           title="Гороскоп совместимости '.$znakRod.'-женщины" 
           href="/znaki-zodiaka/sovmestimost/'.$engZnakTranslit.'-woman/">'.$znakRus.'-женщина + ...</a>
    </div>
    <div>
        <a style="font-size: 14px; color: #cc0099;" 
           title="Гороскоп совместимости '.$znakRod.'-мужчины" 
           href="/znaki-zodiaka/sovmestimost/'.$engZnakTranslit.'-man/">'.$znakRus.'-мужчина + ...</a>
    </div>
    </td>
    </tr>';
}

$options['content'] .= '</tbody>
</table></div>';

$options['content'] .= '';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);