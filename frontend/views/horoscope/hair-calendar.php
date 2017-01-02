<?php
/**
 * @var \yii\web\View $this
 * @var array $months
 */

use common\components\helpers\GlobalHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$year = date('Y');
if(date('m') == 12 && date('j') > 15){
    $year++;
}

$this->title = "Лунный календарь стрижек на $year год. Гороскоп стрижки волос $year. Благоприятные дни";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "лунный календарь, стрижке по луне, календарь стрижек"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Луна оказывает огромное влияние на волосы. Узнай в какие дни можно стричься в этом году. Календарь стрижек расписан на каждый месяц $year года"
]);

// Добавляем canonical
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/hair-calendar'])]);

$options = [
    'title' => "Лунный календарь стрижек на $year год. Гороскоп стрижки волос $year",
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$topH2 = '<h2>Лунный календарь стрижек на ' . $year . ' год. Благоприятные дни для стрижки волос в ' . $year . ' году</h2>';
$todayBox = $this->render('_today_box');

$options['content'] = '<p>
<img style="float: left; margin-right: 8px;" title="Лунный календарь стрижки волос. Лунный календарь стрижек" src="/uploads/posts/2010-01/1263630286_moon_kalen.jpg" alt="Лунный календарь стрижки волос. Лунный календарь стрижек" />
</p>
<p>Астрологи утверждают, что Луна оказывает влияние на все живое. В частности говорят, что фазы луны воздействуют на циркуляцию жидкостей. Именно поэтому в старину при убывающей Луне сажали растения, ценность которых сосредоточена под землей (корнеплоды, клубни). При растущей Луне сеяли и сажали все растения, ценность которых сосредоточена над землей.<br /><br />Также существует мнение, что фазы Луны оказывают влияние на рост волос. Если постричься во время растущей Луны, волосы будут расти намного быстрее, чем после стрижки при убывающей Луне.</p>
'.$topH2.'
'.\app\components\widgets\AdvertWidget::widget(['block_number' => 2]).'
<p>Если вы любите часто менять стрижки и прически, то необходим быстрый и уверенный рост волос. Поэтому лучше будет выполнять стрижку при растущей Луне. Также при растущей Луне хорошо освежать концы волос, т.к. это придаст им свежесть и стимулирует дальнейший рост. Если же вы, наоборот, не любите часто посещать парикмахера, подберите день, в который Луна убывает. В этом вам поможет лунный календарь стрижки волос.<br /><br />Эти советы можно отнести не только к волосам на голове, но и ко всем волосам на теле человека. Поэтому при бритье волос тоже следует обратить внимание на фазу Луны, потому что после бритья при растущей Луне волосы будут расти быстрее и даже могут стать более жесткими.<br /><br />В новолуние астрологи вообще не советуют посещать парикмахеров и браться за бритву. В эти дни стрижка может даже укорачивать жизнь человека. В подтверждение своей теории они утверждают, что главная причина мужского облысения в том, что первая стрижка ребенка была сделана на убывающей Луне. Также с этим связывают людей, у которых редкие и слабые волосы.</p>
<p>&nbsp;</p>
<p>'.$todayBox.'<br /><br />'.\app\components\widgets\AdvertWidget::widget(['block_number' => 1]).'</p>
<br>
<table width="100%" class="moon_calendar_table">
    <tr>';
for($x=1;$x<=12;$x++){
    $linkYear = date('j') > 15 && $x == 12 && date('m') == 12 ? $year-1 : $year;
    $linkText = 'Календарь стрижек на '.GlobalHelper::rusMonth($x).' '.$linkYear.' года';
    if(isset($months[$linkYear][$x])) {
        $link = Html::a($linkText, ['horoscope/hair-month-calendar', 'year' => $linkYear, 'month' => GlobalHelper::engMonth($x)]);
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
<p>Также предлагаем вам ознакомиться с <a title="Общий лунный календарь" href="'.Url::to(['horoscope/moon-calendar']).'">общим лунным календарем на '.$year.' год</a>. В нем вы найдете наиболее полную информацию о фазах Луны, лунных днях и т.д.</p>';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);