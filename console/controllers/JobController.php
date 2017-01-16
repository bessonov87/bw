<?php

namespace console\controllers;

use common\components\helpers\GlobalHelper;
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
use common\models\ar\Goroskop;
use common\models\MoonDni;
use common\models\MoonFazy;
use common\models\MoonHair;
use common\models\MoonOgorod;
use common\models\MoonZnaki;
use yii\base\ErrorException;
use yii\console\Controller;
use yii\db\Connection;
use common\components\AppData;
use common\models\ar\Post;
use yii\helpers\Json;

class JobController extends Controller
{
    public function actionMoveGoroskop()
    {
        Goroskop::deleteAll();

        $znaki = ['all' => 0, 'aries' => 1, 'taurus' => 2, 'gemini' => 3, 'cancer' => 4, 'leo' => 5, 'virgo' => 6, 'libra' => 7, 'scorpio' => 8, 'sagitarius' => 9, 'capricorn' => 10, 'aquarius' => 11, 'pisces' => 12];
        /** @var Connection $db */
        $db = \Yii::$app->astroDb;

        $goroskops = $db->createCommand('SELECT * FROM sln_goroskop')->queryAll();

        $diff = 18403200;
        foreach ($goroskops as $goroskop){
            //var_dump(implode(', ', array_keys($goroskop))); die;
            $goroskopModel = new Goroskop();
            $goroskopModel->created_at = time();
            $goroskopModel->zodiak = $znaki[$goroskop['znak']];
            $goroskopModel->text = $goroskop['text'];
            switch($goroskop['period']) {
                case Goroskop::PERIOD_DAY:
                    $goroskopModel->date = date('Y-m-d', strtotime($goroskop['date'])+$diff);
                    $goroskopModel->week = $goroskop['week'];
                    $goroskopModel->month = $goroskop['month'];
                    $goroskopModel->year = 2017;
                    break;
                case Goroskop::PERIOD_WEEK:
                    $goroskopModel->date = null;
                    $goroskopModel->week = intval($goroskop['week']) - 36;
                    $goroskopModel->month = $goroskop['month'];
                    $goroskopModel->year = 2017;
                    break;
                case Goroskop::PERIOD_MONTH:
                case Goroskop::PERIOD_YEAR:
                    $goroskopModel->date = null;
                    $goroskopModel->week = $goroskop['week'];
                    $goroskopModel->month = $goroskop['month'];
                    $goroskopModel->year = $goroskop['year'];
                    break;
                default:
                    die('Unknown period');
            }

            $goroskopModel->period = $goroskop['period'];
            $goroskopModel->type = Goroskop::TYPE_COMMON;
            $goroskopModel->approve = $goroskop['approve'];
            $goroskopModel->views = $goroskop['views'];

            if(!$goroskopModel->save()){
                var_dump($goroskopModel->getErrors()); die;
            }
        }

    }

