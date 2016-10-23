<?php
return [
    'language' => 'en-US',
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
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => '616365204145-8n22kcvmq7lvi9ldsahdsq1vh65g8l0b.apps.googleusercontent.com',
                    'clientSecret' => 'amtIr4rLG0gDkOEGp3eHEJkJ',
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
                /*'odnoklassniki' => [
                    'class' => 'frontend\components\auth\Odnoklassniki',
                    'applicationKey' => 'CBANKJELEBABABABA',
                    'clientId' => '1246276608',
                    'clientSecret' => '5D187AE7585B556E04E28BDA',
                    'scope' => 'email',
                ],*/
                'yandex' => [
                    'class' => 'yii\authclient\clients\YandexOAuth',
                    'clientId' => '2de9eb2993f341eea212f95b71b11429',
                    'clientSecret' => 'd23cc79f700a49bc891c1c621bee1f5c',
                ],
                'mailru' => [
                    'class' => 'frontend\components\auth\Mailru',
                    'clientId' => '742178',
                    'clientSecret' => '18d8ee2f97a100edeee850456577ef30',
                ],
                // и т.д.
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
    ],
];
