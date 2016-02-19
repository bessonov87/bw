<?php
/** @var $this \yii\base\View */
/** @var $summary array */
?>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-file-text-o"></i></span>

        <div class="info-box-content">
            <span class="info-box-text"><a href="/post/index">Статьи</a></span>
            <span class="info-box-number"><?= $summary['postsCount'] ?></span>
            <span class="info-box-today">Сегодня: <?= $summary['postsToday'] ?></span>
            <span class="info-box-today">Вчера: <?= $summary['postsYesterday'] ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text"><a href="/user/index">Пользователи</a></span>
            <span class="info-box-number"><?= $summary['usersCount'] ?></span>
            <span class="info-box-today">Сегодня: <?= $summary['usersToday'] ?></span>
            <span class="info-box-today">Вчера: <?= $summary['usersYesterday'] ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->

<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-comments-o"></i></span>

        <div class="info-box-content">
            <span class="info-box-text"><a href="/comment/index">Комментарии</a></span>
            <span class="info-box-number"><?= $summary['commentsCount'] ?></span>
            <span class="info-box-today">Сегодня: <?= $summary['commentsToday'] ?></span>
            <span class="info-box-today">Вчера: <?= $summary['commentsYesterday'] ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
<div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-times-circle"></i></span>

        <div class="info-box-content">
            <span class="info-box-text"><a href="/logs/db">Ошибки</a></span>
            <span class="info-box-number"><?= $summary['errorsCount'] ?></span>
            <span class="info-box-today">Сегодня: <?= $summary['errorsToday'] ?></span>
            <span class="info-box-today">Вчера: <?= $summary['errorsYesterday'] ?></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
</div>
<!-- /.col -->
