<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adverts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advert-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Advert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'block_number',
            'code:ntext',
            'location',
            // 'replacement_tag',
            // 'category',
            // 'approve',
            // 'on_request',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
