<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class UploadController extends Controller
{
    public $layout = 'main-upload';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        /*$post_id = Yii::$app->request->get('post_id');
        var_dump($post_id);
        var_dump(Yii::$app->request->cookies->getValue('r_id'));*/
        $model = new UploadForm();
        if ($model->load(Yii::$app->request->post())){
            $model->files = UploadedFile::getInstances($model, 'files');
            if($model->validate()) {
                $model->upload();
            }
        } else {
            $model->create_thumb = Yii::$app->params['admin']['images']['create_thumb'] ? 1 : 0;
            $model->watermark = Yii::$app->params['admin']['images']['watermark'] ? 1 : 0;
            $model->max_pixel_side = Yii::$app->params['admin']['images']['max_pixel_side'];
        }
        return $this->render('index', ['model' => $model]);
    }
}