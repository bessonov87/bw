<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить статью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            //'author_id',
            'date',
            'title',
            //'short:ntext',
            //'full:ntext',
            // 'meta_title',
            // 'meta_descr',
            // 'meta_keywords',
            // 'url:url',
            // 'edit_date',
            // 'edit_user',
            // 'edit_reason',
            // 'allow_comm',
            // 'allow_main',
            // 'allow_catlink',
            // 'allow_similar',
            // 'allow_rate',
            [
                'filter' => Post::getStatusesArray(),
                'attribute' => 'approve',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    /** @var \yii\grid\DataColumn $column */
                    $value = $model->{$column->attribute};
                    switch ($value) {
                        case Post::APPROVED:
                            $class = 'success';
                            break;
                        case Post::NOT_APPROVED:
                            $class = 'warning';
                            break;
                        default:
                            $class = 'default';
                    };
                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'label label-' . $class]);
                    return $value === null ? $column->grid->emptyCell : $html;
                }
            ],
            // 'fixed',
            [
                'filter' => [0 => 'Нет', 1 => 'Да'],
                'attribute' => 'category_art',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Post $model */
                    /** @var \yii\grid\DataColumn $column */
                    $value = $model->{$column->attribute};
                    switch ($value) {
                        case 0:
                            $class = 'default';
                            $val = 'Нет';
                            break;
                        case 1:
                            $class = 'success';
                            $val = 'Да';
                            break;
                        default:
                            $class = 'default';
                            $val = 'Нет';
                    };

                    $html = Html::tag('span', Html::encode($val), ['class' => 'label label-' . $class]);
                    return $value === null ? $column->grid->emptyCell : $html;
                }
            ],
            // 'inm',
            // 'not_in_related',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'link' => function ($url, $model) {
                        $customurl = $model->link; //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-link"></span>', $customurl,
                            ['title' => 'Открыть статью']);
                    }
                ],
                'template' => '{view} {update} {delete} {link}',
            ],
        ],
    ]); ?>

</div>
