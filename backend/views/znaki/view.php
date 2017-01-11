<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ZnakiZodiaka */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Znaki Zodiakas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="znaki-zodiaka-view">

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
            'znak_id',
            'element',
            'planet',
            'opposite',
            'stone',
            'color',
            'compatibility',
            'common:ntext',
            'man:ntext',
            'woman:ntext',
            'child:ntext',
            'career:ntext',
            'health:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
