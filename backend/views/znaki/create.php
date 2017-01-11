<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ZnakiZodiaka */

$this->title = 'Create Znaki Zodiaka';
$this->params['breadcrumbs'][] = ['label' => 'Znaki Zodiakas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="znaki-zodiaka-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
