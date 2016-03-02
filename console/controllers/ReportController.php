<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\components\helpers\GlobalHelper;
use common\models\ar\User;

class ReportController extends Controller
{
    public function actionIndex(){
        $this->stdout('It works!', Console::FG_YELLOW);
        return 0;
    }

    public function actionSend() {
        $siteSummary = GlobalHelper::getSiteSummary();
        $summaryInfo = '<h3>Отчет за '.date('d.m.Y').'</h3>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Статьи</h4>';
        $summaryInfo .= '<p>Всего: '.$siteSummary['postsCount'].'</p>';
        $summaryInfo .= '<p>Сегодня: '.$siteSummary['postsToday'].'</p>';
        $summaryInfo .= '<p>Вчера: '.$siteSummary['postsYesterday'].'</p>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Пользователи</h4>';
        $summaryInfo .= '<p>Всего: '.$siteSummary['usersCount'].'</p>';
        $summaryInfo .= '<p>Сегодня: '.$siteSummary['usersToday'].'</p>';
        $summaryInfo .= '<p>Вчера: '.$siteSummary['usersYesterday'].'</p>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Комментарии</h4>';
        $summaryInfo .= '<p>Всего: '.$siteSummary['commentsCount'].'</p>';
        $summaryInfo .= '<p>Сегодня: '.$siteSummary['commentsToday'].'</p>';
        $summaryInfo .= '<p>Вчера: '.$siteSummary['commentsYesterday'].'</p>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Ошибки</h4>';
        $summaryInfo .= '<p>Всего: '.$siteSummary['errorsCount'].'</p>';
        $summaryInfo .= '<p>Сегодня: '.$siteSummary['errorsToday'].'</p>';
        $summaryInfo .= '<p>Вчера: '.$siteSummary['errorsYesterday'].'</p>';

        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo(Yii::$app->params['feedbackEmail'])
            ->setSubject('Отчет за '.date('d.m.Y'))
            ->setHtmlBody($summaryInfo)
            ->send();

        return 0;
    }
}