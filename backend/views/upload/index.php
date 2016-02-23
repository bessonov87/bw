<?php
/** @var $this yii\web\View */
/** @var $model backend\models\UploadForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$imgConfig = Yii::$app->params['admin']['images'];
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'upload_form']]); ?>
    <div class="form_line">
        <?= $form->field($model, 'post_id')->hiddenInput(['value' => Yii::$app->request->get('post_id')])->label(false) ?>
        <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->request->get('user_id')])->label(false) ?>
        <?= $form->field($model, 'folder')->hiddenInput(['value' => Yii::$app->request->get('date_dir')])->label(false) ?>
        <?= $form->field($model, 'files[]', ['template'=>'{label} {input}'])->fileInput(['multiple' => true])->label(false) ?>
    </div>
    <div class="form_line">
        <?= $form->field($model, 'create_thumb', ['template'=>'{label} {input}'])->checkbox() ?>
    </div>
    <div class="form_line">
        <?= $form->field($model, 'watermark', ['template'=>'{label} {input}'])->checkbox() ?>
    </div>
    <div class="form_line">
        Уменьшение изображение более <?= $form->field($model, 'max_pixel')->textInput(['value' => $imgConfig['max_pixel'], 'class' => 'inline_input'])->label(false) ?> пикселей по <?= $form->field($model, 'max_pixel_side')->dropDownList(['width' => 'Ширине', 'height' => 'Высоте'], ['class' => 'inline_input'])->label(false) ?>
    </div>
    <div class="form_line">
        Уже на сервере: <?= $form->field($model, 'on_server')->dropDownList([0 => 'Выберите файл'], ['class' => 'inline_input'])->label(false) ?>
    </div>
    <div class="form_line">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
    </div>
<?= $form->errorSummary($model); ?>
<?php ActiveForm::end(); ?>

<div class="form_messages">
    <?php
    if($e = $model->getErrors()){
        /* TODO оформить вывод ошибок */
        var_dump($e);
    }
    if($r = $model->getResult()){
        /* TODO оформить вывод результата */
        var_dump($r);
    }
    ?>
</div>

<table width="600" cellpadding="5" cellspacing="0" border="1">
    <tbody><tr>
        <td>
            <table width="100%" cellpadding="3" cellspacing="0" border="0">
                <tbody><tr>
                    <td>
                        <strong>Файлы, загруженные для данной публикации</strong>
                    </td>
                    <td width="15" align="center">
                        <input type="checkbox" value="all" id="check_all_box" title="Выделить все">
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td>
            <form method="post" id="img_form" name="img_form"><div id="inputs">
                    <table cellpadding="3" cellspacing="0" width="100%" id="uploads"></table><table cellpadding="3" cellspacing="0" width="100%" id="uploads">
                        <tbody><tr>
                            <td>
                                <a href="javascript:insertimage('http://40-weeks.ru/uploads/posts/2015-06/oslozhnenija_1433238343.jpg')">oslozhnenija_1433238343.jpg</a>
                            </td>
                            <td width="80">
                                <a href="javascript:image_show('http://40-weeks.ru/uploads/posts/2015-06/oslozhnenija_1433238343.jpg', 400, 250)">Просмотр</a>
                            </td>
                            <td width="80">
                                &nbsp;
                            </td>
                            <td width="60">
                                400x250
                            </td>
                            <td width="15">
                                <input type="checkbox" class="checkbox_box" name="images_on[]" value="image|172|2015-06/oslozhnenija_1433238343.jpg|img|http://40-weeks.ru/uploads/posts/2015-06/oslozhnenija_1433238343.jpg">
                            </td>
                        </tr>
                        <tr><td colspan="5" align="center">
                                Нет файлов, загруженных для данной публикации
                            </td></tr></tbody></table><table cellpadding="3" cellspacing="0" width="100%" id="uploads_1"><tbody><tr><td width="50%">
                                Выравнивать: <select name="imageAlign" id="imageAlign">
                                    <option value="left">По левому</option>
                                    <option value="right">По правому</option>
                                    <option value="center">По центру</option>
                                    <option value="none">Нет</option>
                                </select>
                            </td><td align="right">
                                C выделенными: <input type="button" value="Вставить" id="insert_checked" name="add_img"> <input type="submit" value="Удалить" name="del_img_file">
                            </td></tr></tbody></table></div></form>
        </td>
    </tr>
    </tbody></table>