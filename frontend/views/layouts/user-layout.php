<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\IeAsset;
use common\widgets\Alert;
use app\components\widgets\SidebarMenuWidget;
use app\components\widgets\UserWidget;
use app\components\widgets\PopularWidget;
use app\components\widgets\FlashWidget;
//use app\components\widgets\AdvertWidget;

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
    <?= FlashWidget::widget() ?>
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
                <li><a href="/site/feedback">Обратная связь</a></li>
                <li><a href="/" title="Женский журнал" class="main-page">Beauty-women</a></li>
                <?php if (!Yii::$app->user->isGuest): ?>
                <li><a href="<?= Yii::$app->user->identity->myPage ?>" title="Моя страница" class="main-page">Моя страница</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div id="container-wrap">
            <div id="content">
                <?= Breadcrumbs::widget([
                    'itemTemplate' => '<span>{link}</span>',
                    'activeItemTemplate' => '<span class="breadcrumbs_active">{link}</span>',
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'breadcrumbs'],
                    'tag' => 'div',
                ]) ?>

                <!-- Таблица контент-->
                <?= Alert::widget() ?>
                <?= $content ?>
                <!-- Таблица контент-->

            </div>
            <div id="sidebar">

                <!-- Блок Пользователь -->
                <div id="sidebar-item">
                    <div id="sidebar-item-top" class="sidebar-item-pink"><?= Html::encode(Yii::$app->request->get('username')) ?></div>
                    <div id="sidebar-item-content">
                        <?= UserWidget::widget(['username' => Yii::$app->request->get('username')]) ?>
                    </div>
                </div>
                <!-- Конец Пользователь -->

                <!-- Блок Боковое меню -->
                <div id="sidebar-item">
                    <div id="sidebar-item-top" class="sidebar-item-blue">Навигация</div>
                    <div id="sidebar-item-content">
                        <?php
                            if(!Yii::$app->user->isGuest && Yii::$app->request->get('username') === Yii::$app->user->identity->username){
                                $items[] = ['label' => 'Моя страница'];
                            }
                            echo SidebarMenuWidget::widget([
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

                <!-- Блок Популярное -->
                <div id="sidebar-item">
                    <div id="sidebar-item-top" class="sidebar-item-pink">Популярное</div>
                    <div id="sidebar-item-content">
                        <?= PopularWidget::widget(['numPosts' => 10, 'listType' => 'ol']) ?>
                    </div>
                </div>
                <!-- Конец Популярное -->

                <div class="toptop"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="footer">
            <div id="copyright" align="center" style="color:#FFFFFF; font-weight:bold; font-size:12px">Копирайт &copy; 2008-2015 Beaty-Women.Ru<br />
                <a href="//beauty-women.ru/" class="white">Все о красоте и здоровье современной женщины - Женский журнал</a><br>
                Все права защищены</div>
            <div class="footer_stats">
                <span><!--LiveInternet counter--><script type="text/javascript"><!--
                document.write("<a href='http://www.liveinternet.ru/click' "+
                    "target=_blank><img src='//counter.yadro.ru/hit?t19.5;r"+
                    escape(document.referrer)+((typeof(screen)=="undefined")?"":
                    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                        screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                    ";"+Math.random()+
                    "' alt='' title='LiveInternet: показано число просмотров за 24"+
                    " часа, посетителей за 24 часа и за сегодня' "+
                    "border=0 width=88 height=31><\/a>")//--></script><!--/LiveInternet--></span>
            <span></span>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/bw15/js/mobile_menu.js"></script>
    <script type="text/javascript">
        (function(w){var l = function() {
            var n = document.getElementsByTagName("script")[0],
                s = document.createElement("script"),
                ins = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "//rt.tizerlady.click/init.js?EKXgxNyljJywheHF0fHd2YyEqCyoxFTcgIyw9eHU";
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
    <!-- Top100 (Kraken) Counter -->
    <script>
        (function (w, d, c) {
            (w[c] = w[c] || []).push(function() {
                var options = {
                    project: 1630331
                };
                try {
                    w.top100Counter = new top100(options);
                } catch(e) { }
            });
            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src =
                (d.location.protocol == "https:" ? "https:" : "http:") +
                "//st.top100.ru/top100/top100.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(window, document, "_top100q");
    </script>
    <noscript><img src="//counter.rambler.ru/top100.cnt?pid=1630331"></noscript>
    <!-- END Top100 (Kraken) Counter -->
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>