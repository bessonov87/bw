<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Подтверждение Email адреса';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1><?= Html::encode($this->title) ?></h1></a></div>
    <div id="content-item-content">
        <div id="content-small-14">
            <p>Чтобы активировать учетную запись, пожалуйста, введите код подтверждения, присланный вам в письме:</p>

            <?php $form = ActiveForm::begin(['id' => 'confirm-email-form', 'method' => 'get']); ?>

            <?= $form->field($model, 'token')->textInput(['name' => 'token']) ?>

            <div class="form-group">
                <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>