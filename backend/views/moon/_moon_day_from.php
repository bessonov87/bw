<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\ar\MoonCal $model
 */

use yii\widgets\ActiveForm;
use common\components\helpers\GlobalHelper;

$phases = [
    0 => '',
    1 => 'Новолуние',
    2 => '1 четверть',
    3 => 'Полнолуние',
    4 => '4 четверть',
];

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'date')->textInput(['editable' => false]) ?>
<div class="row">
    <div class="col-md-4"><?= $form->field($model, 'moon_day') ?></div>
    <div class="col-md-4"><?= $form->field($model, 'moon_day_from')->textInput(['type' => 'time']) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'moon_day_sunset')->textInput(['type' => 'time']) ?></div>
</div>
<div class="row">
    <div class="col-md-4"><?= $form->field($model, 'moon_day2') ?></div>
    <div class="col-md-4"><?= $form->field($model, 'moon_day2_from')->textInput(['type' => 'time']) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'moon_day2_sunset')->textInput(['type' => 'time']) ?></div>
</div>
<div class="row">
    <div class="col-md-4"><?= $form->field($model, 'phase')->dropDownList($phases) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'phase_from')->textInput(['type' => 'time']) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'moon_percent') ?></div>
</div>
<div class="row">
    <div class="col-md-4"><?= $form->field($model, 'zodiak')->dropDownList(GlobalHelper::getZodiakList()) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'zodiak_from_ut')->textInput(['type' => 'time']) ?></div>
    <div class="col-md-4"><?= $form->field($model, 'blago')->dropDownList([0 => '', 1 => 'Да', 2 => 'Нет']) ?></div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>