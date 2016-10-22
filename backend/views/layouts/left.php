<aside class="main-sidebar">

    <section class="sidebar">

        <?= \app\components\widgets\UserWidget::widget() ?>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Меню Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard', 'url' => Yii::$app->homeUrl],
                    ['label' => 'Статьи', 'icon' => 'fa fa-file-text-o', 'url' => ['post/index']],
                    ['label' => 'Категории', 'icon' => 'fa fa-file-text-o', 'url' => ['category/index']],
                    ['label' => 'Комментарии', 'icon' => 'fa fa-comment-o', 'url' => ['comment/index']],
                    ['label' => 'Пользователи', 'icon' => 'fa fa-users', 'url' => ['user/index']],
                    ['label' => 'Реклама', 'icon' => 'fa fa-check-square', 'url' => ['advert/index']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Логи',
                        'icon' => 'fa fa-list',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Файловый', 'icon' => 'fa fa-file-text-o', 'url' => ['logs/file'],],
                            ['label' => 'MySQL', 'icon' => 'fa fa-database', 'url' => ['logs/db'],],
                        ],
                    ],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'], 'visible' => (YII_ENV != 'prod')],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'], 'visible' => (YII_ENV != 'prod')],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
