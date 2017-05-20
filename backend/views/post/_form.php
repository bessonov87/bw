<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\editor\TinyMCE;

/* @var $this yii\web\View */
/* @var $model common\models\ar\Post */
/* @var $form yii\widgets\ActiveForm */

// Генерируем рандомный идентификатор, используемый при добавлении изображений для новых статей (у которых еще нет id)
$cookies = Yii::$app->response->cookies;
$cookies->remove('r_id');
if (!$model->id) {
    $r_id = Yii::$app->security->generateRandomString(6);
    $cookies->add(new \yii\web\Cookie([
        'name' => 'r_id',
        'value' => $r_id
    ]));
}
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'author_id')->textInput(['style' => 'width: 150px;']) ?>

    <?= $form->field($model, 'date')->textInput(['style' => 'width: 150px;', 'id' => 'calendar-field', 'value' => (new \DateTime($model->date, new \DateTimeZone('Europe/Moscow')))->format('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_descr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(\common\components\helpers\GlobalHelper::getCategoriesFilter()) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short')->widget(
        TinyMCE::className(),[
            'clientOptions' => [
                'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
                'plugin_upload_r_id' => ($model->id) ? null : $r_id,
                'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
            ]
    ]); ?>

    <?= $form->field($model, 'full')->widget(
        TinyMCE::className(),[
        'clientOptions' => [
            'height' => 800,
            'plugin_upload_post_id' => ($model->id) ? $model->id : 0,
            'plugin_upload_r_id' => ($model->id) ? null : $r_id,
            'plugin_upload_area' => ($model->id) ? 'editpost' : 'addpost',
        ]
    ]); ?>

    <?= $form->field($model, 'edit_date')->textInput() ?>

    <?= $form->field($model, 'edit_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edit_reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'related')->textInput() ?>

    <?= $form->field($model, 'prev_page')->textInput() ?>

    <?= $form->field($model, 'next_page')->textInput() ?>

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

    <?= $form->field($model, 'skin')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
