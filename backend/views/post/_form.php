<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'short')->textarea(['rows' => 6])->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'full')->textarea(['rows' => 16])->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_descr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edit_date')->textInput() ?>

    <?= $form->field($model, 'edit_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edit_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'allow_comm')->textInput() ?>

    <?= $form->field($model, 'allow_main')->textInput() ?>

    <?= $form->field($model, 'allow_catlink')->textInput() ?>

    <?= $form->field($model, 'allow_similar')->textInput() ?>

    <?= $form->field($model, 'allow_rate')->textInput() ?>

    <?= $form->field($model, 'approve')->textInput() ?>

    <?= $form->field($model, 'fixed')->textInput() ?>

    <?= $form->field($model, 'category_art')->textInput() ?>

    <?= $form->field($model, 'inm')->textInput() ?>

    <?= $form->field($model, 'not_in_related')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
