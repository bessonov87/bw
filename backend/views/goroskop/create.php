<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ar\Goroskop */

$this->title = 'Create Goroskop';
$this->params['breadcrumbs'][] = ['label' => 'Goroskops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goroskop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
