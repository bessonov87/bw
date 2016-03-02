<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;

/**
 * Class ServerInfo Виджет, выводящий общую информацию о сервере на странице Dashboard
 * @package app\components\widgets
 */
class ServerInfo extends Widget
{
    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run(){
        return $this->render('server-info', ['serverInfo' => $this->serverInfo]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site/widgets';
    }

    /**
     * Возвращает информацию о сервере
     *
     * @return mixed
     */
    public function getServerInfo(){
        $dbInfo = Yii::$app->db->createCommand( "SHOW TABLE STATUS" )->queryAll();
        $dbsize = 0;
        foreach($dbInfo as $row){
            $dbsize += $row[ "Data_length" ] + $row[ "Index_length" ];
        }
        $dbInfo = Yii::$app->db->createCommand("SELECT VERSION()")->queryOne(\PDO::FETCH_NUM);
        // Ip сервера
        $serverInfo['server_ip'] = $_SERVER['SERVER_ADDR'];
        // Версия MySQL
        $serverInfo['mysql_version'] = $dbInfo[0];
        // Имя базы данных
        $serverInfo['mysql_db'] = $this->getDsnAttribute('dbname', Yii::$app->getDb()->dsn);;
        // Размер базы данных
        $serverInfo['mysql_size'] = Yii::$app->formatter->asShortSize($dbsize);
        // Версия PHP
        $serverInfo['php_version'] = phpversion();
        // PHP Memory Limit
        $serverInfo['max_memory'] = (@ini_get( 'memory_limit' ) != '') ? @ini_get( 'memory_limit' ) : "Недоступно";
        // PHP запрещенные функции
        $serverInfo['disabled_functions'] = (mb_strlen( ini_get( 'disable_functions' ) ) > 1) ? str_replace( ",", ", ", @ini_get( 'disable_functions' )) : "Недоступно";
        // Php safe mode
        $serverInfo['safe_mode'] = (@ini_get( 'safe_mode' ) == 1) ? '<div class="red">Включен</div>' : 'Выключен';
        // Mod Rewrite
        if( function_exists( 'apache_get_modules' ) ) {
            if( array_search( 'mod_rewrite', apache_get_modules() ) ) {
                $mod_rewrite = "Включен";
            } else {
                $mod_rewrite = '<div class="red">Выключен</div>';
            }
        } else {
            $mod_rewrite = '<div class="red">Не найден</div>';
        }
        $serverInfo['mod_rewrite'] = $mod_rewrite;
        // Версия ОС
        $serverInfo['os_version'] = @php_uname( "s" ) . " " . @php_uname( "r" );
        // Версия GD
        if ( function_exists( 'gd_info' ) ) {
            $array=gd_info ();
            $gdversion = "";
            $gdversion .= $array['GD Version'];
        } else $gdversion = '<div class="red">Не найден</div>';
        $serverInfo['gd_version'] = $gdversion;
        // Максимальный размер загружаемого файла
        $serverInfo['max_upload'] = Yii::$app->formatter->asShortSize( str_replace( array ('M', 'm' ), '', @ini_get( 'upload_max_filesize' ) ) * 1024 * 1024 );
        // Свободное место на диске
        $serverInfo['disc_free_space'] = Yii::$app->formatter->asShortSize( @disk_free_space( "." ) );


        return $serverInfo;
    }

    /**
     * Выбирает атрибут из строки dsn PDO
     *
     * @param string $name Имя атрибута
     * @param string $dsn
     * @return string|null
     */
    private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}