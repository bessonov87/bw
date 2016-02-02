<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\SimilarPostsWidget;
use app\components\GlobalHelper;
use app\components\CommentsWidget;
use app\components\RatingWidget;
use app\components\FavoriteWidget;

foreach(GlobalHelper::getCategoryBreadcrumb(Yii::$app->params['category'][0]) as $cBreadcrumb) {
    $this->params['breadcrumbs'][] = ['label' => Html::a($cBreadcrumb['label'], $cBreadcrumb['link']), 'encode' => false];
}
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
<div id="post-id"><?=$post->id?></div>
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
                    <span><strong>Размер текста:</strong></span>
                    <div class="text_size_imgs">
                        <div class="img_container" onclick="$('#art_full').css('font-size', '12px')"><img alt="Мелкий" title="Мелкий" src="/bw15/images/font32.png" width="12"></div>&nbsp;&nbsp;
                        <div class="img_container" onclick="$('#art_full').css('font-size', '14px')"><img alt="Средний" title="Средний" src="/bw15/images/font32.png" width="18"></div>&nbsp;&nbsp;
                        <div class="img_container" onclick="$('#art_full').css('font-size', '16px')"><img alt="Крупный" title="Крупный" src="/bw15/images/font32.png" width="24"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div align="justify" style="color:#000000; font-size:14px; line-height: 1.5;" id="art_full"><?=$post->full?></div>
            <div class="related_posts">
                <strong>Другие публикации по теме:</strong><br/><?=SimilarPostsWidget::widget(['posts' => $post->similarPosts, 'list' => true, 'listType' => 'ol'])?>
            </div>
        </div>
        <div class="clear"></div>
        <div id="content-item-rating">
            <div class="content-item-rating-1"><?= RatingWidget::widget(['post_id' => $post->id]) ?></div>
            <div class="content-item-favorite"><?= FavoriteWidget::widget(['post_id' => $post->id]) ?></div>
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
