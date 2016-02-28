<?php
return [
    'language' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOpenId'
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '980427198678106',
                    'clientSecret' => '32c93df394004bbce4684fcaf584f524',
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '5321829',
                    'clientSecret' => 'ZpCs0DRICDe9xJpArFOp',
                    'scope' => 'email',
                ],
                'odnoklassniki' => [
                    'class' => 'frontend\components\auth\Odnoklassniki',
                    'applicationKey' => 'odnoklassniki_app_public_key',
                    'clientId' => 'odnoklassniki_app_id',
                    'clientSecret' => 'odnoklassniki_client_secret',
                ],
                'yandex' => [
                    'class' => 'yii\authclient\clients\YandexOAuth',
                    'clientId' => '2de9eb2993f341eea212f95b71b11429',
                    'clientSecret' => 'd23cc79f700a49bc891c1c621bee1f5c',
                ],
                // и т.д.
            ],
        ]
    ],
];
