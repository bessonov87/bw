<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'short') ?>

    <?= $form->field($model, 'full') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'meta_title') ?>

    <?php // echo $form->field($model, 'meta_descr') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'edit_date') ?>

    <?php // echo $form->field($model, 'edit_user') ?>

    <?php // echo $form->field($model, 'edit_reason') ?>

    <?php // echo $form->field($model, 'allow_comm') ?>

    <?php // echo $form->field($model, 'allow_main') ?>

    <?php // echo $form->field($model, 'allow_catlink') ?>

    <?php // echo $form->field($model, 'allow_similar') ?>

    <?php // echo $form->field($model, 'allow_rate') ?>

    <?php //echo $form->field($model, 'approve') ?>

    <?php // echo $form->field($model, 'fixed') ?>

    <?php // echo $form->field($model, 'category_art') ?>

    <?php // echo $form->field($model, 'inm') ?>

    <?php // echo $form->field($model, 'not_in_related') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
