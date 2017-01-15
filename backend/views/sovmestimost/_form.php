<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AppData;
use backend\components\editor\TinyMCE;

/* @var $this yii\web\View */
/* @var $model common\models\ar\Sovmestimost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sovmestimost-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'man')->dropDownList(AppData::$rusZnaki, ['prompt' => 'Выбрать ...']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'woman')->dropDownList(AppData::$rusZnaki, ['prompt' => 'Выбрать ...']) ?>
        </div>
    </div>

    <?= $form->field($model, 'text')->widget(
        TinyMCE::className(), [
        'clientOptions' => [
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : uniqid(),
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
