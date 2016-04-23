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
use app\components\widgets\SidebarMenuWidget;
use app\components\widgets\AdvertWidget;
use app\components\widgets\HoroscopeWidget;
use app\components\widgets\LoginWidget;
use app\components\widgets\CalendarWidget;
use app\components\widgets\PopularWidget;
use app\components\widgets\SearchWidget;
use app\components\widgets\FlashWidget;

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
    <link rel="alternate" type="application/rss+xml" title="RSS" href="http://beauty-women.ru/rss.xml" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= FlashWidget::widget() ?>
<div id="page-wrap">
    <div id="header">
        <div id="logo-text"><h1>Женский журнал - Секреты здоровья и красоты</h1></div>
    </div>
    <div id="top-nav">
        <?= SearchWidget::widget() ?>

        <span onclick="toggle_menu();" class="toggle_butt mobile-nav"></span>
        <ul class="solidblockmenu">
            <?php
            if (Yii::$app->user->isGuest) {
               echo '<li><a href="/site/login">Вход</a></li>';
                echo '<li><a href="/site/signup">Регистрация</a></li>';
                echo '<li><a href="/advertising/">Реклама на сайте</a></li>';
            } else {
                echo '<li><a href="/site/logout" data-method="post">Выход ('.Yii::$app->user->identity->username.')</a></li>';
                echo '<li><a href="/user/'.Yii::$app->user->identity->username.'/">Моя страница</a></li>';
             }
            ?>
            <li><a href="/site/feedback">Обратная связь</a></li>
            <li><a href="#cats" title="Разделы">Разделы</a></li>
            <li><a href="http://beauty-women.ru/" title="Женский журнал" class="main-page">Главная</a></li>
        </ul>
    </div>
    <div id="container-wrap">
        <div id="g_ads_top">

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
                'itemTemplate' => '<span>{link}</span>',
                'activeItemTemplate' => '<span class="breadcrumbs_active">{link}</span>',
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumbs'],
                'tag' => 'div',
            ]) ?>





            <?= AdvertWidget::widget(
                ['block_number' => 4]
            ) ?>





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

            <!-- Блок Гороскопы на месяц -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-pink">Актуальные гороскопы</div>
                <div id="sidebar-item-content">
                    <div class="blockmenu">
                        <a href="/horoscope/na-mesjac/2857-goroskop-na-aprel-2016.html">Гороскоп на апрель</a>
                        <a href="/horoscope/na-mesjac/3233-goroskop-na-maj-2016-goda.html">Гороскоп на май 2016</a>
                        <a href="/horoscope/na-mesjac/3235-goroskop-na-ijun-2016.html">Гороскоп на июнь 2016</a>
                    </div>
                </div>
            </div>
            <!-- Конец Блок Гороскопы на месяц -->

            <!-- Блок Боковое меню -->
            <a name="cats"></a>
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-blue">Разделы</div>
                <div id="sidebar-item-content">
                    <?= SidebarMenuWidget::widget([
                        'items' => [
                            ['label' => 'Онлайн тесты', 'url' => ['tests/index']],
                            ['label' => 'Секреты красоты', 'url' => '/beautysecrets/'],
                            ['label' => 'Секреты макияжа', 'url' => '/makeupsecrets/'],
                            ['label' => 'Мода и стиль', 'url' => '/fashion/'],
                            ['label' => 'Парфюм и ароматы', 'url' => '/aromat/', 'allowedOn' => '2,3,11,12,49,61'],
                            ['label' => 'Эфирные масла', 'url' => '/jefirnye-masla/'],
                            ['label' => 'Маски для лица', 'url' => '/maski-dlja-lica-v-domashnih-uslovijah/'],
                            ['label' => 'Диеты', 'url' => '/diets/'],
                            ['label' => 'Диета Дюкана', 'url' => '/diets/dieta-djukana/', 'allowedOn' => '4,5,10,45,57'],
                            ['label' => 'Калькулятор ИМТ', 'url' => '/calculator/', 'allowedOn' => '4,5,10,45,57'],
                            ['label' => 'Здоровое питание', 'url' => '/healthyfood/', 'allowedOn' => '4,5,10,45,57'],
                            ['label' => 'Великолепная фигура', 'url' => '/magnificent/', 'allowedOn' => '4,5,10,45,57'],
                            ['label' => 'Кулинария', 'url' => '/cookery/', 'allowedOn' => '4,5,10,45,57'],
                            ['label' => 'Женское здоровье', 'url' => '/femalehealth/'],
                            ['label' => 'Народная медицина', 'url' => '/nationalmedicine/'],
                            ['label' => 'Беременность и роды', 'url' => '/pregnancy/'],
                            ['label' => 'Месячные', 'url' => '/mesjachnye/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Овуляция', 'url' => '/ovuljacija/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Тест на беременность', 'url' => '/pregnancy/test-na-beremennost/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Базальная температура', 'url' => '/pregnancy/bazalnaja-temperatura/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Первые признаки беременности', 'url' => '/pregnancy/pervye-priznaki-beremennosti/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Определение пола ребенка', 'url' => '/pregnancy/pol-rebenka/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Календарь беременности', 'url' => '/pregnancy/kalendar-beremennosti/', 'allowedOn' => '6,7,8,9,27,28,52,54,55,56,58,59,60'],
                            ['label' => 'Семья и дети', 'url' => '/family/'],
                            ['label' => 'Домашний очаг', 'url' => '/home/'],
                            ['label' => 'Любовь и секс', 'url' => '/lovesex/'],
                            ['label' => 'Психология отношений', 'url' => '/psychology/'],
                            ['label' => 'Карьера и деньги', 'url' => '/career/'],
                            ['label' => 'Свадьба', 'url' => '/wedding/'],
                            ['label' => 'Гороскоп', 'url' => '/horoscope/'],
                            ['label' => 'Лунный календарь на 2016 год', 'url' => '/horoscope/lunnyj-kalendar-na-god/'],
                            ['label' => 'Лунный календарь стрижек 2016', 'url' => '/horoscope/lunnyj-kalendar-strizhek/', 'allowedOn' => '19,47,51,53,21'],
                            ['label' => 'Лунный календарь огородника 2016', 'url' => '/horoscope/lunnyj-kalendar-ogorodnika-sadovoda/', 'allowedOn' => '19,47,51,53,21'],
                            ['label' => 'Разное', 'url' => '/raznoe/'],
                        ],
                        'cssClass' => 'blockmenu',
                    ])?>
                </div>
            </div>
            <!-- Конец Блок Боковое меню-->

            <!-- Блок Вход на сайт -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-green">Вход на сайт</div>
                <div id="sidebar-item-content">
                    <?= LoginWidget::widget() ?>
                </div>
            </div>
            <!-- Конец Блок Вход на сайт -->

            <!-- Блок Календарь -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-orange">Календарь</div>
                <div id="sidebar-item-content">
                    <?= CalendarWidget::widget() ?>
                </div>
            </div>
            <!-- Конец Блок Календарь -->

            <!-- Блок Популярное -->
            <div id="sidebar-item">
                <div id="sidebar-item-top" class="sidebar-item-pink">Популярное</div>
                <div id="sidebar-item-content">
                    <?= PopularWidget::widget(['numPosts' => 10, 'listType' => 'ol']) ?>
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
<script type="text/javascript" src="/bw15/js/mobile_menu.js"></script>
<div id="zcbclk41923"></div><script type="text/javascript">
    (function(w){var l = function() {
        var n = document.getElementsByTagName("script")[0],
            s = document.createElement("script"),
            ins = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "//rt.rtl1.biz/init.js?8VAVMSlQeWlFcBQwJAQoLHlxXdldMaEpdXlFABQg";
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
<!-- begin of Top100 code -->
<script async id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?1630331"></script><noscript><img src="http://counter.rambler.ru/top100.cnt?1630331" alt="" width="1" height="1" border="0"></noscript>
<!-- end of Top100 code -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>