<?php
namespace frontend\controllers;

use frontend\models\CommentForm;
use frontend\models\Post;
use Yii;
use yii\web\Controller;

class PostController extends Controller{

    public function actionShort()
    {
        $request = Yii::$app->request;
        $format = $request->get('format');
        if($format == 'byCat'){
            $title = 'Статьи раздела ' . $request->get('cat');
            $params = [
                'cat' => $request->get('cat'),
            ];
        }
        elseif($format == 'byDate'){
            $title = 'Статьи за ' . $request->get('year');
            $params = [
                'year' => $request->get('year'),
                'month' => $request->get('month'),
                'day' => $request->get('day'),
            ];
        }
        $params['page'] = $request->get('page');
        $params['title'] = $title;
        return $this->render('short', $params);
    }

    public function actionFull()
    {
        $request = Yii::$app->request;
        //$post = Post::find()->where(['id' => $request->get('id'), 'approve' => Post::APPROVED])->one();
        // или можно без approve
        //$post = Post::findOne($request->get('id'));
        // или
        $post = Post::findOne([
            'id' => $request->get('id'),
            'approve' => Post::APPROVED,
        ]);

        if(!Yii::$app->user->isGuest) {
            $model = new CommentForm();
            // Значение для hidden user_id
            $model->user_id = Yii::$app->user->identity->getId();
            $model->post_id = $post->id;
            if ($model->load(Yii::$app->request->post())) {
                if ($id = $model->addComment()) {
                    Yii::$app->session->setFlash('comment-success', $id);
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('comment-error');
                }
            }
        }

        return $this->render('full', ['post' => $post, 'model' => $model]);
    }

}