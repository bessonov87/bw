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
        'description' => 'Женский журнал для красивых женщин. У нас вы найдете диеты, полезные советы, все о моде и о вашем здоровье',
    ],
    'comments' => [
        'min_length' => 10,
        'max_length' => 500,
        'max_nesting' => 5,
    ],
    'posts' => [
        'on_page' => 20,
    ],
    'paths' => [
        'avatar' => '/uploads/fotos/',
    ],
    'users' => [
        'allowModule' => true,
        'allowAuthorization' => true,
        'allowRegistration' => true,
        'allowSocialAuth' => true,
    ],
    'admin' => [
        'images' => [
            'allowedExt' => ['jpg', 'png', 'gif'],
            'max_pixel' => 400,
            'max_pixel_side' => 'width',    // 'width' or 'height'
            'create_thumb' => true,
            'watermark' => false,
        ],
        'files' => [
            'allowedExt' => ['rar', 'zip', 'pdf'],
        ],
    ],
];
