<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\MoonHair $moonHairModel
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\components\helpers\GlobalHelper;

$this->title = "Лунные календари стрижек";

$years[0] = 'Год ...';
for($i=2012;$i<=2020;$i++){
    $years[$i] = $i;
}

$js = <<<JS
$(function() {
    $(document).on('change', '#moon-years', function() {
        var year = parseInt($('#moon-years').val());
        $.pjax.reload({container: '#moon-hair', url: '?year='+year});
    });
});
JS;

$this->registerJs($js);

?>

<div style="background-color: #fff; padding: 10px;">
    <div class="row">
        <div class="col-md-2">
            <?= Html::dropDownList('moon-years', null, $years, ['class' => 'form-control', 'id' => 'moon-years']) ?>
        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-7"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <?php Pjax::begin([
                'id' => 'moon-hair'
            ]);
            ?>

            <div class="row">
                <div class="col-md-2" style="padding-right: 30px;">
                    <?= $months ?>
                </div>
                <div class="col-md-10" style="border-left: 1px #ccc solid;">
                    <?= $moonHairModel ? $this->render('hair-form', ['moonHairModel' => $moonHairModel]) : '' ?>
                </div>
            </div>

            <?php
            Pjax::end();
            ?>
        </div>
    </div>
</div>
