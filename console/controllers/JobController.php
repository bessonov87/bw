<?php

namespace console\controllers;

use common\models\ar\Advert;
use common\models\ar\Auth;
use common\models\ar\Category;
use common\models\ar\Comment;
use common\models\ar\Countries;
use common\models\ar\FavoritePosts;
use common\models\ar\Images;
use common\models\ar\MoonCal;
use common\models\ar\PostCategory;
use common\models\ar\PostsRating;
use common\models\ar\User;
use common\models\ar\UserProfile;
use common\models\elastic\PostElastic;
use common\models\MoonDni;
use common\models\MoonFazy;
use common\models\MoonHair;
use common\models\MoonOgorod;
use common\models\MoonZnaki;
use yii\console\Controller;
use yii\db\Connection;
use yii\helpers\Console;
use common\models\ar\Post;

class JobController extends Controller
{

    public function actionCreateIndex()
    {
        $posts = Post::find()->where(['approve' => 1]);

        $x = 0;
        $y = 0;
        $time = time();
        foreach ($posts->each() as $post){
            /** @var Post $post */
            $elasticPost = PostElastic::findOne(['post_id' => $post->id]);
            if(!$elasticPost) {
                $elasticPost = new PostElastic();
            }
            $elasticPost->post_id = $post->id;
            $elasticPost->category_id = $post->category_id;
            $elasticPost->title = $post->title;
            $elasticPost->short = strip_tags($post->short);
            $elasticPost->full = strip_tags($post->full);
            $elasticPost->date = $post->date;
            $elasticPost->views = $post->views;

            if(!$elasticPost->save()){
                echo "CAN NOT SAVE POST {$post->id}\n";
                $y++;
            } else {
                $x++;
            }
        }
        $time = time() - $time;
        echo "Total: $x posts saved, $y posts not saved. Time spent: $time seconds\n";
    }

    public function actionTestIndex()
    {
        $post = Post::find()->limit(1)->one();

        $elasticPost = PostElastic::findOne(['post_id' => 4]);
        if(!$elasticPost) {
            $elasticPost = new PostElastic();
        }
        $elasticPost->post_id = $post->id;
        $elasticPost->category_id = $post->category_id;
        $elasticPost->title = $post->title;
        $elasticPost->short = strip_tags($post->short);
        $elasticPost->full = strip_tags($post->full);
        $elasticPost->date = $post->date;
        $elasticPost->views = $post->views;

        if($elasticPost->save()){
            echo "SAVED\n";
        }

    }

    public function actionTransfer()
    {
        $this->actionTransferCategory();
        $this->actionTransferUser();
        $this->actionTransferAdvert();
        $this->actionTransferPost();
        $this->actionTransferAuth();
        $this->actionTransferComment();
        $this->actionTransferCountries();
        $this->actionTransferFavPosts();
        $this->actionTransferImages();
        $this->actionTransferMoonCal();
        $this->actionTransferMoonDni();
        $this->actionTransferMoonFazy();
        $this->actionTransferMoonHair();
        $this->actionTransferMoonOgorod();
        $this->actionTransferMoonZnaki();
        $this->actionTransferPostsRating();
        $this->actionTransferPostCategory();
        $this->actionTransferUserProfile();
    }

    public function actionTransferAdvert()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Advert::deleteAll();

