<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author_id',
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
            'approve',
            // 'fixed',
            'category_art',
            // 'inm',
            // 'not_in_related',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
