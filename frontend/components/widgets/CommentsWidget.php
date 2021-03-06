<?php
namespace app\components\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * CommentsWidget выводит дерево комментариев
 *
 * Выборка комментариев производится при выборке статьи, сюда они передаются с помощью параметра comments.
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class CommentsWidget extends Widget
{
    /**
     * @var array комментарии
     */
    public $comments;
    /**
     * @var object frontend\models\form\CommentForm
     */
    public $addCommModel;
    /**
     * @var int шаг вложенности в дереве комментариев
     */
    private $_treeStep;

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/post';
    }

    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run(){
        if(!is_array($this->comments)) return '';
        // Переиндексируем комментарии относительно id комментария, на который данный отвечает
        $comments_array = '';
        foreach($this->comments as $comm){
            $reply_to = (is_null($comm['reply_to'])) ? 0 : $comm['reply_to'];
            $comments_array[$reply_to][] = $comm;
        }
        $comments = $this->render('comment_add', ['model' => $this->addCommModel]);
        if(is_array($comments_array)){
            $comments .= $this->getCommentTree($comments_array);
        }
        return $comments;
    }

    /**
     * Получаем дерево комментариев
     *
     * @param $comments_array
     * @param int $reply
     * @return string
     */
    public function getCommentTree($comments_array, $reply = 0){
       $this->_treeStep += 1;
        $comments = '';
        // Перебираем все комментарии, которые не являются ответными
        foreach ($comments_array[$reply] as $comment) {
            if($this->_treeStep != 1 && $this->_treeStep <= \Yii::$app->params['comments']['max_nesting']){
                $comments .= '<div class="comment-reply-arrow comment-reply-arrow-5"><i class="fa fa-reply"></i></div>';
            } else if($this->_treeStep > \Yii::$app->params['comments']['max_nesting']) {
                $comments .= '<div class="comment-reply-arrow comment-reply-arrow-abs"><i class="fa fa-reply"></i></div>';
            }
            // Если комментарий ответный, смещаем его относительно верхнего влево (на вложенности > ['comments']['max_nesting'] не смещаем)
            if($this->_treeStep != 1 && $this->_treeStep <= \Yii::$app->params['comments']['max_nesting']) {
                $comments .= '<div class="comment-item comment-item-95" id="comment-'.$comment['id'].'">';
            } else {
                $comments .= '<div class="comment-item" id="comment-'.$comment['id'].'">';
            }
            $comments .= $this->render('comment', ['comment' => $comment]);
            // Если есть ответные
            if(!empty($comments_array[$comment['id']])){
                $comments .= '<div class="reply-comments" id="reply-comments-'.$comment['id'].'">';
                $comments .= $this->getCommentTree($comments_array, $comment['id']);
                $comments .= '<div class="clear"></div>';
                $comments .= '</div>';
            }
            $comments .= '</div>';
            if($reply == 0) $this->_treeStep = 1;
            $comments .= '<div class="clear"></div>';
        }
        return $comments;
    }
}