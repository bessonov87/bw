<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model common\models\ar\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'short')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]); ?>

    <?= $form->field($model, 'full')->widget(TinyMce::className(), [
        'options' => ['rows' => 16],
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_descr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edit_date')->textInput() ?>

    <?= $form->field($model, 'edit_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edit_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'allow_comm')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'allow_main')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'allow_catlink')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'allow_similar')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'allow_rate')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'allow_ad')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'approve')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'fixed')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'category_art')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <?= $form->field($model, 'not_in_related')->radioList([1 => 'Да', 0 => 'Нет']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
