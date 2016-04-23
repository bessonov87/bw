<?php

namespace console\controllers;

use common\models\ar\Post;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\components\helpers\GlobalHelper;
use common\models\ar\User;

class HoroController extends Controller
{
    public $month;
    public $znak;
    public $year;
    public $alt;

    private $_data;

    private $_url = 'goroskop-na-[engmonth_i]-[year]-[engznak_i]';
    private $_url_all = 'goroskop-na-[engmonth_i]-[year]';
    private $_alt = "Гороскоп на [month_i] [year] года [znak_i]. Любовный, финансовый, здоровья";
    private $_alt_all = "Гороскоп на [month_i] [year] года для всех знаков Зодиака. Любовный, финансовый, здоровья";
    private $_title = "Гороскоп на [month_i] [year] года [znak_i]";
    private $_title_all = "Гороскоп на [month_i] [year] года для всех знаков Зодиака";
    private $_meta_title = "Гороскоп на [month_i] [year] года [znak_i]. Любовный, финансовый, здоровья астрологический прогноз для [znak_r]";
    private $_meta_title_all = "Гороскоп на [month_i] [year] года для всех знаков Зодиака. Любовный, финансовый, здоровья астрологический прогноз";
    private $_meta_descr = "Любовный, финансовый, здоровья астрологический прогноз для [znak_r] на [month_i] [year] года. Гороскоп для [znak_r] в [month_p] [year]";
    private $_meta_descr_all = "Любовный, финансовый, здоровья астрологический прогноз для всех знаков Зодиака на [month_i] [year] года. Гороскоп для всех знаков Зодиака в [month_p] [year]";

    private $_full = '<p>Первый абзац.</p><p>&nbsp;</p><p><img style="border: 0px; display: block; margin-left: auto; margin-right: auto;" src="http://beauty-women.ru/uploads/posts/horoscope/[engmonth_i]-[year]-[engznak_i].jpg" alt="[alt]" /></p><p>&nbsp;</p>';
    private $_full_all = '<p>Первый абзац.</p><p>&nbsp;</p><p><img style="border: 0px; display: block; margin-left: auto; margin-right: auto;" src="http://beauty-women.ru/uploads/posts/horoscope/[engmonth_i]-[year].jpg" alt="[alt]" /></p><p>&nbsp;</p>';

    private $_short = '<img src="http://beauty-women.ru/uploads/posts/horoscope/[engmonth_i]-[year]-[engznak_i]-0.jpg" border="0" alt="" align="left" />';
    private $_short_all = '<img src="http://beauty-women.ru/uploads/posts/horoscope/[engmonth_i]-[year]-0.jpg" border="0" alt="" align="left" />';

    public function actionIndex(){
        $this->stdout('It works!', Console::FG_YELLOW);
        return 0;
    }

    public function actionGenerateMonth($year, $month)
    {
        $this->month = $month;
        $this->year = $year;

        for($i=0;$i<=12;$i++) {
            $this->znak = $i;
            $model = new Post();
            if($i == 0) {
                $url = $this->_url_all;
                $this->alt = $this->_alt_all;
                $title = $this->_title_all;
                $meta_title = $this->_meta_title_all;
                $meta_descr = $this->_meta_descr_all;
                $short = $this->_short_all;
                $full = $this->_full_all;
            } else {
                $url = $this->_url;
                $this->alt = $this->_alt;
                $title = $this->_title;
                $meta_title = $this->_meta_title;
                $meta_descr = $this->_meta_descr;
                $short = $this->_short;
                $full = $this->_full;
            }
            $model->author_id = 1;
            $model->category_id = 66;
            $model->date = date('Y-m-d H:i:s');
            $model->url = $this->replace($url);
            $model->title = $this->replace($title);
            $model->meta_title = $this->replace($meta_title);
            $model->meta_descr = $this->replace($meta_descr);
            $model->short = $this->replace($short);
            $model->full = $this->replace($full);
            $model->approve = 0;

    //        var_dump($model->short); die;

            //echo GlobalHelper::rusMonth($month).' '.($i > 0) ? GlobalHelper::rusZodiac($i) : 'Все знаки'.' ';
            if($model->save()){
                echo 'OK';
            } else {
                var_dump($model->getErrors());
            }
            echo PHP_EOL;
        }
    }

    private function replace($string){
        // Год
        $string = str_replace('[year]', $this->year, $string);

        // Img Alt
        $string = str_replace('[alt]', $this->replace($this->alt), $string);

        // Месяцы
        if(preg_match('@\[month_([a-z]{1})\]@si', $string)){
            $string = preg_replace_callback('@\[month_([a-z]{1})\]@si', function($matches)
            {
                return GlobalHelper::rusMonth((int)$this->month, $matches[1]);
            }, $string);
        }

        if(preg_match('@\[engmonth_([a-z]{1})\]@si', $string)){
            $string = preg_replace_callback('@\[engmonth_([a-z]{1})\]@si', function($matches)
            {
                return GlobalHelper::engMonth((int)$this->month, $matches[1]);
            }, $string);
        }

        // Знаки
        if(preg_match('@\[znak_([a-z]{1})\]@si', $string)){
            $string = preg_replace_callback('@\[znak_([a-z]{1})\]@si', function($matches)
            {
                return GlobalHelper::rusZodiac((int)$this->znak, $matches[1]);
            }, $string);
        }

        if(preg_match('@\[engznak_([a-z]{1})\]@si', $string)){
            $string = preg_replace_callback('@\[engznak_([a-z]{1})\]@si', function($matches)
            {
                return mb_strtolower(GlobalHelper::translit(GlobalHelper::rusZodiac((int)$this->znak, $matches[1])));
            }, $string);
        }

       return $string;

    }
}