<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\AppData;
use backend\components\editor\TinyMCE;

/* @var $this yii\web\View */
/* @var $model common\models\ar\Goroskop */
/* @var $form yii\widgets\ActiveForm */

$years = [];
for ($x=2012;$x<=2025;$x++){
    $years[$x] = $x;
}

$r_id = uniqid();
?>

<div class="goroskop-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4"><?= $form->field($model, 'zodiak')->dropDownList(AppData::$rusZnaki, ['prompt' => 'Выбрать ...']) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'period')->dropDownList(AppData::$periodsList, ['prompt' => 'Выбрать ...']) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'type')->dropDownList(['common' => 'Общий', 'vostok' => 'Восточный'], ['prompt' => 'Выбрать ...']) ?></div>
    </div>

    <div class="row">
        <div class="col-md-3"><?= $form->field($model, 'date')->textInput(['style' => 'width: 100%;', 'id' => 'calendar-field']) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'week')->input('number') ?></div>
        <div class="col-md-3"><?= $form->field($model, 'month')->dropDownList(AppData::$rusMonths, ['prompt' => 'Выбрать ...']) ?></div>
        <div class="col-md-3"><?= $form->field($model, 'year')->dropDownList($years, ['prompt' => 'Выбрать ...']) ?></div>
    </div>

    <?php foreach (array_merge([0 => 'Для всех'], AppData::$rusZnaki) as $index => $znak) {
        $attr = "znakiText[$index]";
        echo $form->field($model, $attr)->widget(
            TinyMCE::className(), [
            'clientOptions' => [
                'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
                'plugin_upload_r_id' => ($model->id) ? null : $r_id,
                'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
            ]
        ])->label($znak);
    } ?>

    <?= $form->field($model, 'approve')->dropDownList([1 => 'Да', 0 => 'Нет']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
