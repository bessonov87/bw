<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => $params['site']['shortTitle'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'post/short',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => '\frontend\components\SlUrlManager',
            'rules' => [
                [
                    'pattern' => 'page/<page:\d+>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'type' => 'index']
                ],
                [
                    'pattern' => 'user/<username:[А-Яа-яA-Za-z0-9_-]+>',
                    'route' => 'user/profile',
                    'suffix' => '/',
                ],
                [
                    'pattern' => '<cat:[/A-Za-z0-9_-]+>/<id:\d+>-<alt:[A-Za-z0-9_-]+>',
                    'route' => 'post/full',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<year:[0-9]{4}>/<month:[0-9]{2}>/<day:[0-9]{2}>/page/<page:[0-9]{1,4}>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'month' => 0, 'day' => 0, 'type' => 'byDate']
                ],
                [
                    'pattern' => '<year:[0-9]{4}>/<month:[0-9]{2}>/<day:[0-9]{2}>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'month' => 0, 'day' => 0, 'type' => 'byDate']
                ],
                [
                    'pattern' => '<cat:[/A-Za-z0-9_-]+>/page/<page:\d+>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'type' => 'byCat']
                ],
                [
                    'pattern' => '<cat:[/A-Za-z0-9_-]+>/<page:\d+>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'type' => 'byCat']
                ],
                [
                    'pattern' => 'sitemap',
                    'route' => 'site/sitemap',
                    'suffix' => '.xml'
                ],
            ],
        ],
    ],
    'params' => $params,
];
