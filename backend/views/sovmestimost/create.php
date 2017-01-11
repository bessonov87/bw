<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ar\Sovmestimost */

$this->title = 'Create Sovmestimost';
$this->params['breadcrumbs'][] = ['label' => 'Sovmestimosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sovmestimost-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
