<?php

/* @var $this yii\web\View */

use yii\helpers\ArrayHelper;
use app\components\PostHelper;
use app\components\CommentsWidget;
use app\components\RatingWidget;

$this->params['breadcrumbs'][] = $post->title;

// Проверяем, добавлены ли мета-тэги и включаем их в код страницы
if($post->meta_keywords){
    $this->registerMetaTag(['name' => 'keywords', 'content' => $post->meta_keywords], 'keywords');
}
if($post->meta_descr){
    $this->registerMetaTag(['name' => 'description', 'content' => $post->meta_descr], 'description');
}
if($post->meta_title){
    $this->title = $post->meta_title;
} else {
    $this->title = $post->title;
}
?>
<div id="content-item">
    <div id="content-item-top" class="content-item-pink"><h1><?=$post->title?></h1></div>
    <div id="content-item-content">
        <div id="content-full-10">
            <div class="g_ads_link">
                <script type="text/javascript"><!--
                    google_ad_client = "ca-pub-6721896084353188";
                    /* Beauty-link */
                    google_ad_slot = "2882923549";
                    google_ad_width = 468;
                    google_ad_height = 15;
                    //-->
                </script>
                <script type="text/javascript"
                        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                </script>
            </div>
            <div id="content-full-instruments">
                <div class="social-top">
                    Поделиться с друзьями:
                    <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="small" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus" data-yashareTheme="counter"></div>
                </div>
                <div class="text-size">
                    <div style="line-height:2; font-size: 14px;"><strong>Размер текста:</strong></div>
                    <div style="display:inline-block; cursor:pointer" onclick="$('#art_full').css('font-size', '12px')"><img alt="Мелкий" title="Мелкий" src="/bw15/images/font32.png" width="12"></div>&nbsp;&nbsp;
                    <div style="display:inline-block; cursor:pointer" onclick="$('#art_full').css('font-size', '14px')"><img alt="Средний" title="Средний" src="/bw15/images/font32.png" width="18"></div>&nbsp;&nbsp;
                    <div style="display:inline-block; cursor:pointer" onclick="$('#art_full').css('font-size', '16px')"><img alt="Крупный" title="Крупный" src="/bw15/images/font32.png" width="24"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div align="justify" style="color:#000000; font-size:14px; line-height: 1.5;" id="art_full"><?=$post->full?></div>
            <div class="related">
                <strong>Другие публикации по теме:</strong><br/><?=PostHelper::similar($post->similarPosts, ['list' => true, 'listType' => 'ol'])?>
            </div>
        </div>
        <div class="clear"></div>
        <div id="content-item-rating">
            <div class="content-item-rating-1"><?= RatingWidget::widget(['post_id' => $post->id]) ?></div>
            <div class="content-item-favorit">{art_to_favorit}</div>
        </div>
        <div class="clear"></div>
        <div id="content-item-footer">
            <div style="color:#333; font-size:14px"><strong>Статья добавлена:</strong> <?=$post->date?> | <strong>Комментарии</strong> (<a href="#all-comments"><?= count($post->comments) ?></a>) | <strong>Просмотров:</strong> <?=$post->views?></div>
        </div>
    </div>
</div>

<div id="all-comments">
    <?= CommentsWidget::widget(['comments' => $post->comments, 'addCommModel' => $model]) ?>
</div>

<? var_dump($post->categories); ?>
<? var_dump($post->postsRating); ?>
<? //var_dump(ArrayHelper::toArray($post->comments)); ?>
<? //var_dump($post->comments); ?>
