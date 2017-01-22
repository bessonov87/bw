<?php
return [
    //
    [
        'pattern' => 'tablica-kalorijnosti/<category>/<product>',
        'suffix' => '/',
        'route' => 'calory/view',
    ],
    [
        'pattern' => 'tablica-kalorijnosti/<category>/page/<page>',
        'suffix' => '/',
        'route' => 'calory/category',
    ],
    [
        'pattern' => 'tablica-kalorijnosti/<category>',
        'suffix' => '/',
        'route' => 'calory/category',
    ],
    [
        'pattern' => 'tablica-kalorijnosti',
        'suffix' => '/',
        'route' => 'calory/index',
    ],
    // СОВМЕСТИМОСТЬ
    [
        'pattern' => 'znaki-zodiaka/sovmestimost/<znakWoman:[a-z]+>-woman/<znakMan:[a-z]+>-man',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/sovmestimost',
    ],
    [
        'pattern' => 'znaki-zodiaka/sovmestimost/<znakWoman:[a-z]+>-woman',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/sovmestimost-index',
        'defaults' => ['znak' => null, 'znakMan' => null]
    ],
    [
        'pattern' => 'znaki-zodiaka/sovmestimost/<znakMan:[a-z]+>-man',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/sovmestimost-index',
        'defaults' => ['znak' => null, 'znakWoman' => null]
    ],
    [
        'pattern' => 'znaki-zodiaka/sovmestimost/tablitsa',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/tablitsa-sovmestimosti',
        'defaults' => ['znak' => null, 'znakMan' => null, 'znakWoman' => null]
    ],
    [
        'pattern' => 'znaki-zodiaka/sovmestimost',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/sovmestimost-index',
        'defaults' => ['znak' => null, 'znakMan' => null, 'znakWoman' => null]
    ],
    // ЗНАКИ ЗОДИАКА
    [
        'pattern' => 'znaki-zodiaka/<znak:[a-z]+>/sovmestimost',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/sovmestimost-index',
        'defaults' => ['znakMan' => null, 'znakWoman' => null]
    ],
    [
        'pattern' => 'znaki-zodiaka/<znak:[a-z]+>/<type:[a-z]+>',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/znak'
    ],
    [
        'pattern' => 'znaki-zodiaka/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/znak',
        'defaults' => ['type' => 'common']
    ],
    [
        'pattern' => 'znaki-zodiaka',
        'suffix' => '/',
        'route' => 'znaki-zodiaka/index',
    ],
    // НА ДЕНЬ
    [
        'pattern' => 'horoscope/na-zavtra/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/day',
        'defaults' => ['den' => 'zavtra']
    ],
    [
        'pattern' => 'horoscope/na-zavtra',
        'suffix' => '/',
        'route' => 'horoscope/day',
        'defaults' => ['den' => 'zavtra', 'znak' => null]
    ],
    [
        'pattern' => 'horoscope/na-segodnja/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/day',
        'defaults' => ['den' => 'segodnja']
    ],
    [
        'pattern' => 'horoscope/na-segodnja',
        'suffix' => '/',
        'route' => 'horoscope/day',
        'defaults' => ['den' => 'segodnja', 'znak' => null]
    ],
    // НА НЕДЕЛЮ
    [
        'pattern' => 'horoscope/na-sledujushhuju-nedelju/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/week',
        'defaults' => ['week' => 'next']
    ],
    [
        'pattern' => 'horoscope/na-sledujushhuju-nedelju',
        'suffix' => '/',
        'route' => 'horoscope/week',
        'defaults' => ['week' => 'next', 'znak' => null]
    ],
    [
        'pattern' => 'horoscope/na-nedelju/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/week',
        'defaults' => ['week' => 'this']
    ],
    [
        'pattern' => 'horoscope/na-nedelju',
        'suffix' => '/',
        'route' => 'horoscope/week',
        'defaults' => ['week' => 'this', 'znak' => null]
    ],
    // НА МЕСЯЦ
    [
        'pattern' => 'horoscope/na-mesjac/<year:[0-9]+>/<month:[0-9]+>/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/month',
    ],
    [
        'pattern' => 'horoscope/na-mesjac/<year:[0-9]+>/<month:[0-9]+>',
        'suffix' => '/',
        'route' => 'horoscope/month',
        'defaults' => ['znak' => null]
    ],
    [
        'pattern' => 'horoscope/na-mesjac/<year:[0-9]+>',
        'suffix' => '/',
        'route' => 'horoscope/month',
        'defaults' => ['month' => null, 'znak' => null]
    ],
    [
        'pattern' => 'horoscope/na-mesjac',
        'suffix' => '/',
        'route' => 'horoscope/month',
        'defaults' => ['year' => null, 'month' => null, 'znak' => null]
    ],
    // НА ГОД
    [
        'pattern' => 'horoscope/na-god/<year:[0-9]+>/<znak:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/year',
    ],
    [
        'pattern' => 'horoscope/na-god/<year:[0-9]+>',
        'suffix' => '/',
        'route' => 'horoscope/year',
        'defaults' => ['znak' => null]
    ],
    [
        'pattern' => 'horoscope/na-god',
        'suffix' => '/',
        'route' => 'horoscope/year',
        'defaults' => ['year' => null, 'znak' => null]
    ],
    [
        'pattern' => 'horoscope',
        'suffix' => '/',
        'route' => 'horoscope/index',
        'defaults' => ['type' => 'common', 'period' => 'index']
    ],
    // ЛУННЫЙ КАЛЕНДАРЬ СТРИЖЕК
    [
        'pattern' => 'horoscope/lunnyj-kalendar-strizhek',
        'suffix' => '/',
        'route' => 'horoscope/hair-calendar',
    ],
    [
        'pattern' => 'horoscope/lunnyj-kalendar-strizhek/<year:[0-9]+>/<month:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/hair-month-calendar',
    ],
    [
        'pattern' => 'horoscope/lunnyj-kalendar-strizhek/<year:[0-9]+>',
        'suffix' => '/',
        'route' => 'horoscope/hair-year-calendar',
    ],
    // ЛУННЫЙ КАЛЕНДАРЬ
    [
        'pattern' => 'horoscope/lunnyj-kalendar-na-god',
        'suffix' => '/',
        'route' => 'horoscope/moon-calendar',
    ],
    [
        'pattern' => 'horoscope/lunnyj-kalendar-na-god/<year:[0-9]+>/<month:[a-z]+>/<day:[0-9]+>',
        'suffix' => '/',
        'route' => 'horoscope/moon-day-calendar',
    ],
    [
        'pattern' => 'horoscope/lunnyj-kalendar-na-god/<year:[0-9]+>/<month:[a-z]+>',
        'suffix' => '/',
        'route' => 'horoscope/moon-month-calendar',
    ],
    [
        'pattern' => 'horoscope/lunnyj-kalendar-na-god/<year:[0-9]+>',
        'suffix' => '/',
        'route' => 'horoscope/moon-year-calendar',
    ],
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
        'pattern' => 'user/<username:[А-Яа-яA-Za-z0-9_-]+>/<action:[a-z0-9]+>',
        'route' => 'user/<action>',
        'suffix' => '/',
    ],
    [
        'pattern' => '<cat:[/A-Za-z0-9_-]+>/<id:\d+>-<alt:[A-Za-z0-9_-]+>',
        'route' => 'post/redirect',
        'suffix' => '/'
    ],
    [
        'pattern' => '<id:\d+>-<alt:[A-Za-z0-9_-]+>',
        'route' => 'post/redirect',
        'suffix' => '.html'
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
        'pattern' => '<xmlname:[A-Za-z0-9_-]+>.xml',
        'route' => 'site/xml'
    ],
];