<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ZnakiZodiakaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="znaki-zodiaka-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'znak_id') ?>

    <?= $form->field($model, 'element') ?>

    <?= $form->field($model, 'planet') ?>

    <?= $form->field($model, 'opposite') ?>

    <?php // echo $form->field($model, 'stone') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'compatibility') ?>

    <?php // echo $form->field($model, 'common') ?>

    <?php // echo $form->field($model, 'man') ?>

    <?php // echo $form->field($model, 'woman') ?>

    <?php // echo $form->field($model, 'child') ?>

    <?php // echo $form->field($model, 'career') ?>

    <?php // echo $form->field($model, 'health') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