    public function actionParser($year = 2017, $month = 1, $oneDay = 0)
    {
        $phases = [
            'Новолуние' => 1,
            'Первая четверть' => 2,
            'Полнолуние' => 3,
            'Последняя четверть' => 4
        ];

        $calendars[2017] = [
            1 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3311-01-2017.html', 2 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3312-02-2017.html',
            3 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3313-03-2017.html', 4 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3314-04-2017.html',
            5 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3336-05-2017.html', 6 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3337-06-2017.html',
            7 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3338-07-2017.html', 8 => 'http://www.nrastro.ru/lunny-kalendar/22-mesyatsy/3339-08-2017.html',
            /*9 => '', 10 => '',
            11 => '', 12 => '',*/
        ];

        $base = 'http://mirkosmosa.ru/lunar-calendar/phase-moon/'.$year.'/';
        $months = [
            1 => 'january', 2 => 'february', 3 => 'march', 4 => 'april', 5 => 'may', 6 => 'june',
            7 => 'july', 8 => 'august', 9 => 'september', 10 => 'october', 11 => 'november', 12 => 'december'
        ];
        $base .= $months[$month] . '/';

        $blagos = [];
        $no_blagos = [];

        $monthLink = $calendars[$year][$month];
        $html = file_get_contents($monthLink);

        // Обработка календаря на месяц
        $document = \phpQuery::newDocument($html);
        $link = trim($document->find('#page table:first tr')->each(function ($x) use($year, $month, $phases, $base, $blagos, $no_blagos){
            if(is_null($x->previousSibling)){
                return;
            }
            $tds = $x->getElementsByTagName('td');
            $day = 0;
            $moonCal = null;
            for($i=0;$i<$tds->length;$i++){
                $tdText = trim($tds->item($i)->textContent);
                switch ($i){
                    case 0:
                        $arr = explode(' ', $tdText);
                        $day = sprintf('%02d', $arr[0]);
                        $date = $year.'-'.sprintf('%02d', $month).'-'.sprintf('%02d', $arr[0]);
                        if(!$moonCal = MoonCal::findOne(['date' => $date])) {
                            $moonCal = new MoonCal();
                            $moonCal->date = $date;
                        }
                        break;
                    case 1:
                        $re = '/([0-9]{1,2})-[^\d]{1}/i';
                        $re2 = '/([0-9]{1,2})-.*([0-9]{1,2})-.*/i';
                        if(preg_match($re2, $tdText, $matches)){
                            $moonCal->moon_day = intval($matches[1]);
                            $moonCal->moon_day2 = intval($matches[2]);
                        } else {
                            $moonCal->moon_day = intval(substr($tdText, 0, strlen($tdText)-3));
                        }
                        $moonCal->moon_day2_from = '00:00';
                        $moonCal->moon_day2_sunset = '00:00';
                        break;
                    case 2:
                        if(!$tdText) $moonCal->moon_day_from = '00:00';
                        else $moonCal->moon_day_from = $this->changedTime($tdText);
                        break;
                    case 3:
                        if(!$tdText) $moonCal->moon_day_sunset = '00:00';
                        else $moonCal->moon_day_sunset = $this->changedTime($tdText);
                        break;
                    case 4:
                        $moonCal->zodiak = GlobalHelper::rusZodiac($tdText, 'i', true);
                        break;
                    case 5:
                        if($tdText){
                            $moonCal->zodiak_from_ut = $this->changedTime($tdText);
                        } else {
                            $moonCal->zodiak_from_ut = '00:00';
                        }
                        break;
                    case 6:
                        break;
                    case 7:
                        $re = '/(.*)\s([0-9]{1,2}:[0-9]{1,2})/i';
                        if(preg_match_all($re, $tdText, $matches)) {
                            //var_dump($matches); die;
                            $phase = trim($matches[1][0]);
                            $words = explode(' ', $phase);
                            $words = array_map(function ($element){
                                return trim($element);
                            }, $words);
                            if(mb_strpos(' ', $phase) !== false){
                                $words = explode(' ', $phase);
                            }
                            $phase = mb_ereg_replace('/[^А-Яа-я\s]/', '', $phase);
                            $phase = mb_ereg_replace('/\t+/', ' ', $phase);
                            $phase = mb_ereg_replace('/\s+/', ' ', $phase);
                            $phase = str_replace('  ', ' ', $phase);

                            if(isset($phases[$phase])){
                                $phaseId = $phases[$phase];
                            } else {
                                if(mb_stripos($phase, 'первая') !== false){
                                    $phaseId = 2;
                                } elseif(mb_stripos($phase, 'последняя') !== false) {
                                    $phaseId = 4;
                                } elseif(mb_stripos($phase, 'полнолуние') !== false) {
                                    $phaseId = 3;
                                } elseif(mb_stripos($phase, 'новолуние') !== false) {
                                    $phaseId = 1;
                                } else {
                                    throw new ErrorException('Parse phase Error: '.$tdText);
                                }
                            }
                            $moonCal->phase = $phaseId;
                            $moonCal->phase_from = $this->changedTime($matches[2][0]);
                        } else {
                            $moonCal->phase = 0;
                            $moonCal->phase_from = '00:00';
                        }
                        break;
                }
            }
            // Парсинг ежедневного календаря для определения процента видимости
            if($day) {
                $html2 = file_get_contents($base . intval($day));
                $document2 = \phpQuery::newDocument($html2);
                $illum = trim($document2->find('.illum')->text());
                $re = '/.*:\s([0-9]{1,3})\%/i';
                if(preg_match($re, $illum, $matches)) {
                    //var_dump($matches); die;
                    $percent = intval($matches[1]);
                    if($percent == 0){
                        $percent += round(mt_rand(1,4)/10, 1);
                    } elseif($percent == 100){
                        $percent -= round(mt_rand(1,4)/10, 1);
                    } else {
                        $percent += round(mt_rand(-4,4)/10, 1);
                    }
                    $moonCal->moon_percent = $percent;
                }
            }
            // Определение благоприятности (чистый рандом + немного астрологии)
            if($moonCal->phase == 1 || $moonCal->phase == 3){
                $moonCal->blago = 2;
            } else {
                $moonCal->blago = mt_rand(1,2);
            }
            $moonCal->blago_level = $moonCal->blago == 1 ? mt_rand(1, 3) : mt_rand(-3, -1);

            $descriptions = $moonCal->blago == 1 ? AppData::$descriptions_pos : AppData::$descriptions_neg;
            $array = $moonCal->blago == 1 ? 'blagos' : 'no_blagos';
            $elements = count($descriptions);
            $stop = false;
            while ($stop == false){
                $elem = mt_rand(0, $elements-1);
                $arr = $$array;
                if(!isset($arr[$elem])){
                    if($moonCal->blago == 1) {
                        $blagos[$elem] = $elem;
                    } else {
                        $no_blagos[$elem] = $elem;
                    }
                    $stop = true;
                }
            }
            $moonCal->hair_text = $descriptions[$elem];

            var_dump($moonCal->attributes);
            if(!$moonCal->save()){
                echo "*** NOT SAVED *** \n";
                echo json_encode($moonCal->getErrors())."\n";
            } else {
                echo "=== SAVED === \n";
            }
            sleep(10);
        }));
        \phpQuery::unloadDocuments($document->getDocumentID());
        $document = null;





        //var_dump($html); die;
    }

