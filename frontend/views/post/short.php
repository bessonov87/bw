<?php

/** @var \yii\data\Pagination $pages */

use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use app\components\MyLinkPager;
use yii\helpers\Url;
use app\components\GlobalHelper;

if($pages->page >0 || array_key_exists('category', Yii::$app->params)){
    $this->title = Yii::$app->params['site']['shortTitle'];
}else{
    $this->title = Yii::$app->params['site']['title'];
}
// Если не первая страница, добавляем в начало <title>
if($pages->page > 0) $this->title = 'Страница '. ($pages->page + 1) . '. ' . $this->title;
// Если задана категория, добавляем в начало <title> имя категории
if(Yii::$app->params['category']){
    $catName = GlobalHelper::getCategories()[Yii::$app->params['category'][0]]['name'];
    $this->title = $catName . ' - ' . $this->title;
}
// Если задана дата
if(Yii::$app->params['date']){
    $this->title = 'Статьи за ' . Yii::$app->params['date'] . ' - ' . $this->title;
}
?>


<?php
// Если заданы подкатегории, которые выводятся на первых страницах категорий, выводим их перед анонсами статей
if($subCategories){
    echo $subCategories;
}

foreach($posts as $post):
    /*$thisCategory = $categories[$post->postCategories[0]->category_id];
    // Если есть родительская, ссылка на раздел будет составной, иначе только url данной категории
    $cat = ($thisCategory['parent_id']) ? $categories[$thisCategory['parent_id']]['url'].'/'.$thisCategory['url'] : $thisCategory['url'];*/
    // Получаем Url категории по ее ID
    $cat = GlobalHelper::getCategoryUrlById($post->postCategories[0]->category_id);
    $link = Url::to(['post/full', 'cat' => $cat, 'id' => $post->id, 'alt' => $post->url]);
?>
    <div id="content-item">
        <div id="content-item-top" class="content-item-pink"><a href="<?= $link ?>"><?= $post->title ?></a></div>
        <div id="content-item-content">
            <div id="content-small-10">
                <?= $post->short ?>
            </div>
            <div class="clear"></div>
            <div id="content-item-footer">
                <div class="content-item-footer-left"><strong>Добавлено:</strong> <?= $post->date ?> | <strong>Просмотров:</strong> <?=$post->views?></div>
                <div class="content-item-footer-right"><a href="<?= $link ?>">Подробнее >></a></div>
            </div>
        </div>
    </div>
<?php
endforeach;
?>


<?

echo MyLinkPager::widget(['pagination' => $pages, 'cat' => Yii::$app->params['category']]);

/*echo DatePicker::widget([
    'language' => 'ru',
    'name' => 'country',
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
    ]
]);*/
?>