<?php

namespace app\components\widgets;

use backend\models\Log;
use common\models\ar\Comment;
use common\models\ar\Post;
use common\models\ar\User;
use Yii;
use yii\base\Widget;

/**
 * Class SiteSummary Виджет, выводит информацию о статьях, пользователях, комментариях и ошибках
 * @package app\components\widgets
 */
class SiteSummary extends Widget
{
    public function init(){
        parent::init();
    }

    public function run(){
        return $this->render('site-summary', ['summary' => $this->summary]);
    }

    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    /**
     * Получение информации о статьях, пользователях, комментариях и ошибках из базы данных
     * @return mixed
     */
    public function getSummary(){
        $today_begin = date("Y-m-d")." 00:00:00";
        $today_end = date("Y-m-d")." 23:59:59";
        $yesterday_begin = date("Y-m-d 00:00:00", time()-86400);
        $yesterday_end = date("Y-m-d 23:59:59", time()-86400);
        // Статьи
        $summary['postsCount'] = Post::find()->count();
        $summary['postsToday'] = Post::find()->where(['between', 'date', $today_begin, $today_end])->count();
        $summary['postsYesterday'] = Post::find()->where(['between', 'date', $yesterday_begin, $yesterday_end])->count();
        // Пользователи
        $summary['usersCount'] = User::find()->count();
        $summary['usersToday'] = User::find()->where(['between', 'created_at', strtotime($today_begin), strtotime($today_end)])->count();
        $summary['usersYesterday'] = User::find()->where(['between', 'created_at', strtotime($yesterday_begin), strtotime($yesterday_end)])->count();
        // Комментарии
        $summary['commentsCount'] = Comment::find()->count();
        $summary['commentsToday'] = Comment::find()->where(['between', 'date', $today_begin, $today_end])->count();
        $summary['commentsYesterday'] = Comment::find()->where(['between', 'date', $yesterday_begin, $yesterday_end])->count();
        // Ошибки
        $summary['errorsCount'] = Log::find()->count();
        $summary['errorsToday'] = Log::find()->where(['between', 'log_time', strtotime($today_begin), strtotime($today_end)])->count();
        $summary['errorsYesterday'] = Log::find()->where(['between', 'log_time', strtotime($yesterday_begin), strtotime($yesterday_end)])->count();

        return $summary;

    }
}