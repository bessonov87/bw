<?php
/** @var $this yii\web\View */
//echo count($comments);
?>
<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>
        <h3 class="box-title">Последние комментарии</h3>
    </div>
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;"><div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto;">
            <?php
            foreach($comments as $comment):
                /** @var $comment common\models\ar\Comment */
                //$avatar = Yii::$app->params['frontendBaseUrl'].substr($comment->user->avatar, 1);
                $avatar = '';
                var_dump($comment->user->getAvatar());
            ?>
            <!-- chat item -->
            <div class="item">
                <img src="<?= $avatar ?>" alt="user image" class="online">

                <p class="message">
                    <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?= $comment->date ?></small>
                        <?= $comment->user->username ?>
                    </a>
                    <?= $comment->text ?>
                </p>
            </div>
            <!-- /.item -->
            <?php
            endforeach;
            ?>

        </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 184.911px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
    <!-- /.chat -->
</div>