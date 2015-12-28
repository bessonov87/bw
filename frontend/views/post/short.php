<?php

/** @var \yii\data\Pagination $pages */

use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = Yii::$app->params['site']['title'];
if($pages->page > 0) $this->title .= ' . Страница '. ($pages->page + 1);
?>


<?php

foreach($posts as $post):
    $thisCategory = $categories[$post->postCategories[0]->category_id];
    // Если есть родительская, ссылка на раздел будет составной, иначе только url данной категории
    $cat = ($thisCategory['parent_id']) ? $categories[$thisCategory['parent_id']]['url'].'/'.$thisCategory['url'] : $thisCategory['url'];
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
                <div class="content-item-footer-left"><strong>Добавлено:</strong> <?= $post->date ?> | <strong>Просмотров:</strong> {news_read}</div>
                <div class="content-item-footer-right"><a href="<?= $link ?>">Подробнее >></a></div>
            </div>
        </div>
    </div>
<?php
endforeach;
?>


<?

echo LinkPager::widget(['pagination' => $pages]);

/*echo DatePicker::widget([
    'language' => 'ru',
    'name' => 'country',
    'clientOptions' => [
        'dateFormat' => 'yy-mm-dd',
    ]
]);*/
?>