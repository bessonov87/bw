<?php

/* @var $this yii\web\View */
/* @var $post common\models\ar\Post */

use yii\helpers\Html;
use app\components\widgets\SimilarPostsWidget;
use common\components\helpers\GlobalHelper;
use app\components\widgets\CommentsWidget;
use app\components\widgets\RatingWidget;
use app\components\widgets\FavoriteWidget;

?>
<div id="post-id"><?= isset($options['id']) && $options['id'] ? $options['id'] : '' ?></div>
<div id="content-item">
    <div id="content-item-top" class="content-item-pink"><h1><?=$options['title']?></h1></div>
    <div id="content-item-content" style="margin-bottom: 15px;">
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
                        src="//pagead2.googlesyndication.com/pagead/show_ads.js">
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
            <div align="justify" style="color:#000000; font-size:14px; line-height: 1.5;" id="art_full">
                <?=GlobalHelper::insertAdvert($options['content'])?>
                <p>&nbsp;</p>
                <?php if(isset($options['similar']) && is_array($options['similar'])): ?>
                    <div class="related_posts">
                        <strong>Другие публикации по теме:</strong><br/><?=SimilarPostsWidget::widget(['links' => $options['similar'], 'list' => true, 'listType' => 'ol'])?>
                    </div>
                <?php endif; ?>
                <?= \app\components\widgets\SocialButtonsWidget::widget() ?>
                <?= isset($options['advert']) && $options['advert'] == false ? '' : \app\components\widgets\AdvertWidget::widget(['block_number' => 7]) ?>

            </div>
        </div>
        <div class="clear"></div>
        <div id="content-item-rating">
            <div class="content-item-rating-1"><?= RatingWidget::widget($options['ratingFav']) ?></div>
            <div class="content-item-favorite"><?= FavoriteWidget::widget($options['ratingFav']) ?></div>
        </div>
        <div class="clear"></div>
        <?php if(isset($options['footer']) && $options['footer']): ?>
        <div id="content-item-footer">
            <div style="color:#333; font-size:14px">
                <?php if(isset($options['footer']['date']) && $options['footer']['date']){ echo '<strong>Статья добавлена:</strong> '.date('d.m.Y H:i', $options['footer']['date']); } ?>
                <?php if(isset($options['comments']) && is_array($options['comments'])){ echo '| <strong>Комментарии</strong> (<a href="#all-comments">'.count($options['comments']).'</a>)'; } ?>
                <?php if(isset($options['footer']['views'])){ echo '| <strong>Просмотров:</strong> '.$options['footer']['views']; } ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if(isset($options['comments']) && $options['comments']): ?>
<div id="all-comments">
    <?= CommentsWidget::widget(['comments' => $options['comments']]) ?>
</div>
<?php endif; ?>