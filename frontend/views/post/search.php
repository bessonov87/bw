<?php

/** @var \yii\data\Pagination $pages */
/** @var \frontend\models\Post $post */

//use yii\jui\DatePicker;
//use yii\widgets\LinkPager;
use app\components\MyLinkPager;
//use Yii;
use yii\helpers\Html;
use app\components\widgets\SearchWidget;

$this->title = 'Поиск по сайту';
// Если задана поисковая фраза
if($searchPhrase = Yii::$app->request->post('story')){
    $this->title .= ': ' . Html::encode($searchPhrase);
}
?>


<?php
// Выводим поисковую форму
echo SearchWidget::widget(['full' => true]);

if(!$posts) {
    $posts = [];
    echo 'Не найдено';
}

foreach($posts as $post):
?>
    <div id="content-item">
        <div id="content-item-top" class="content-item-pink"><a href="<?= $post->link ?>"><?= $post->title ?></a></div>
        <div id="content-item-content">
            <div id="content-small-10">
                <?= $post->short ?>
            </div>
            <div class="clear"></div>
            <div id="content-item-footer">
                <div class="content-item-footer-left"><strong>Добавлено:</strong> <?= $post->date ?> | <strong>Просмотров:</strong> <?=$post->views?></div>
                <div class="content-item-footer-right"><a href="<?= $post->link ?>">Подробнее >></a></div>
            </div>
        </div>
    </div>
<?php
endforeach;