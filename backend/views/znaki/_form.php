<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AppData;
use backend\components\editor\TinyMCE;

$r_id = uniqid();

if($model->getErrors()){
    var_dump($model->getErrors());
}

/* @var $this yii\web\View */
/* @var $model common\models\ZnakiZodiaka */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="znaki-zodiaka-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'znak_id')->dropDownList(AppData::$rusZnaki, ['prompt' => 'Выберите знак ...']) ?>

    <?= $form->field($model, 'element')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'planet')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opposite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'compatibility')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'common')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ])->label('Общая характеристика') ?>

    <?= $form->field($model, 'man')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ])->label('Мужчина') ?>

    <?= $form->field($model, 'woman')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ])->label('Женщина') ?>

    <?= $form->field($model, 'child')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ])->label('Ребенок') ?>

    <?= $form->field($model, 'career')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ])->label('Карьера и деньги') ?>

    <?= $form->field($model, 'health')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ])->label('Здоровье') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
