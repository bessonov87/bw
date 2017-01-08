<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ar\Post;
use common\components\helpers\GlobalHelper;
use common\models\ar\Goroskop;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoroskopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goroskops';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goroskop-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goroskop', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'filter' => Goroskop::zodiakFilter(),
                'attribute' => 'zodiak',
                'value' => function($model){
                    $znaki = Goroskop::zodiakFilter();
                    return $znaki[$model->zodiak];
                }
            ],
            //'created_at',
            //'text:ntext',
            'date',
            'week',
            'month',
            'year',
            [
                'filter' => Goroskop::periodFilter(),
                'attribute' => 'period',
                'value' => function($model){
                    $array = Goroskop::periodFilter();
                    return $array[$model->period];
                }
            ],
            [
                'filter' => Goroskop::typeFilter(),
                'attribute' => 'type',
                'value' => function($model){
                    $array = Goroskop::typeFilter();
                    return $array[$model->type];
                }
            ],
            [
                'filter' => Post::getStatusesArray(),
                'attribute' => 'approve',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    /** @var \yii\grid\DataColumn $column */
                    $value = $model->{$column->attribute};
                    switch ($value) {
                        case 1:
                            $class = 'success'; $text = 'Да'; break;
                        case 0:
                            $class = 'warning'; $text = 'Нет'; break;
                        default:
                            $class = 'default'; $text = '?';
                    };
                    $html = Html::tag('span', $text, ['class' => 'label label-' . $class]);
                    return $value === null ? $column->grid->emptyCell : $html;
                }
            ],
            'views',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
