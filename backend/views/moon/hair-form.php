<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\MoonHair $moonHairModel
 */

use yii\widgets\ActiveForm;
use backend\components\editor\TinyMCE;

$r_id = uniqid();

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-4"><?= $form->field($moonHairModel, 'id')->textInput(['editable' => false]) ?></div>
    <div class="col-md-4"><?= $form->field($moonHairModel, 'post_id') ?></div>
    <div class="col-md-4"><?= $form->field($moonHairModel, 'date')->textInput(['editable' => false]) ?></div>
</div>
<?= $form->field($moonHairModel, 'title') ?>
<?= $form->field($moonHairModel, 'short')->widget(
    TinyMCE::className(),[
    'clientOptions' => [
        'plugin_upload_post_id' => ($moonHairModel->id) ? $moonHairModel->id : 0,
        'plugin_upload_r_id' => ($moonHairModel->id) ? null : $r_id,
        'plugin_upload_area' => ($moonHairModel->id) ? 'editpost' : 'addpost',
    ]
]) ?>
<?= $form->field($moonHairModel, 'full')->widget(
    TinyMCE::className(),[
    'clientOptions' => [
        'plugin_upload_post_id' => ($moonHairModel->id) ? $moonHairModel->id : 0,
        'plugin_upload_r_id' => ($moonHairModel->id) ? null : $r_id,
        'plugin_upload_area' => ($moonHairModel->id) ? 'editpost' : 'addpost',
    ]
]) ?>
<div class="row">
    <div class="col-md-4"><?= $form->field($moonHairModel, 'approve')->dropDownList([1 => 'Да', 0 => 'Нет']) ?></div>
    <div class="col-md-4"><?= $form->field($moonHairModel, 'views') ?></div>
    <div class="col-md-4"></div>
</div>

<div class="row">
    <div class="col-md-12 text-right">
        <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
