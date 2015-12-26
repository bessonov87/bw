<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author_id',
            'date',
            'short:ntext',
            'full:ntext',
            'title',
            'meta_title',
            'meta_descr',
            'meta_keywords',
            'url:url',
            'edit_date',
            'edit_user',
            'edit_reason',
            'allow_comm',
            'allow_main',
            'allow_catlink',
            'allow_similar',
            'allow_rate',
            'approve',
            'fixed',
            'category_art',
            'inm',
            'not_in_related',
        ],
    ]) ?>

</div>
