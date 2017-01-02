<?php
return [
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