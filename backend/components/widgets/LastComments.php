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
    /**
     * @var int количество комментариев, выводящихся в блоке, по умолчанию
     */
    public $commNum = 5;

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
        return $this->render('last-comments', [
            'comments' => $this->comments,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    /**
     * Возвращает последние commNum комментариев из таблицы comment
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getComments(){
        return Comment::find()->with('user')->orderBy(['date' => SORT_DESC])->limit($this->commNum)->all();
    }
}