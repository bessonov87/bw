<?php

/* Rewrite страниц категорий без слэша на конце на страницы со слэшом */
$uri = $_SERVER['REQUEST_URI'];
$pattern0 = '@^.*/$@si';
$pattern1 = '/\.(html|xml|gif|png|jpg|css|js)/si';
$pattern2 = '/^\/(site|gii|ajax|debug)\/.*$/si';

if(!preg_match($pattern0, $uri) && !preg_match($pattern1, $uri) && !preg_match($pattern2, $uri)){
    $protocol = $_SERVER['HTTPS'] ? 'https://' : 'http://';
    $address = $protocol.$_SERVER['HTTP_HOST'].$uri.'/';
    header("HTTP/1.1 301 Moved Permanently");
    header('Location: '.$address);
    exit();
}

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

mb_internal_encoding("UTF-8");