        $adverts = $oldDb->createCommand('SELECT * FROM bw_advert')->queryAll();
        foreach ($adverts as $advert){
            $pgAdvert = new Advert();
            $pgAdvert->id = intval($advert['id']);
            $pgAdvert->title = $advert['title'];
            $pgAdvert->block_number = intval($advert['block_number']);
            $pgAdvert->code = $advert['code'];
            $pgAdvert->location = $advert['location'];
            $pgAdvert->replacement_tag = $advert['replacement_tag'];
            $pgAdvert->category = intval($advert['category']);
            $pgAdvert->approve = intval($advert['approve']);
            $pgAdvert->on_request = intval($advert['on_request']);
            if(!$pgAdvert->save()){
                echo "Can not save Advert {$advert['id']}. Error: ".json_encode($pgAdvert->getErrors());
            }
        }
    }

    public function actionTransferCategory()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Category::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_category')->queryAll();
        foreach ($rows as $row){
            $pgModel = new Category();
            $pgModel->id = intval($row['id']);
            $pgModel->parent_id = intval($row['parent_id']);
            $pgModel->name = $row['name'];
            $pgModel->url = $row['url'];
            if($row['icon']) $pgModel->icon = $row['icon'];
            if($row['description']) $pgModel->description = $row['description'];
            if($row['meta_title']) $pgModel->meta_title = $row['meta_title'];
            if($row['meta_descr']) $pgModel->meta_descr = $row['meta_descr'];
            if($row['meta_keywords']) $pgModel->meta_keywords = $row['meta_keywords'];
            if($row['post_sort']) $pgModel->post_sort = $row['post_sort'];
            $pgModel->post_num = intval($row['post_num']);
            if($row['short_view']) $pgModel->short_view = $row['short_view'];
            if($row['full_view']) $pgModel->full_view = $row['full_view'];
            $pgModel->category_art = intval($row['category_art']);
            if($row['header']) $pgModel->header = $row['header'];
            if($row['footer']) $pgModel->footer = $row['footer'];
            if($row['add_method']) $pgModel->add_method = $row['add_method'];
            if(!$pgModel->save()){
                echo "Can not save Category {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferUser()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        echo "Go to 'user'\n";
        User::deleteAll();
        echo "all data deleted ...\n";

        $rows = $oldDb->createCommand('SELECT * FROM bw_user')->queryAll();
        foreach ($rows as $row){
            $pgModel = new User();
            $pgModel->detachBehavior('timestamp');
            $pgModel->id = intval($row['id']);
            $pgModel->username = $row['username'];
            $pgModel->auth_key = $row['auth_key'];
            $pgModel->password_hash = $row['password_hash'];
            $pgModel->password_reset_token = $row['password_reset_token'];
            $pgModel->email_confirm_token = $row['email_confirm_token'];
            $pgModel->email = $row['email'];
            $pgModel->status = intval($row['status']);
            $pgModel->user_group = intval($row['user_group']);
            $pgModel->created_at = intval($row['created_at']);
            $pgModel->updated_at = intval($row['updated_at']);
            $pgModel->last_login_at = intval($row['last_login_at']);
            echo "{$row['created_at']}\n";
            if(!$pgModel->save()){
                echo "Can not save User {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
        echo "done!\n\n";
    }

    public function actionTransferAuth()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Auth::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_auth')->queryAll();
        foreach ($rows as $row){
            $pgModel = new Auth();
            $pgModel->id = intval($row['id']);
            $pgModel->user_id = intval($row['user_id']);
            $pgModel->source = $row['source'];
            $pgModel->source_id = $row['source_id'];
            if(!$pgModel->save()){
                echo "Can not save Auth {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferPost()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Post::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_post')->queryAll();
        foreach ($rows as $row){
            $pgModel = new Post();
            $pgModel->id = intval($row['id']);
            $pgModel->author_id = intval($row['author_id']);
            $pgModel->date = intval(strtotime($row['date']));
            $pgModel->category_id = intval($row['category_id']);
            $pgModel->short = $row['short']?:'No short';
            $pgModel->full = $row['full']?:'No full';
            $pgModel->title = $row['title']?:'НЕТ СТАТЬИ!';
            if($row['meta_title']) $pgModel->meta_title = $row['meta_title'];
            if($row['meta_descr']) $pgModel->meta_descr = $row['meta_descr'];
            if($row['meta_keywords']) $pgModel->meta_keywords = $row['meta_keywords'];
            $pgModel->url = $row['url']?:'article-'.$row['id'];
            if($row['related']) $pgModel->related = $row['related'];
            $pgModel->prev_page = intval($row['prev_page']);
            $pgModel->next_page = intval($row['next_page']);
            $pgModel->views = intval($row['views']);
            if($row['edit_date']) $pgModel->edit_date = intval(strtotime($row['edit_date']));
            $pgModel->edit_user = intval($row['edit_user']);
            if($row['edit_reason']) $pgModel->edit_reason = $row['edit_reason'];
            $pgModel->allow_comm = intval($row['allow_comm']);
            $pgModel->allow_main = intval($row['allow_main']);
            $pgModel->allow_catlink = intval($row['allow_catlink']);
            $pgModel->allow_similar = intval($row['allow_similar']);
            $pgModel->allow_rate = intval($row['allow_rate']);
            $pgModel->allow_ad = intval($row['allow_ad']);
            $pgModel->approve = intval($row['approve']);
            $pgModel->fixed = intval($row['fixed']);
            $pgModel->category_art = intval($row['category_art']);
            $pgModel->inm = intval($row['inm']);
            $pgModel->not_in_related = intval($row['not_in_related']);
            $pgModel->skin = intval($row['skin']);
            if(!$pgModel->save()){
                echo "Can not save Post {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferComment()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Comment::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_comment')->queryAll();
        foreach ($rows as $row){
            $pgModel = new Comment();
            $pgModel->id = intval($row['id']);
            $pgModel->reply_to = intval($row['reply_to']);
            $pgModel->post_id = intval($row['post_id']);
            $pgModel->user_id = intval($row['user_id']);
            $pgModel->date = intval(strtotime($row['date']));
            $pgModel->text_raw = $row['text_raw'];
            $pgModel->text = $row['text'];
            $pgModel->ip = $row['ip'];
            $pgModel->is_register = intval($row['is_register']);
            $pgModel->approve = intval($row['approve']);
            if(!$pgModel->save()){
                echo "Can not save Comment {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferCountries()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Countries::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_countries')->queryAll();
        foreach ($rows as $row){
            $pgModel = new Countries();
            $pgModel->id = intval($row['country_id']);
            $pgModel->title_ru = $row['title_ru'];
            $pgModel->title_ua = $row['title_ua'];
            $pgModel->title_be = $row['title_be'];
            $pgModel->title_en = $row['title_en'];
            $pgModel->title_es = $row['title_es'];
            $pgModel->title_pt = $row['title_pt'];
            $pgModel->title_de = $row['title_de'];
            $pgModel->title_fr = $row['title_fr'];
            $pgModel->title_it = $row['title_it'];
            $pgModel->title_pl = $row['title_pl'];
            $pgModel->title_ja = $row['title_ja'];
            $pgModel->title_lt = $row['title_lt'];
            $pgModel->title_lv = $row['title_lv'];
            $pgModel->title_cz = $row['title_cz'];
            if(!$pgModel->save()){
                echo "Can not save Countries {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferFavPosts()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        FavoritePosts::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_favorite_posts')->queryAll();
        foreach ($rows as $row){
            $pgModel = new FavoritePosts();
            $pgModel->id = intval($row['id']);
            $pgModel->user_id = intval($row['user_id']);
            $pgModel->post_id = intval($row['post_id']);
            if($row['link']) $pgModel->link = $row['link'];
            if($row['title']) $pgModel->title = $row['title'];
            $pgModel->date = intval(strtotime($row['date']));
            $pgModel->external = intval($row['external']);
            if(!$pgModel->save()){
                echo "Can not save FavoritePosts {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferImages()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        Images::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_images')->queryAll();
        foreach ($rows as $row){
            $pgModel = new Images();
            $pgModel->id = intval($row['id']);
            $pgModel->image_name = $row['image_name'];
            if($row['folder']) $pgModel->folder = $row['folder'];
            $pgModel->post_id = intval($row['post_id']);
            if($row['r_id']) $pgModel->r_id = $row['r_id'];
            $pgModel->user_id = intval($row['user_id']);
            $pgModel->date = intval($row['date']);
            if(!$pgModel->save()){
                echo "Can not save Images {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferMoonCal()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        MoonCal::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_moon_cal')->queryAll();
        foreach ($rows as $row){
            $pgModel = new MoonCal();
            $pgModel->id = intval($row['id']);
            if($row['date']) $pgModel->date = $row['date'];
            $pgModel->moon_day = intval($row['moon_day']);
            if($row['moon_day_from']) $pgModel->moon_day_from = $row['moon_day_from'];
            if($row['moon_day_sunset']) $pgModel->moon_day_sunset = $row['moon_day_sunset'];
            if($row['moon_day2']) $pgModel->moon_day2 = intval($row['moon_day2']);
            if($row['moon_day2_from']) $pgModel->moon_day2_from = $row['moon_day2_from'];
            if($row['moon_day2_sunset']) $pgModel->moon_day2_sunset = $row['moon_day2_sunset'];
            $pgModel->zodiak = intval($row['zodiak']);
            if($row['zodiak_from_ut']) $pgModel->zodiak_from_ut = $row['zodiak_from_ut'];
            $pgModel->phase = intval($row['phase']);
            if($row['phase_from']) $pgModel->phase_from = $row['phase_from'];
            $pgModel->moon_percent = floatval($row['moon_percent']);
            $pgModel->blago = intval($row['blago']);
            if(!$pgModel->save()){
                echo "Can not save MoonCal {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferMoonDni()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        MoonDni::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_moon_dni')->queryAll();
        foreach ($rows as $row){
            $pgModel = new MoonDni();
            $pgModel->id = intval($row['id']);
            $pgModel->num = intval($row['num']);
            $pgModel->text = $row['text'];
            $pgModel->blago = intval($row['blago']);
            if(!$pgModel->save()){
                echo "Can not save MoonDni {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferMoonFazy()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        MoonFazy::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_moon_fazy')->queryAll();
        foreach ($rows as $row){
            $pgModel = new MoonFazy();
            $pgModel->id = intval($row['id']);
            $pgModel->num = intval($row['num']);
            $pgModel->text = $row['text'];
            $pgModel->blago = intval($row['blago']);
            if(!$pgModel->save()){
                echo "Can not save MoonFazy {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferMoonZnaki()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        MoonZnaki::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_moon_znaki')->queryAll();
        foreach ($rows as $row){
            $pgModel = new MoonZnaki();
            $pgModel->id = intval($row['id']);
            $pgModel->num = intval($row['num']);
            $pgModel->text = $row['text'];
            $pgModel->blago = intval($row['blago']);
            if(!$pgModel->save()){
                echo "Can not save MoonZnaki {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferMoonHair()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        MoonHair::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_moon_hair')->queryAll();
        foreach ($rows as $row){
            $pgModel = new MoonHair();
            $pgModel->id = intval($row['id']);
            if($row['title']) $pgModel->title = $row['title'];
            if($row['date']) $pgModel->date = $row['date'];
            $pgModel->post_id = intval($row['post_id']);
            $pgModel->month = intval($row['month']);
            $pgModel->year = intval($row['year']);
            if($row['short']) $pgModel->short = $row['short'];
            if($row['full']) $pgModel->full = $row['full'];
            $pgModel->approve = intval($row['approve']);
            $pgModel->views = intval($row['views']);
            if(!$pgModel->save()){
                echo "Can not save MoonHair {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferMoonOgorod()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        MoonOgorod::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_moon_ogorod')->queryAll();
        foreach ($rows as $row){
            $pgModel = new MoonOgorod();
            $pgModel->id = intval($row['id']);
            $pgModel->month = intval($row['month']);
            $pgModel->zodiak = intval($row['zodiak']);
            $pgModel->phase = intval($row['phase']);
            $pgModel->text = $row['text'];
            if(!$pgModel->save()){
                echo "Can not save MoonOgorod {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferPostsRating()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        PostsRating::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_posts_rating')->queryAll();
        foreach ($rows as $row){
            $pgModel = new PostsRating();
            $pgModel->id = intval($row['id']);
            $pgModel->post_id = intval($row['post_id']);
            $pgModel->user_id = intval($row['user_id']);
            $pgModel->score = intval($row['score']);
            if(!$pgModel->save()){
                echo "Can not save PostsRating {$row['id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferPostCategory()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        PostCategory::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_post_category')->queryAll();
        foreach ($rows as $row){
            $pgModel = new PostCategory();
            $pgModel->post_id = intval($row['post_id']);
            $pgModel->category_id = intval($row['category_id']);
            if(!$pgModel->save()){
                echo "Can not save PostCategory {$row['post_id']}-{$row['category_id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }

    public function actionTransferUserProfile()
    {
        /** @var Connection $oldDb */
        $oldDb = \Yii::$app->oldDb;

        UserProfile::deleteAll();

        $rows = $oldDb->createCommand('SELECT * FROM bw_user_profile')->queryAll();
        foreach ($rows as $row){
            $pgModel = new UserProfile();
            $pgModel->user_id = intval($row['user_id']);
            if($row['sex']) $pgModel->sex = $row['sex'];
            if($row['name']) $pgModel->name = $row['name'];
            if($row['surname']) $pgModel->surname = $row['surname'];
            if($row['birth_date']) $pgModel->birth_date = $row['birth_date'];
            if($row['country']) $pgModel->country = $row['country'];
            if($row['city']) $pgModel->city = $row['city'];
            if($row['avatar']) $pgModel->avatar = $row['avatar'];
            if($row['info']) $pgModel->info = $row['info'];
            if($row['signature']) $pgModel->signature = $row['signature'];
            $pgModel->last_visit = intval($row['last_visit']);
            if($row['last_ip']) $pgModel->last_ip = $row['last_ip'];
            if(!$pgModel->save()){
                echo "Can not save UserProfile {$row['post_id']}-{$row['category_id']}. Error: ".json_encode($pgModel->getErrors());
            }
        }
    }


    public function actionDo($test = 1, $count = 1)
    {
        $posts = Post::find()
            ->where(['approve' => Post::NOT_APPROVED])
            ->andWhere(['between', 'id', 2858, 3211])
            ->limit($count)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        echo "========= Found ".count($posts)." articles =========\n\n";

        foreach ($posts as $post){
            echo "\n---------------- {$post->id} -------------------.\n";
            /** @var Post $post */
            $text = $post->full;
            $text = str_ireplace('skincaremask', 'beauty-women', $text);

            $matches_count = 0;
            $matchesFlag = false;
            $pattern = '/\[link=([0-9]{1,3})\]/si';

            preg_match_all($pattern, $text, $matches);

            if($matches[0]){
                foreach ($matches[0] as $key => $full){
                    $oldId = $matches[1][$key];
                    $newId = $oldId + 2857;
                    $text = str_ireplace('[link='.$oldId.']', '[link='.$newId.']', $text);
                    echo "== Replaced $oldId with $newId\n";
                    $matches_count++;
                    $matchesFlag = true;
                }
            }

            echo "{$post->id}: matches {$matches_count}.\n";
            if($matchesFlag){
                /* Save */
                $post->full = $text;
                /*if($post->save()) {
                    echo "!!! Saved ID: {$post->id}";
                    if ($test) {
                        echo "********** ID: {$post->id}. Matches: {$matches_count}. TEXT: {$text}\n\n";
                    }
                } else {
                    echo json_encode($post->getErrors())."\n";
                }*/
            } else {
                echo "**** Matches not found!!! ID: {$post->id}. Matches: {$matches_count}.\n";
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
        $test = 1;
        $matches_count = 0;
        $pattern = '/\[link=([0-9]{1,3})\]/si';
        /*$text = preg_replace_callback($pattern, function ($matches) use(&$matches_count){
            //var_dump($matches);
            $matches_count += 1;
            $newId = 2857 + $matches[1];
            return '[link='.$newId.']';
        }, $text);*/

        $replaced_count = 0;

        preg_match_all($pattern, $text, $matches);

        if($matches[0]){
            foreach ($matches[0] as $key => $full){
                $oldId = $matches[1][$key];
                $newId = $oldId + 2857;
                $text = str_ireplace('[link='.$oldId.']', '[link='.$newId.']', $text);
                if($test){
                    echo "== Replaced $oldId with $newId\n";
                }
                $matches_count++;
            }
        }

        if($replaced_count || $matches_count){
            /* Save */
        } else {
            echo "**** Matches not found!!! ID:.";
        }

        echo "$matches_count \n\n";
        echo $text;
    }
}