<?php
/** @var $this yii\web\View */
/** @var $model backend\models\UploadForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Загрузка файлов";

if($p_id = Yii::$app->request->get('post_id')){
    $this->title .= ' для статьи с Id '.$p_id;
} else if($fake_id = Yii::$app->request->get('r_id')){
    $this->title .= ' для новой статьи (Fake Id '.$fake_id.')';
}

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

    if($e = $fModel->getErrors()){
        /* TODO оформить вывод ошибок */
        var_dump($e);
    }
    if($r = $fModel->getResult()){
        /* TODO оформить вывод результата */
        var_dump($r);
    }
    ?>
</div>

<h4>Файлы, загруженные для данной публикации</h4>



<script>
function image_show(image, width, height)
{
    window.open(image, '_Showimage', 'toolbar=0,location=0,status=0, left=0, top=0, menubar=0,scrollbars=yes,resizable=0,width=' + width + ',height=' + height + '');
}

function insertimage(selectedImage) {
    imageAlign = document.forms['img_form'].imageAlign.value;
    if (imageAlign == 'center')
        finalImage = '<div style="text-align: center;"><img src="' + selectedImage + '" border=0></div>';
    else
        finalImage = '<img align="' + imageAlign + '" src="' + selectedImage + '" border=0>';

    window.opener.tinyMCE.execCommand('mceInsertContent',false,finalImage);
}

function insertthumb(selectedImage) {
    var array_image = new Array();
    var original_image, thumb_image;
    array_image = selectedImage.split('|');
    original_image = array_image[0];
    thumb_image = array_image[1];
    imageAlign = document.forms['img_form'].imageAlign.value;
    if (imageAlign == 'center')
        finalImage = "<p style='text-align: center;'><a href='" + original_image + "' class='fancybox_image' ><img src='" + thumb_image + "' /></a></p>";
    else
        finalImage = "<a href='" + original_image + "' class='fancybox_image' ><img align='" + imageAlign + "' src='" + thumb_image + "' /></a>";

    window.opener.tinyMCE.execCommand('mceInsertContent',false,finalImage);
}

function insertfile(selectedFileId) {
    var finalFile = "<div>[attachment=" + selectedFileId + "]</div>";
    window.opener.tinyMCE.execCommand('mceInsertContent',false,finalFile);
}
</script>




<?php $form = ActiveForm::begin(['options' => ['id' => 'img_form']]); ?>
    <div id="inputs">
        <table class="images_table">
        <?php
        // Изображения
        foreach($images as $image):
        /** @var $image common\models\ar\Images */
            /*// Для старых статей все немного по-другому
            if(mb_stristr($image->image_name, '|||')){

            }*/
            $thumb = 0;
            $imageUrl = Yii::$app->params['frontendBaseUrl'].'uploads/'.$image->folder.'/'.$image->image_name;
            $imagePath = Yii::getAlias(Yii::$app->params['admin']['uploadsPathAlias']).$image->folder.'/'.$image->image_name;
            $thumbPath = Yii::getAlias(Yii::$app->params['admin']['uploadsPathAlias']).$image->folder.'/thumbs/'.$image->image_name;
            $imageSize = getimagesize($imagePath);
            $imageM = '<img src="'.$imageUrl.'" width="50" height="30">';
            if(is_file($thumbPath)){
                $thumb = 1;
                $thumbUrl = Yii::$app->params['frontendBaseUrl'].'uploads/'.$image->folder.'/thumbs/'.$image->image_name;
                $thumbSize = getimagesize($thumbPath);
                $insert = '<a href="javascript:insertthumb(\''.$imageUrl.'|'.$thumbUrl.'\')">'.$image->image_name.'</a>';
                $show = '<a href="javascript:image_show(\''.$thumbUrl.'\', '.$thumbSize[0].', '.$thumbSize[1].')"><i class="fa fa-eye"></i></a>';
                $original = '<a href="javascript:image_show(\''.$imageUrl.'\', '.$imageSize[0].', '.$imageSize[1].')">Оригинал</a>';
                $size = $thumbSize[0].'x'.$thumbSize[1];
            } else {
                $thumbUrl = 'none';
                $insert = '<a href="javascript:insertimage(\''.$imageUrl.'\')">'.$image->image_name.'</a>';
                $show = '<a href="javascript:image_show(\''.$imageUrl.'\', '.$imageSize[0].', '.$imageSize[1].')"><i class="fa fa-eye"></i></a>';
                $original = '';
                $size = $imageSize[0].'x'.$imageSize[1];
            }
            $input = $form->field($fModel, 'files[]')->checkbox(['value' => 'image|'.$image->id.'|'.$image->folder.'|'.$image->image_name.'|thumb|'.$thumb, 'label' => false, 'uncheck' => null]);
            //'<input type="checkbox" class="checkbox_box" name="images[]" value="image|'.$image->id.'|'.$imageUrl.'|thumb|'.$thumbUrl.'">';

        ?>
        <tr class="fForm_line">
            <td class="fImage"><?= $imageM ?></td>
            <td class="fName"><?= $insert ?></td>
            <td class="fShow"><?= $show ?></td>
            <td class="fOriginal"><?= $original ?></td>
            <td class="fSize"><?= $size ?></td>
            <td class="fCheck"><?= $input ?></td>
        </tr>
        <?php
        endforeach;
        // Файлы
        foreach($files as $file):
            /** @var $file common\models\ar\Files */
            $insert = '<a href="javascript:insertfile(\''.$file->id.'\')">'.$file->name.'</a>';
            $thumb = 0;
            $fileUrl = Yii::$app->params['frontendBaseUrl'].'uploads/'.$file->folder.'/'.$file->name;
            $filePath = Yii::getAlias(Yii::$app->params['admin']['uploadsPathAlias']).$file->folder.'/'.$file->name;
            $fileSize = Yii::$app->formatter->asSize(filesize($filePath));
            $fileExt = substr(strrchr($filePath, '.'), 1);
            $imageM = '<img src="/images/filetypes/'.$fileExt.'.png" width="40" height="40">';
            $insert = '<a href="javascript:insertfile(\''.$file->id.'\')">'.$file->name.'</a>';
            $show = '<a href="'.$fileUrl.'" target="_blank">Скачать</a>';
            $original = '';
            $input = $form->field($fModel, 'files[]')->checkbox(['value' => 'file|'.$file->id.'|'.$file->folder.'|'.$file->name, 'label' => false, 'uncheck' => null]);
            ?>
            <tr class="fForm_line">
                <td class="fImage"><?= $imageM ?></td>
                <td class="fName"><?= $insert ?></td>
                <td class="fShow"><?= $show ?></td>
                <td class="fOriginal"><?= $original ?></td>
                <td class="fSize"><?= $fileSize ?></td>
                <td class="fCheck"><?= $input ?></td>
            </tr>
            <?php
        endforeach;
        ?>
        <tr class="fForm_line">
            <td colspan="2">
            Выравнивать: <select name="imageAlign" id="imageAlign">
                            <option value="left">По левому</option>
                            <option value="right">По правому</option>
                            <option value="center">По центру</option>
                            <option value="none">Нет</option>
                        </select>
            </td>
            <td colspan="4" class="fActions">
                <div>C выбранными:</div><input type="button" value="Вставить" id="insert_checked" name="add_img"> <input type="submit" value="Удалить" name="del_img_file">
            </td>
        </tr>
        </table>
    </div>
<?php ActiveForm::end(); ?>