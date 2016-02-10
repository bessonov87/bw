<?php

namespace backend\controllers;

use Yii;
use backend\models\Log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LogsController extends Controller
{
    public $defaultAction = 'db';

    /**
     * Lists all Advert models.
     * @return mixed
     */
    public function actionDb()
    {
        $messages = Log::find()->orderBy(['log_time' => SORT_DESC])->all();
        return $this->render('db', ['messages' => $messages]);
    }
}