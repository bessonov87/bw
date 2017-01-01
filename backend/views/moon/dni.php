<?php

/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use common\components\helpers\GlobalHelper;

$this->title = "Дни лунного календаря";

$years[0] = 'Год ...';
for($i=2012;$i<=2020;$i++){
    $years[$i] = $i;
}
$months = [];
$months[0] = 'Месяц ...';
for($i=1;$i<=12;$i++){
    $months[$i] = GlobalHelper::ucfirst(GlobalHelper::rusMonth($i));
}

$js = <<<JS
$(function() {
    $(document).on('change', '#moon-years, #moon-months', function() {
        updatePjax();
    });
    
    function updatePjax() {
        var year = parseInt($('#moon-years').val());
        var month = parseInt($('#moon-months').val());
        
        if(year && month){
            console.log(year + ' ' + month);
            $.pjax.reload({container: '#moon-dni', url: '?year='+year+'&month='+month});
        }
    }
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
            <?= Html::dropDownList('moon-months', null, $months, ['class' => 'form-control', 'id' => 'moon-months']) ?>
        </div>
        <div class="col-md-7"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <?php Pjax::begin([
                'id' => 'moon-dni'
            ]);
            ?>

            <div class="row">
                <div class="col-md-3" style="padding-right: 30px;">
                    <?= $calendar ?>
                </div>
                <div class="col-md-9" style="border-left: 1px #ccc solid;">
                    <?= $dayForm ?>
                </div>
            </div>

            <?php
            Pjax::end();
            ?>
        </div>
    </div>
</div>