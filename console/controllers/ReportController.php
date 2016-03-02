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
        $summaryInfo .= 'Всего: '.$siteSummary['postsCount'].'<br>';
        $summaryInfo .= 'Сегодня: '.$siteSummary['postsToday'].'<br>';
        $summaryInfo .= 'Вчера: '.$siteSummary['postsYesterday'].'<br>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Пользователи</h4>';
        $summaryInfo .= 'Всего: '.$siteSummary['usersCount'].'<br>';
        $summaryInfo .= 'Сегодня: '.$siteSummary['usersToday'].'<br>';
        $summaryInfo .= 'Вчера: '.$siteSummary['usersYesterday'].'<br>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Комментарии</h4>';
        $summaryInfo .= 'Всего: '.$siteSummary['commentsCount'].'<br>';
        $summaryInfo .= 'Сегодня: '.$siteSummary['commentsToday'].'<br>';
        $summaryInfo .= 'Вчера: '.$siteSummary['commentsYesterday'].'<br>';
        $summaryInfo .= '<hr>';
        $summaryInfo .= '<h4>Ошибки</h4>';
        $summaryInfo .= 'Всего: '.$siteSummary['errorsCount'].'<br>';
        $summaryInfo .= 'Сегодня: '.$siteSummary['errorsToday'].'<br>';
        $summaryInfo .= 'Вчера: '.$siteSummary['errorsYesterday'].'<br>';

        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo(Yii::$app->params['feedbackEmail'])
            ->setSubject('Отчет за '.date('d.m.Y'))
            ->setHtmlBody($summaryInfo)
            ->send();

        return 0;
    }
}