<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\IeAsset;
use common\widgets\Alert;

AppAsset::register($this);
IeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="3a228cf0e5e32c898196bfea56847e12" content="">
    <meta name='yandex-verification' content='493bad59088a199d' />
    <meta name="verify-v1" content="C1MdOFwJGF06EAhq6SC2D1kREMw2GjnhHXE3tt6i7Wc=" />
    <meta name="google-site-verification" content="ns-Jt52G5-G8rKSByXPua73jvRyGYBtJ0uzpC5tK8WM" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="/favicon.ico" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="page-wrap">
    <div id="header">
        <div id="logo-text"><h1>Женский журнал - Секреты здоровья и красоты</h1></div>
    </div>
    <div id="top-nav">
        <div id="top-nav-search">
            <div class="box">
                <form action='' method="post" target="_top" >
                    <div class="container-4">
                        <input type="hidden" name="do" value="search" />
                        <input type="search" id="search" name="story" placeholder="Поиск..." />
                        <button class="icon"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>


        </div>
        <span onclick="toggle_menu();" class="toggle_butt mobile-nav"></span>
        <ul class="solidblockmenu">
            <?php
            if (Yii::$app->user->isGuest) {
               echo '<li><a href="/site/login">Вход</a></li>';
                echo '<li><a href="/site/signup">Регистрация</a></li>';
            } else {
                echo '<li><a href="/site/logout" data-method="post">Выход ('.Yii::$app->user->identity->username.')</a></li>';
             }
            ?>
            <li><a href="http://beauty-women.ru/advertising/">Реклама на сайте</a></li>
            <li><a href="http://beauty-women.ru/feedback.php">Обратная связь</a></li>
            <li><a href="#cats" title="Разделы">Разделы</a></li>
            <li><a href="http://beauty-women.ru/" title="Женский журнал" class="main-page">Главная</a></li>
        </ul>
    </div>
    <div id="container-wrap">
        <div id="g_ads_top">
            <!-- begin of Top100 code -->
            <script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?1630331"></script><noscript><img src="http://counter.rambler.ru/top100.cnt?1630331" alt="" width="1" height="1" border="0"></noscript>
            <!-- end of Top100 code -->
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- beauty_up_adapt -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-6721896084353188"
                 data-ad-slot="9892796747"
                 data-ad-format="auto"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div id="content">


            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <!-- Блок Реклама Верх -->
            <div id="content-item">
                <div id="content-item-top" class="content-item-ads">Реклама</div>
                <div id="content-item-content">
                    <div id="content-center-10">

                        <div id="SC_TBlock_73326" class="SC_TBlock"></div>

                        <script type="text/javascript">var SC_CId = "73326",SC_Domain="n.andreyp6.ru";SC_Start_73326=(new Date).getTime();</script>
                        <script type="text/javascript" src="http://st.n.andreyp6.ru/js/adv_out.js"></script>
                    </div>
                </div>
            </div>
            <!-- Конец Блок Реклама Верх -->


            <!-- Таблица контент-->
            <?= Alert::widget() ?>
            <?= $content ?>
            <!-- Таблица контент-->


            <!-- Блок Реклама Низ -->
            <div id="content-item">
                <div id="content-item-top" class="content-item-ads">Реклама</div>
                <div id="content-item-content">
                    <div id="content-center-10">
                        <script type="text/javascript"><!--
                        google_ad_client = "ca-pub-6721896084353188";
                        /* Beauty-New */
                        google_ad_slot = "1627586855";
                        google_ad_width = 336;
                        google_ad_height = 280;
                        //-->
                        </script>
                        <script type="text/javascript"
                                src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                        </script>
                    </div>
                </div>
            </div>
            <!-- Конец Блок Реклама Низ -->


        </div>
        <div id="sidebar">

            <!-- Блок Гороскоп -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-pink"><a href="http://astrolis.ru/goroskop/na-den/" target="_blank">Гороскоп на сегодня</a></div>
                <div id="sidebar-item-content">
                    <?= \app\components\HoroscopeWidget::widget() ?>
                </div>
            </div>
            <!-- Конец Блок Гороскоп -->

            <!-- Блок Боковое меню -->
            <a name="cats"></a>
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-blue">Разделы</div>
                <div id="sidebar-item-content">
                    <div class="blockmenu">
                        <a href="http://beauty-women.ru/tests/index.php">Онлайн тесты</a>
                        <a href="http://beauty-women.ru/beautysecrets/">Секреты красоты</a>
                        <a href="http://beauty-women.ru/makeupsecrets/">Секреты макияжа</a>
                        <a href="http://beauty-women.ru/fashion/">Мода и стиль</a>
                        [category=2,3,11,12,49,61]<a href="http://beauty-women.ru/aromat/">Парфюм и ароматы</a>[/category]
                        <a href="http://beauty-women.ru/jefirnye-masla/">Эфирные масла</a>
                        <a href="http://beauty-women.ru/maski-dlja-lica-v-domashnih-uslovijah/">Маски для лица</a>
                        <a href="http://beauty-women.ru/diets/">Диеты</a>
                        [category=4,5,10,45,57]<a href="http://beauty-women.ru/diets/dieta-djukana/">Диета Дюкана</a>[/category]
                        [category=4,5,10,45,57]<a href="http://beauty-women.ru/calculator/">Калькулятор ИМТ</a>[/category]
                        [category=4,5,10,45,57]<a href="http://beauty-women.ru/healthyfood/">Здоровое питание</a>[/category]
                        [category=4,5,10,45,57]<a href="http://beauty-women.ru/magnificent/">Великолепная фигура</a>[/category]
                        [category=4,5,10,45,57]<a href="http://beauty-women.ru/cookery/">Кулинария</a>[/category]
                        <a href="http://beauty-women.ru/femalehealth/">Женское здоровье</a>
                        [category=6,7]<a href="http://beauty-women.ru/nationalmedicine/">Народная медицина</a>[/category]
                        <a href="http://beauty-women.ru/pregnancy/">Беременность и роды</a>
                        [category=6,7,8,9,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/mesjachnye/">Месячные</a>[/category]
                        [category=9,6,7,8,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/ovuljacija/">Овуляция</a>[/category]
                        [category=9,6,7,8,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/pregnancy/test-na-beremennost/">Тест на беременность</a>[/category]
                        [category=9,6,7,8,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/pregnancy/bazalnaja-temperatura/">Базальная температура</a>[/category]
                        [category=9,6,7,8,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/pregnancy/pervye-priznaki-beremennosti/">Первые признаки беременности</a>[/category]
                        [category=9,6,7,8,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/pregnancy/pol-rebenka/">Определение пола ребенка</a>[/category]
                        [category=6,7,8,9,27,28,52,54,55,56,58,59,60]<a href="http://beauty-women.ru/pregnancy/kalendar-beremennosti/">Календарь беременности</a>[/category]
                        <a href="http://beauty-women.ru/family/">Семья и дети</a>
                        <a href="http://beauty-women.ru/home/">Домашний очаг</a>
                        <a href="http://beauty-women.ru/lovesex/">Любовь и секс</a>
                        <a href="http://beauty-women.ru/psychology/">Психология отношений</a>
                        <a href="http://beauty-women.ru/career/">Карьера и деньги</a>
                        <a href="http://beauty-women.ru/wedding/">Свадьба</a>
                        <a href="http://beauty-women.ru/horoscope/">Гороскоп</a>
                        <a href="http://beauty-women.ru/horoscope/lunnyj-kalendar-na-god/">Лунный календарь на 2016 год</a>
                        [category=19,47,51,53,21]<a href="http://beauty-women.ru/horoscope/lunnyj-kalendar-strizhek/">Лунный календарь стрижек 2016</a>[/category]
                        [category=19,47,51,53,21]<a href="http://beauty-women.ru/horoscope/lunnyj-kalendar-ogorodnika-sadovoda/">Лунный календарь огородника 2016</a>[/category]

                        <a href="http://beauty-women.ru/raznoe/">Разное</a>
                    </div>
                </div>
            </div>
            <!-- Конец Блок Боковое меню-->

            <!-- Блок Вход на сайт -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-green">Вход на сайт</div>
                <div id="sidebar-item-content">
                    {login}
                </div>
            </div>
            <!-- Конец Блок Вход на сайт -->

            <!-- Блок Календарь -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-orange">Календарь</div>
                <div id="sidebar-item-content">
                    <?= \app\components\CalendarWidget::widget() ?>
                </div>
            </div>
            <!-- Конец Блок Календарь -->

            <!-- Блок Популярное -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-pink">Популярное</div>
                <div id="sidebar-item-content">
                    <?= \app\components\PopularWidget::widget(['numPosts' => 10, 'listType' => 'ol']) ?>
                </div>
            </div>
            <!-- Конец Популярное -->

            <!-- Блок Статистика -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-blue">Статистика</div>
                <div id="sidebar-item-content">
                    <div class="sidebar-stats">
                        <!--LiveInternet counter--><script type="text/javascript"><!--
                    document.write("<a href='http://www.liveinternet.ru/click' "+
                            "target=_blank><img src='http://counter.yadro.ru/hit?t19.5;r"+
                            escape(document.referrer)+((typeof(screen)=="undefined")?"":
                            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                            ";"+Math.random()+
                            "' alt='' title='LiveInternet: показано число просмотров за 24"+
                            " часа, посетителей за 24 часа и за сегодня' "+
                            "border=0 width=88 height=31><\/a>")//--></script><!--/LiveInternet-->
                        <br>
                        <br>
                        <!-- begin of Top100 logo -->
                        <a href="http://top100.rambler.ru/home?id=1630331"><img src="http://top100-images.rambler.ru/top100/banner-88x31-rambler-black2.gif" alt="Rambler's Top100" width="88" height="31" border="0" /></a>
                        <!-- end of Top100 logo -->
                        <br>
                        <br>

                    </div>
                </div>
            </div>
            <!-- Конец Статистика -->

            <div class="container">
                <div id="right-column" class="floating">
                    <div id="zcbclk41923"></div>
                </div>
            </div>
            <div class="toptop"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="footer">
        <div id="copyright" align="center" style="color:#FFFFFF; font-weight:bold; font-size:12px">Копирайт &copy; 2008-2015 Beaty-Women.Ru<br />
            <a href="http://beauty-women.ru/" class="white">Все о красоте и здоровье современной женщины - Женский журнал</a><br>
            Все права защищены</div>
    </div>
</div>
<script type="text/javascript" src="{template}js/mobile_menu.js"></script>
<script type="text/javascript">
    (function(w){var l = function() {
        var n = document.getElementsByTagName("script")[0],
                s = document.createElement("script"),
                ins = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "http://rt.tizerlady.click/init.js?EKXgxNyljJywheHF0fHd2YyEqCyoxFTcgIyw9eHU";
        ins();
    };
        var i = setInterval(function(){ if (document && document.getElementById('zcbclk41923')) { clearInterval(i); l(); } }, 50);})(window);</script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter31758281 = new Ya.Metrika({
                        id:31758281,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/31758281" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
	<!-- Google Analytics counter --><!-- /Google Analytics counter -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>