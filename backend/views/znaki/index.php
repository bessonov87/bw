<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ZnakiZodiakaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Znaki Zodiakas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="znaki-zodiaka-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Znaki Zodiaka', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'znak_id',
            'element',
            'planet',
            'opposite',
            // 'stone',
            // 'color',
            // 'compatibility',
            // 'common:ntext',
            // 'man:ntext',
            // 'woman:ntext',
            // 'child:ntext',
            // 'career:ntext',
            // 'health:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
