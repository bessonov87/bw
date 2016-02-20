<?php
/** @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
<form method="post" enctype="multipart/form-data">

    <div class="form_line">
        <div class="upload_file">
        <?= $form->field($model, 'files[]')->fileInput() ?>
        </div>
    </div>
    <div class="form_line">
        <?= $form->field($model, 'create_thumb')->checkbox() ?>
    </div>
    <div class="form_line">
        Уменьшение изображение более <?= $form->field($model, 'max_pixel')->textInput() ?> пикселей по <?= $form->field($model, 'max_pixel_side')->dropDownList(['width' => 'Ширине', 'height' => 'Высоте']) ?>
    </div>


    <table width="600" cellpadding="5" cellspacing="0" border="1">
        <tbody>
        <tr>
            <td>
                <table cellpadding="2" cellspacing="0" width="100%" id="files_table">
                    <tbody><tr>
                        <td>
                            Файл:
                        </td>
                        <td>
                            <input type="file" name="files[]">
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="thumb" value="ok" checked="checked"> Создавать уменьшенную копию
            </td>
        </tr>
        <tr>
            <td>
                Уменьшение изображение более <input type="text" name="max_pixel" maxlength="5" style="width:30px" value="400"> пикселей по
                <select name="max_side">
                    <option value="width" selected="">Ширине</option>
                    <option value="height">Высоте</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="water" value="ok" checked="checked"> Накладывать водяной знак
            </td>
        </tr>
        <tr>
            <td>
                Уже на сервере:
                <select name="already_on_server">
                    <option value="0">Выберите файл</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <img id="add_fields" title="Добавить поле для еще одного файла" style="vertical-align:middle; cursor:pointer" src="/admin/images/plus.png" width="32" height="32" onclick="addTableRow($('#files_table'))"> <img id="add_fields" title="Удалить последнее поле для файла" style="vertical-align:middle; cursor:pointer" src="/admin/images/minus.png" width="32" height="32" onclick="delTableRow($('#files_table'));"> <input type="submit" value="Загрузить файл(ы)" name="do_upload" style="vertical-align:middle">
            </td>
        </tr>
        </tbody></table>
</form>
<?php ActiveForm::end(); ?>


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