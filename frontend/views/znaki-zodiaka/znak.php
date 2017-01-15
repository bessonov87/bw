<?php
/**
 * @var \yii\web\View $this
 * @var string $znak
 * @var string $type
 * @var string $text
 * @var \common\models\ar\ZnakiZodiaka $znakModel
 */

use yii\helpers\Url;
use yii\helpers\Html;
use common\components\helpers\GlobalHelper;
use app\components\widgets\ZodiakTableWidget;
use common\models\ar\ZnakiZodiaka;
use app\components\widgets\ZnakZodiakaHeaderWidget;

$this->params['breadcrumbs'][] = ['label' => Html::a('Гороскоп', '/horoscope/'), 'encode' => false];

$znakRus = GlobalHelper::rusZodiac($znakModel->znak_id);
$znakRod = GlobalHelper::rusZodiac($znakModel->znak_id, 'r');

switch ($type){
    case ZnakiZodiaka::TYPE_COMMON:
        $metaTitle = "Знак Зодиака $znakRus. Планета, стихия, цвет и характер $znakRod";
        $title = "Характер $znakRod";
        break;
    case ZnakiZodiaka::TYPE_MAN:
        $metaTitle = "Мужчина знака Зодиака $znakRus";
        $title = "$znakRus-мужчина";
        break;
    case ZnakiZodiaka::TYPE_WOMAN:
        $metaTitle = "Женщина знака Зодиака $znakRus";
        $title = "$znakRus-женщина";
        break;
    case ZnakiZodiaka::TYPE_CHILD:
        $metaTitle = "Ребенок знака Зодиака $znakRus";
        $title = "$znakRus-ребенок";
        break;
    case ZnakiZodiaka::TYPE_CAREER:
        $metaTitle = "Карьера, работа и отношение к деньгам $znakRod";
        $title = $metaTitle;
        break;
    case ZnakiZodiaka::TYPE_HEALTH:
        $metaTitle = "Здоровье $znakRod";
        $title = $metaTitle;
        break;
    case ZnakiZodiaka::TYPE_SEX:
        $metaTitle = "Здоровье $znakRod";
        $title = $metaTitle;
        break;
    default:
        $metaTitle = $znakRus . ' ' . $type;
        $title = $metaTitle;
        break;
}
$this->title = $metaTitle;
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "астрологические прогнозы, гороскоп $znakRus, характер $znakRod, предсказания астрологов, $type"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Астрологические прогнозы для $znakRod"
]);

// Добавляем canonical
//$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['horoscope/index', 'type' => 'common', 'period' => 'index'])]);

$options = [
    'title' => $metaTitle,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

$options['content'] .= ZnakZodiakaHeaderWidget::widget(['znakModel' => $znakModel]);

$options['content'] .= '<div class="goroskop_text"><h4 style="text-align: center;">'.$title.'</h4>'.$text.'</div>';

$options['content'] .= ZodiakTableWidget::widget([
    'baseUrl' => '/znaki-zodiaka/',
    'znak' => $znak,
    'period' => 'znaki'
]);

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);
