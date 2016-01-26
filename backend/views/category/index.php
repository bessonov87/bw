<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'name',
            'url:url',
            'icon',
            // 'description:ntext',
            // 'meta_title',
            // 'meta_descr',
            // 'meta_keywords',
            // 'post_sort',
            // 'post_num',
            // 'short_view',
            // 'full_view',
            // 'category_art',
            // 'header:ntext',
            // 'footer:ntext',
            'add_method',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
