<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\ProductsCategory $category
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = ['label' => Html::a('Таблица калорийности', '/tablica-kalorijnosti/'), 'encode' => false];

$this->title = "Таблица калорийности: {$category->name}";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "калорийность, таблица калорийности, {$category->name}, продукты, питание, калорийность продуктов"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "Таблица калорийности: {$category->name}. Считаем калории для здорового питания"
]);

$options = [
    'title' => $this->title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

$options['content'] = '';

$options['content'] .= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'tableOptions' => ['class' => 'table table-striped table-bordered table-calories'],
    'columns' => [
        [
            'attribute' => 'name',
            'label' => 'Продукт',
            'format' => 'raw',
            'value' => function($model) use($category){
                return Html::a($model->name, ['calory/view', 'category' => $category->url, 'product' => $model->alt_name]);
            },
            'headerOptions' => ['class' => 'th-prod-name'],
        ],
        [
            'attribute' => 'calories',
            'label' => 'Калорийность',
            'format' => 'raw',
            'value' => function($model){
                return $model->calories . ' ккал';
            },
            'headerOptions' => ['class' => 'th-calories'],
        ],
        [
            'attribute' => 'protein',
            'label' => 'Белки',
            'format' => 'raw',
            'value' => function($model){
                return round($model->protein/1000, 3) . ' г';
            },
            'headerOptions' => ['class' => 'th-protein'],
        ],
        [
            'attribute' => 'fat',
            'label' => 'Жиры',
            'format' => 'raw',
            'value' => function($model){
                return round($model->fat/1000, 3) . ' г';
            },
            'headerOptions' => ['class' => 'th-fat'],
        ],
        [
            'attribute' => 'carbohydrates',
            'label' => 'Углеводы',
            'format' => 'raw',
            'value' => function($model){
                return round($model->carbohydrates/1000, 3) . ' г';
            },
            'headerOptions' => ['class' => 'th-carbohydrates'],
        ],
    ],
]);

$options['content'] .= '<p>&nbsp;</p>';

// Text
$options['content'] .= '';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);