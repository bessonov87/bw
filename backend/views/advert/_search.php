<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdvertSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advert-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'block_number') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'replacement_tag') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'approve') ?>

    <?php // echo $form->field($model, 'on_request') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
