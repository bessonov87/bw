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
            $text = str_ireplace('skincaremask', 'beauty-women', $text, $replaced_count);

            $matches_count = 0;
            $pattern = '/\[link=([0-9]{1,3})\]/si';
            /*$text = preg_replace_callback($pattern, function ($matches) use(&$matches_count){
                //var_dump($matches);
                $matches_count += 1;
                $newId = 2857 + $matches[1];
                return '[link='.$newId.']';
            }, $text);*/

            preg_match_all($pattern, $text, $matches);

            var_dump($matches);

            if($test) {
                echo "********** ID: {$post->id}. Matches: {$matches_count}. Replaces: {$replaced_count}. TEXT: {$text}\n\n";
            }
        }
    }

    public function actionTest()
    {
        $text = '<p>Косметические отделы любого супермаркета сегодня буквально устелены огромным выбором готовых скрабов. Но мы не ищем легких путей. Мы будет готовить их сами. К тому же это сделать очень просто. А самым главным плюсом является то, что вы точно будете знать, что в вашем домашнем средстве применяются только натуральные ингредиенты, которые не навредят коже. Ниже ссылки на статьи с рецептами.</p>
<p>&nbsp;</p>
<p><a href="skraby-i-maski-iz-kofe.html">Домашние скрабы из молотого кофе и кофейной гущи</a></p>
<p><a href="skraby-iz-ovsjanki.html">Рецепты очищающих скрабов для лица из овсянки</a></p>
<p>&nbsp;</p>
<h2>Пилинг лица</h2>
<p><img class="si150" style="float: left; border: 0px;" title="Пилинг лица" src="http://beauty-women.ru/uploads/posts/2014-05/piling1_1400854077.jpg" alt="Пилинг лица" /></p>
<p>Как я уже описала выше, для [link=253]глубокого очищения[/link] кожи используются скрабы. А сама процедура использования скрабов называется <strong>пилингом лица</strong>. Сейчас я постараюсь как можно проще описать все действия, которые нужно выполнять для проведения правильного пилинга в домашних условиях.</p>
<p>&nbsp;</p>
<p>Для начала лицо нужно хорошо умыть. Для этого можно применить [link=327]соответствующий вашей коже[/link] тоник или лосьон. Далее нужно на влажную кожу лица нанести состав для пилинга (тот самый скраб) и аккуратно и нежно помассировать кожу лица кончиками пальцев. Самое важное в этой процедуре, не применять силы. Никакого фанатизма! Только нежные и максимально легкие движения. Это именно тот случай, когда лучше именно недоделать, чем переделать. Мы же не хотим остаться без лица.</p>
<p>&nbsp;</p>
<p><strong>Очень важный момент</strong>: не стоит применять пилинг на коже вокруг глаз.</p>
';
        $matches_count = 0;
        $pattern = '/\[link=([0-9]{1,3})\]/si';
        /*$text = preg_replace_callback($pattern, function ($matches) use(&$matches_count){
            //var_dump($matches);
            $matches_count += 1;
            $newId = 2857 + $matches[1];
            return '[link='.$newId.']';
        }, $text);*/

        preg_match_all($pattern, $text, $matches);

        var_dump($matches);

        echo "$matches_count \n\n";
        echo $text;
    }
}