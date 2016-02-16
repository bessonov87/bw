<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div id="top-nav-search">
    <div class="box">
        <?php $form = ActiveForm::begin([
            'action' => ['site/search'],
            'fieldConfig' => [
                'template' => '{input}',
            ],
        ]); ?>
            <div class="container-4">
                <?= Html::activeTextInput($model, 'story', ['id' => 'search', 'placeholder' => 'Поиск ...']) ?>
                <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'icon']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>