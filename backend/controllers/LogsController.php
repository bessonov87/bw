<?php

namespace backend\controllers;

use Yii;
use backend\models\Log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * Class LogsController
 * @package backend\controllers
 */
class LogsController extends Controller
{
    /**
     * @var string действие по умолчанию
     */
    public $defaultAction = 'db';

    /**
     * Lists all Advert models.
     * @return mixed
     */
    public function actionDb()
    {
        $query = Log::find();
        // Если задан интервал
        if($interval = Yii::$app->request->get('interval')){
            switch($interval){
                case 'today': $query->andWhere(['>=', 'log_time', strtotime(date('Y-m-d').' 00:00:00')]); break;
                case 'hour': $query->andWhere(['>=', 'log_time', strtotime(date('Y-m-d H:i:s')) - 3600]); break;
            }
        }
        // Постраничная навигация
        $countPosts = clone $query;
        $pages = new Pagination(['totalCount' => $countPosts->count(), 'route' => 'logs/db']);
        $messages = $query->offset($pages->offset)
            ->orderBy(['log_time' => SORT_DESC])
            ->limit($pages->limit)
            ->all();
        return $this->render('db', ['messages' => $messages, 'pages' => $pages]);
    }
}