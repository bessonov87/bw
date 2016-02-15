<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'reply_to',
            'post_id',
            [
                'attribute'=>'user_id',
                'format' => 'raw',
                'value' => function ($comment) {
                    return Html::a(Html::encode($comment->user_id),['user/view', 'id' => $comment->user_id]);
                },
            ],
            'date',
            // 'text_raw:ntext',
            'text:ntext',
            // 'ip',
            // 'is_register',
            // 'approve',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
