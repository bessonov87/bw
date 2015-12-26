<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
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
            'rules' => [
                [
                    'pattern' => '<cat:[A-Za-z0-9_-]+>/<id:\d+>-<alt:[A-Za-z0-9_-]+>',
                    'route' => 'post/full',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<cat:[A-Za-z0-9_-]+>/<page:\d+>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'format' => 'byCat']
                ],
                [
                    'pattern' => '<year:[0-9]{4}>/<month:[0-9]{2}>/<day:[0-9]{2}>/<page:\d+>',
                    'route' => 'post/short',
                    'suffix' => '/',
                    'defaults' => ['page' => 1, 'month' => 0, 'day' => 0, 'format' => 'byDate']
                ],
            ],
        ],
    ],
    'params' => $params,
];
