<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$inputValue = '';
$searchForm = Yii::$app->request->post('SearchForm');
//$searchPlaceholder = ($searchPhrase = Yii::$app->request->post('story')) ? $searchPhrase : 'Поиск ...';
//$searchPlaceholder2 = ($searchPhrase = $model->story) ? $searchPhrase : 'Поиск ...';
if(isset($searchForm['story'])){
    $inputValue = $searchForm['story'];
}
?>
<div id="content-item">
    <div id="content-item-top" class="content-item-blue"><h1>Поиск по сайту</h1></div>
    <div id="content-item-content">
        <div id="content-small-10" style="padding: 15px;">
            <?php $form = ActiveForm::begin([
                'action' => ['site/search'],
            ]); ?>
            <div class="container-4">
                <?= $form->field($model, 'story')->textInput(['placeholder' => 'Поиск ...', 'value' => $inputValue])->label('Поисковая фраза') ?>
                <?= Html::submitButton('Искать', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>