    protected function changedTime($time)
    {
        list($h, $m) = explode(':', $time);
        $m = (int)$m;
        if($m > 56){
            $m = $m - mt_rand(1, 3);
        } else if($m < 4){
            $m = $m + mt_rand(1, 3);
        } else {
            $m = $m + mt_rand(-3, 3);
        }
        return $h.':'.sprintf('%02d', $m);
    }

    public function actionHttps($action = 0)
    {
        $posts = Post::find()->where(['approve' => 1]);

        $x = 0;
        $y = 0;
        foreach ($posts->each() as $post){
            $f = false;
            /** @var Post $post */
            $imgPattern = '/src="http:\/\/beauty-women.ru\//iu';
            $imgReplace = 'src="/';
            $linkPattern = '/href="http:\/\/beauty-women.ru\//iu';
            $linkReplace = 'href="/';
            if(preg_match($imgPattern, $post->short) || preg_match($linkPattern, $post->short)){
                $post->short = preg_replace($imgPattern, $imgReplace, $post->short);
                $post->short = preg_replace($linkPattern, $linkReplace, $post->short);
                $f = true;
            }
            if(preg_match($imgPattern, $post->full) || preg_match($linkPattern, $post->full)){
                $post->full = preg_replace($imgPattern, $imgReplace, $post->full);
                $post->full = preg_replace($linkPattern, $linkReplace, $post->full);
                echo $post->full;
                $f = true;
            }

            if($f){
                $x++;
            }

            if($action){
                if(!$post->save()){
                    var_dump($post->getErrors()); die;
                } else {
                    $y++;
                }
            }
        }

        echo "\n======== Finished. $x posts found. $y posts updated ======== \n\n";
    }

    public function actionCreateIndex()
    {
        $posts = Post::find()->where(['approve' => 1]);

        $x = 0;
        $y = 0;
        $time = time();
        foreach ($posts->each() as $post){
            /** @var Post $post */
            $elasticPost = PostElastic::findOne(['post_id' => $post->id]);
            if($elasticPost && $post->category_art == 1){
                $elasticPost->delete();
                continue;
            }
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
        $log = date('d.m.Y H:i:s') . " - Total: $x posts saved, $y posts not saved. Time spent: $time seconds\n";
        echo $log;
        file_put_contents(\Yii::getAlias('@console/runtime/logs/create_index.log'), $log, FILE_APPEND);
    }

    public function actionTestIndex()
    {
        $post = Post::find()->limit(1)->one();

        $elasticPost = PostElastic::findOne(['post_id' => 4]);

        $q = "свадебные прически";

        $query = PostElastic::find()->query([
            "multi_match" => [
                'query' => $q,
                'fields' => ['title^10', 'short', 'full'],
                'operator' => 'and',
            ]
        ])->limit(100);

        foreach ($query->all() as $post){
            echo $post->title."\n";
        }

        //var_dump();

        /*if(!$elasticPost) {
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
        }*/

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
<p><img class="si150" style="float: left; border: 0px;" title="Пилинг лица" src="//beauty-women.ru/uploads/posts/2014-05/piling1_1400854077.jpg" alt="Пилинг лица" /></p>
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

    public function actionGoro()
    {
        $goroskops = Goroskop::find()
            ->where(['period' => Goroskop::PERIOD_DAY])
            ->orWhere(['period' => Goroskop::PERIOD_WEEK])
            ->asArray()
            ->all();

        $res = Json::encode($goroskops);

        file_put_contents(\Yii::getAlias('@console/.data/goro.json'), $res);
    }

    public function actionGoroRestore()
    {
        $goro = file_get_contents(\Yii::getAlias('@console/.data/goro.json'));
        $goroskops = Json::decode($goro);

        $ids = [];
        foreach ($goroskops as $goroskop){
            unset($goroskop['id']);
            $goroskopModel = new Goroskop($goroskop);
            if(!$goroskopModel->save()){
                var_dump($goroskopModel->getErrors());
                continue;
            }

            $ids[] = $goroskopModel->getPrimaryKey();
        }

        //var_dump(Goroskop::deleteAll(['in', 'id', $ids]));
    }
}