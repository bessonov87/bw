<?php

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;
use common\models\ar\Post;

class JobController extends Controller
{
    public function actionDo($test = 1, $count = 1)
    {
        $posts = Post::find()
            ->where(['approve' => Post::NOT_APPROVED])
            ->andWhere(['between', 'id', 2858, 3211])
            ->limit($count)
            ->all();

        foreach ($posts as $post){
            /** @var Post $post */
            $text = $post->full;
            $text = str_ireplace('skincaremask', 'beauty-women', $text);

            $pattern = '/\[link=([0-9]{1,3})\]/si';
            $text = preg_replace_callback($pattern, function ($matches){
                var_dump($matches);
            }, $text);

            if($test) {
                echo "********** TEXT: {$text}\n\n";
            }
        }
    }
}