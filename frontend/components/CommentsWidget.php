<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class CommentsWidget extends Widget
{
    public $comments;
    public $addCommModel;

    public function getViewPath(){
        return '@app/views/post';
    }

    public function init(){
        parent::init();
    }

    public function run(){
        if(!is_array($this->comments)) return '***';
        $comments = $this->render('comment_add', ['model' => $this->addCommModel]);
        foreach($this->comments as $comment){
            $comments .= $this->render('comment', ['comment' => $comment]);
        }
        return $comments;
    }
}