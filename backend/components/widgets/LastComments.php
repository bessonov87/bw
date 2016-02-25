<?php

namespace app\components\widgets;

use common\models\ar\Comment;
use Yii;
use yii\base\Widget;

/**
 * Class LastComments Виджет, выводящий последние комментарии на странице Dashboard
 * @package app\components\widgets
 */
class LastComments extends Widget
{
    public $commNum = 5;

    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('last-comments', [
            'comments' => $this->comments,
        ]);
    }

    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    public function getComments(){
        return Comment::find()->with('user')->orderBy(['date' => SORT_DESC])->limit($this->commNum)->all();
    }
}