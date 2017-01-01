<?php
/**
 * @var \yii\web\View $this
 * @var array $months
 */

use app\components\widgets\RatingWidget;
use app\components\widgets\FavoriteWidget;
use common\components\helpers\GlobalHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$year = date('Y');
if(date('m') == 12 && date('j') > 15){
    $year++;
}

$this->title = "Лунный календарь на $year год. Календарь лунных дней. Фазы луны";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "лунный календарь, $year, знаки Зодиака, влияние Луны, лунный, календарь, Луна, дни, год, новолуние, полнолуние, сутки, влияние, Зодиаки, месяц, положение"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Лунный календарь на $year год. Календарь лунных дней. Фазы луны"
]);

// Добавляем canonical
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/moon-calendar'])]);

$calendars = \common\components\AppData::$moonCalMonthLinks;

$options = [
    'title' => $this->title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '<p>
    <img style="float: left; border: 0px; padding-right: 8px;" title="лунный календарь" src="/uploads/posts/2014-04/moon_1404284021.jpg" alt="лунный календарь">Издавна известно, что Луна, являясь спутником Земли, оказывает существенное влияние не только на все, что нас окружает, но и на нас самих. Самый наглядный пример влияния Луны на природу – это приливы и отливы. Эти явления напрямую зависят от лунной гравитации. Люди также давно заметили на себе влияние этого небесного тела. На растущей Луне люди ощущают прилив энергии и большую уверенность в своих силах. Убывающая Луна, наоборот, приводит к упадку сил, пессимизму и депрессиям. Конечно, не все так однозначно, но надо учитывать такое положение вещей. Именно в этом может помочь календарь лунных дней.</p>
<p>&nbsp;</p>
<p>Считается, что <strong>лунный календарь</strong> – это самый первый вариант созданного человечеством календаря. Дело в том, что изменение фаз Луны нетрудно увидеть невооруженным глазом. На этой основе легко построить последовательность смены этих фаз. Выделяется 4 фазы Луны: новолуние, первая четверть, полнолуние и последняя четверть. Период от новолуния до новолуния называется синодическим (или лунным) месяцем. Его продолжительность в среднем составляет чуть больше 29 с половиной суток. Поэтому лунный месяц может состоять из 29 или 30 дней. Продолжительность года в лунном календаре составляет 12 синодических месяцев, что приблизительно равняется 354,37 дням. Таким образом, в лунном календаре может быть 354 (в простой год) или 355 (в високосный год) дней.</p>
<p>&nbsp;</p>
<p>Как нетрудно заметить, лунный год не совпадает с периодом обращения Земли вокруг Солнца. И когда в древности люди переходили к оседлому образу жизни, это разница стала для них критической, из-за того, что земледелие привязано к смене сезонов, определяемом движением Солнца. В результате Лунный календарь повсеместно начал уступать место солнечным или лунно-солнечным календарям.</p>
<p>Однако сам лунный календарь из-за этого не утратил своей актуальности. По сей день на его основе строят многие другие календари, такие как лунный календарь стрижек, календарь огородника и др. Мы хотим вам представить <strong>лунный календарь на '.$year.' год</strong>, в котором указаны фазы луны, лунный сутки, положение Луны в знаках Зодиака, благоприятные и неблагоприятные лунные дни. Таким образом, вы всегда будете в курсе того, как Луна может повлиять на ваш день, и что может ждать вас в тот или иной день лунного календаря.</p>
<p>&nbsp;</p>
<p></p><h2 align="center">Лунный календарь на '.$year.' год по месяцам</h2><br>
<table width="100%" class="moon_calendar_table">
    <tr>';
    for($x=1;$x<=12;$x++){
        $linkYear = date('j') > 15 && $x == 12 && date('m') == 12 ? $year-1 : $year;
        $linkText = 'Лунный календарь на '.GlobalHelper::rusMonth($x).' '.$linkYear.' года';
        if(isset($calendars[$linkYear][$x])){
            $link = Html::a($linkText, \common\components\AppData::$moonCalLinksBase . $calendars[$linkYear][$x]);
        } elseif(isset($months[$linkYear][$x])) {
            $link = Html::a($linkText, "/horoscope/lunnyj-kalendar-na-god/$linkYear/" . GlobalHelper::engMonth($x) . '/');
        } else {
            $link = $linkText;
        }
        $options['content'] .= "<td>$link</td>";
        if($x % 2 == 0 && $x != 12){
            $options['content'] .= '</tr><tr>';
        }
    }
$options['content'] .= '</tr>
</table>
<p>&nbsp;</p>
<p><br>
    <script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- beauty-in-adapt -->
    <ins class="adsbygoogle" style="display: block; height: 60px;" data-ad-client="ca-pub-6721896084353188" data-ad-slot="8510135144" data-ad-format="auto" data-adsbygoogle-status="done"><ins id="aswift_2_expand" style="display:inline-table;border:none;height:60px;margin:0;padding:0;position:relative;visibility:visible;width:678px;background-color:transparent"><ins id="aswift_2_anchor" style="display:block;border:none;height:60px;margin:0;padding:0;position:relative;visibility:visible;width:678px;background-color:transparent"><iframe width="678" height="60" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no" allowfullscreen="true" onload="var i=this.id,s=window.google_iframe_oncopy,H=s&amp;&amp;s.handlers,h=H&amp;&amp;H[i],w=this.contentWindow,d;try{d=w.document}catch(e){}if(h&amp;&amp;d&amp;&amp;(!d.body||!d.body.firstChild)){if(h.call){setTimeout(h,0)}else if(h.match){try{h=s.upd(h,i)}catch(e){}w.location.replace(h)}}" id="aswift_2" name="aswift_2" style="left:0;position:absolute;top:0;"></iframe></ins></ins></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <br></p>
<p>&nbsp;</p>
<p>Каждый лунный месяц имеет разную продолжительность, которая составляет от 29 дней 6 часов 15 минут до 29 дней 19 часов и 12 минут. Это связано с тем, что Луна имеет довольно сложное движение по своей орбите. Началом каждого лунного месяца является новолуние. Первые лунные сутки продолжаются от момента новолуния до первого восхода Луны для данной местности. Поэтому невозможно пользоваться одним и тем же календарем для разных широт. В нашем лунном календаре '.$year.' указано московское время. Его можно пересчитать для каждого часового пояса, однако на больших временных разницах могут наблюдаться некоторые расхождения. В течение синодического месяца Луна проходит через все 12 знаков Зодиака. Эти периоды также влияют на все области нашей жизни.</p>
<p>&nbsp;</p>
<p>Также предлагаем вам ознакомиться с <a title="Лунный календарь стрижек" href="/horoscope/lunnyj-kalendar-strizhek/">лунным календарем стрижек на '.$year.' год</a>. В нем вы найдете все благоприятные и неблагоприятные дни для похода в парикмахерскую. Если вы будете учитывать положение Луны, ваши волосы будут всегда красивыми и здоровыми.</p>';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);