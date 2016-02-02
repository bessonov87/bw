<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\CommentForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if(!Yii::$app->user->isGuest):
?>
<div class="comment-add-box" id="addComment">
    <div class="comment-add-header">
        Есть что сказать? Добавьте свой комментарий к статье!
    </div>
    <div class="comment-add-form">
        <?php $form = ActiveForm::begin([
            'id' => 'comment-ad-form',
        ]); ?>
        <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'post_id')->hiddenInput()->label(false); ?>
        <?= $form->field($model, 'reply_to')->hiddenInput()->label(false); ?>

        <div class="form-line comm-text">
            <?= $form->field($model, 'text')->textarea()->label('Текст сообщения') ?>
            <?php var_dump(Yii::$app->params['comments']); ?>
            <span>Минимум: <?= Yii::$app->params['comments']['min_length'] ?> символов, Максимум: <?= Yii::$app->params['comments']['max_length'] ?> символов</span>
        </div>
        <div class="form-line">
            <div class="form-buttons">
                <button type="submit" name="submit_comment" value="register">
                    <i class="fa fa-arrow-circle-o-right"></i> Отправить
                </button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
<?php
endif;

if(Yii::$app->user->isGuest):
?>
<div class="comments-not-logged-box">
    <div class="comments-not-logged-header">У вас недостаточно прав для добавления комментариев</div>
    <div class="comments-not-logged-message">
        <span>Чтобы оставлять комментарии, вам необходимо <i class="fa fa-external-link"></i> <a href="#inline_login" class="fancybox">авторизоваться</a>.</span>
        <span>Если у вас еще нет учетной записи на нашем сайте, предлагаем <i class="fa fa-external-link"></i> <a href="#inline_register" class="fancybox">зарегистрироваться</a>.<br>Это займет не более 5 минут.</span>
    </div>
</div>
<?php
endif;
?>

<?php if(Yii::$app->session->hasFlash('comment-success')): ?>
    <div class="alert alert-success">
        Комментарий успешно добавлен. <a href="#comment-<?= Yii::$app->session->getFlash('comment-success') ?>">Перейти к добавленному комментарию</a>.
    </div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('comment-error')): ?>
    <div class="alert alert-error">
        При добавлении комментария произошла ошибка.
    </div>
<?php endif; ?>


<div style="display: none;">
    <div id="comment-reply">
        [isLogged]
        <h2>Ответ на комментарий #<span id="comm-id-span"></span></h2>
        <h3>Пользователя: <span id="comm-autor-span"></span></h3>
        <form method="post" id="reply-form">
            <input type="hidden" name="reply_id" id="reply-hidden" value="none">
            <input type="hidden" name="fcode" value="{fcode}">
            <input type="hidden" name="fid" value="{fid}">
            <div class="form-line">
                <textarea name="text" placeholder="Текст сообщения..." required="required"></textarea>
                <span>Минимум: <?= Yii::$app->params['comments']['min_lenght'] ?> символов, Максимум: {comm_max} символов</span>
            </div>
            <div class="form-line">
                <div class="form-buttons">
                    <button type="submit" name="submit_comment" value="register">
                        <i class="fa fa-arrow-circle-o-right"></i> Отправить
                    </button>
                    <button type="button" onclick="$.fancybox.close();">
                        <i class="fa fa-ban"></i> Отмена
                    </button>
                    <button type="button" onclick="clearForm('inline_login');" name="clear_form">
                        <i class="fa fa-times"></i> Очистить
                    </button>
                </div>
            </div>
        </form>
        [/isLogged]
        [notLogged]
        <div class="not-logged-message">
            <span>Для того, чтобы ответить на комментарий, вам необходимо <i class="fa fa-external-link"></i> <a href="#inline_login" class="fancybox">авторизоваться</a>.</span>
            <span>Если у вас еще нет учетной записи на нашем сайте, предлагаем <i class="fa fa-external-link"></i> <a href="#inline_register" class="fancybox">зарегистрироваться</a>.<br>Это займет не более 5 минут.</span>
        </div>
        [/notLogged]
    </div>
</div>
