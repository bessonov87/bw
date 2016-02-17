<?php

/* @var $this yii\web\View */
use common\components\helpers\GlobalHelper;
?>

<?php
$allCategories = GlobalHelper::getCategories();
foreach($categories as $categoryId):
    // Получаем Url категории по ее ID
    $cat = GlobalHelper::getCategoryUrlById($categoryId);
    $link = '/'.$cat.'/';
    ?>
    <div id="content-item">
        <div id="content-item-top" class="content-item-blue black_link"><span>Подраздел</span> <a href="<?= $link ?>"><?= $allCategories[$categoryId]['name'] ?></a></div>
        <div id="content-item-content">
            <div id="content-small-10" class="img120">
                <?= $allCategories[$categoryId]['description'] ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php
endforeach;
?>
