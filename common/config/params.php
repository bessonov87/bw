<?php
return [
    'fullAccessIps' => ['127.0.0.1', '37.26.135.215'],
    'adminEmail' => 'admin@beauty-women.ru',
    'supportEmail' => 'support@beauty-women.ru',
    'feedbackEmail' => 'weblon@inbox.ru',
    'user.passwordResetTokenExpire' => 3600,
    'user.emailConfirmTokenExpire' => 604800,
    'emailActivation' => true,
    'site' => [
        'title' => 'Beauty Women - Секреты здоровья и красоты современной женщины - Женский журнал',
        'shortTitle' => 'Beauty Women - Женский журнал',
    ],
    'comments' => [
        'min_length' => 10,
        'max_length' => 500,
        'max_nesting' => 5,
    ],
    'posts' => [
        'on_page' => 20,
    ],
    'users' => [
        'allowModule' => false,
        'allowAuthorization' => true,
        'allowRegistration' => true,
        'allowSocialAuth' => true,
    ],
];
