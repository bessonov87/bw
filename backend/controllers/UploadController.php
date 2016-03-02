<?php

namespace backend\controllers;

use backend\models\DeleteFilesForm;
use common\models\ar\Files;
use common\models\ar\Images;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * Class UploadController Загрузка файлов
 * @package backend\controllers
 */
class UploadController extends Controller
{
    /**
     * @var string Layout name
     */
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

    /**
     * Отображает форму загрузки файлов и список загруженных для статьи файлов
     * @return string
     */
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

        $fModel = new DeleteFilesForm();
        if ($fModel->load(Yii::$app->request->post()) && $fModel->validate()){
            $fModel->delete();
        }

        $q = Images::find();
        if($post_id = Yii::$app->request->get('post_id')){
            $q->andWhere(['post_id' => $post_id]);
        } else {
            $q->andWhere(['r_id' => Yii::$app->request->get('r_id')]);
        }
        $images = $q->all();

        $q = Files::find();
        if($post_id){
            $q->andWhere(['post_id' => $post_id]);
        } else {
            $q->andWhere(['r_id' => Yii::$app->request->get('r_id')]);
        }
        $files = $q->all();


        return $this->render('index', ['model' => $model, 'fModel' => $fModel, 'images' => $images, 'files' => $files]);
    }
}