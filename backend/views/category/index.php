<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\helpers\GlobalHelper;
use backend\components\grids\BwActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['style' => 'width: 65px; max-width: 65px;'],
                'contentOptions' => ['style' => 'width: 65px; max-width: 65px;'],
            ],
            [
                'attribute' => 'parent_id',
                'options' => ['style' => 'width: 75px; max-width: 75px;'],
                'contentOptions' => ['style' => 'width: 75px; max-width: 75px;'],
            ],
            [
                'attribute' => 'name',
                'options' => ['style' => 'min-width: 300px;'],
                'contentOptions' => ['style' => 'min-width: 300px;'],
            ],
            [
                'attribute' => 'url',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $value = $model->url;
                    $html = Html::tag('span', Html::encode($value), ['class' => 'label label-blue']);
                    return $value === null ? $column->grid->emptyCell : $html;
                },
            ],
            //'icon',
            // 'description:ntext',
            // 'meta_title',
            // 'meta_descr',
            // 'meta_keywords',
            // 'post_sort',
            // 'post_num',
            // 'short_view',
            // 'full_view',
            'category_art',
            // 'header:ntext',
            // 'footer:ntext',
            'add_method',
            'postCount',

            [
                'class' => BwActionColumn::className(),
                'buttons' => [
                    'link' => function ($url, $model) {
                        $customurl = Yii::$app->params['frontendBaseUrl'].GlobalHelper::getCategoryUrlById($model->id).'/';
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-link"></span>', $customurl,
                            ['title' => 'Открыть статью', 'target' => '_blank']);
                    }
                ],
                'template' => '{view} {update} {delete} {link}',
            ],
        ],
    ]); ?>

</div>
