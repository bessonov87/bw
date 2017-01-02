<?php
/**
 * @var \yii\web\View $this
 * @var int $year
 * @var int $month
 * @var string $monthEng
 * @var array $monthData
 */

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\helpers\GlobalHelper;
use app\components\widgets\AdvertWidget;

/*$js = <<<JS
$(function() {
    console.log('start');
    $('.bar-percentage[data-percentage]').each(function () {
        console.log('each');
      var progress = $(this);
      var percentage = Math.ceil($(this).attr('data-percentage'));
      console.log(percentage);
      $({countNum: 0}).animate({countNum: percentage}, {
        duration: 2000,
        easing:'linear',
        step: function() {
          var pct = Math.floor(this.countNum) + '%';
          progress.text(pct) && progress.siblings().children().css('width',pct);
        }
      });
    });
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);*/


$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => Html::a('Лунный календарь стрижек ' . $year, ['horoscope/hair-calendar']), 'encode' => false];

$this->title = "Лунный календарь стрижек на ".GlobalHelper::rusMonth($month)." $year года. Благоприятные и неблагоприятные дни для стрижки волос в ".GlobalHelper::rusMonth($month, 'p')." $year";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "лунный календарь, $year, Луна $year, знаки Зодиака, влияние Луны, лунный, календарь, Луна, дни, год, новолуние, календарь лунных дней $year, полнолуние, сутки, влияние, Зодиаки, месяц, положение"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Лунный календарь стрижки волос на ".GlobalHelper::rusMonth($month)." $year года. Когда стричься в ".GlobalHelper::rusMonth($month).' '.$year
]);

// Добавляем canonical
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/hair-month-calendar', 'year' => $year, 'month' => $month])]);

$options = [
    'title' => "Лунный календарь стрижек на ".GlobalHelper::rusMonth($month)." $year года",
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

$options['content'] .= AdvertWidget::widget(['block_number' => 2]);
$options['content'] .= '<p>Луна во все времена притягивала к себе повышенное внимание. Многие ученые (и не только) 
    проводили практически всю свои жизнь за наблюдением и сбором информации о влиянии этого «небесного светила» на 
    Землю и человека. На основании наблюдений было сделано множество удивительных открытий, одному из которых посвящен 
    данный цикл статей.</p><p>Считается, что существует серьезное лунное влияние на рост волос. Мы предлагаем вам лунный 
    календарь стрижки волос, который составлен профессиональным астрологом.</p>';
$options['content'] .= '<p>&nbsp;</p>';
$options['content'] .= "<div style='text-align: center;'><img src='/uploads/moon/hair/$year-".sprintf('%02d', $month).".jpg' width='400' alt='{$options['title']}'></div>";
$options['content'] .= '<p>&nbsp;</p>';

$table = '<table class="table-hair-month-calendar">';
$monthR = GlobalHelper::rusMonth($month, 'r');
$d = 1;
$days = [];
foreach ($monthData as $day){
    $barColor = $day['blago'] == 1 ? 'bar-emerald' : 'bar-red';
    $barPercentage = ($day['blago_level'] + 5) * 10 + ($d + $d/(2*$month) - (2*$d)/$month);
    $days[$d] = $barPercentage;
    if($barPercentage > 100){
        $barPercentage = 100;
    }
    $table .= '<tr>';
    $table .= '<td style="width: 105px;"><strong>'.$d.' '.$monthR.'</strong></td>';
    $table .= '<td>
  <div id="bar-2" class="bar-main-container '.$barColor.'">
    <div class="wrap">
      <div class="bar-percentage" data-percentage="'.$barPercentage.'"></div>
      <div class="bar-container">
        <div class="bar" style="width: '.$barPercentage.'%"></div>
      </div>
    </div>
  </div>
</td>';
    $table .= '<td><strong>'.$day['hair_text'].'</strong></td>';
    $table .= '</tr>';
    if($d == 15){
        $table .= '<tr>';
        $table .= '<td colspan="3">'.AdvertWidget::widget(['block_number' => 1]).'</td>';
        $table .= '</tr>';
    }
    $d++;
}
$table .= '</table>';
//sort($days);
$worst = array_search(min($days), $days);
$best = array_search(max($days), $days);
$options['content'] .= '<p>&nbsp;</p>';
$options['content'] .= '<h3>Самые благоприятный и самый неблагоприятный день для стрижки волос в '.GlobalHelper::rusMonth($month, 'p').'</h3>';
$options['content'] .= '<ul><li>Наиболее благоприятным днем для стрижки в этом месяце является <strong style="color: #009900;">'.$best.' '.$monthR.'</strong></li>';
$options['content'] .= '<li>Самым неблагоприятным днем для похода в парикмахерскую - <strong style="color: #cc0000;">'.$worst.' '.$monthR.'</strong></li></ul>';
$options['content'] .= '<p>&nbsp;</p>';
$options['content'] .= $table;

$options['similar'] = [];
if($month != date('m')){
    $m = date('m');
    $options['similar'][0]['url'] = Url::to(['horoscope/moon-month-calendar', 'year' => $year, 'month' => GlobalHelper::engMonth($m, 'i')]);
    $options['similar'][0]['title'] = 'Лунный календарь на '.GlobalHelper::rusMonth($m).' '.$year.' года';
    $options['similar'][1]['url'] = Url::to(['horoscope/hair-month-calendar', 'year' => $year, 'month' => GlobalHelper::engMonth($m, 'i')]);
    $options['similar'][1]['title'] = 'Лунный календарь стрижек на '.GlobalHelper::rusMonth($m).' '.$year.' года';
}
$options['similar'][2]['url'] = Url::to(['horoscope/moon-month-calendar', 'year' => $year, 'month' => GlobalHelper::engMonth($month, 'i')]);
$options['similar'][2]['title'] = 'Лунный календарь на '.GlobalHelper::rusMonth($month).' '.$year.' года';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);

?>