<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\helpers\GlobalHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ar\Comment */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Редактирование профиля пользователя";
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= $this->title ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <?php
            if($e = $model->getErrors()){
                echo '<div class="label label-danger" style="font-size: 14px">';
                foreach($e as $error){
                    echo "$error[0]";
                }
                echo '</div>';
            }
            ?>
            <?php $form = ActiveForm::begin(['options' => ['id' => 'edit-profile-form', 'enctype' => 'multipart/form-data']]); ?>

            <div class="username">Пользователь: <h4 style="text-decoration: underline;display: inline-block;"><?= $user->username ?></h4></div>

            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'surname') ?>

            <?= $form->field($model, 'sex')->radioList(['f' => 'Женский', 'm' => 'Мужской']) ?>

            <label class="control-label">Дата рождения</label>
            <div style="margin-bottom: 15px;">
            <?= Html::activeDropDownList($model, 'birthYear', GlobalHelper::getYearsList(), ['class' => 'form-select', 'style' => 'width:90px;']) ?>
            <?= Html::activeDropDownList($model, 'birthMonth', GlobalHelper::getMonthsList(), ['class' => 'form-select', 'style' => 'width:130px;']) ?>
            <?= Html::activeDropDownList($model, 'birthDay', GlobalHelper::getDaysList(), ['class' => 'form-select', 'style' => 'width:80px;']) ?>
            </div>

            <label class="control-label">Место жительства (Страна/Город)</label>
            <div style="margin-bottom: 15px;">
            <?= Html::activeDropDownList($model, 'country', GlobalHelper::getCountriesList(), ['class' => 'form-select', 'style' => 'width:150px;']) ?>
            <?= Html::activeTextInput($model, 'city', ['class' => 'form-select', 'style' => 'width:200px;']) ?>
            </div>

            <?php
                if($img = $model->avatar){
                    echo '<div style="display: inline;"><img src="/uploads/fotos/'.$img.'" style="width:80px;"></div>';
                }
            ?>
            <?= $form->field($model, 'image')->fileInput() ?>

            <?= $form->field($model, 'info')->textarea() ?>

            <?= $form->field($model, 'signature') ?>

            <div class="form-group">
                <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="clear"></div>
    </div>
</div>
