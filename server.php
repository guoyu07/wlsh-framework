<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-9
 * Time: 下午5:37
 */
define('APP_DEBUG',true);
if(APP_DEBUG){
    error_reporting(E_ALL);//使用error_reporting来定义哪些级别错误可以触发 -1
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('log_errors', 1);
}else{
    error_reporting(0);
}
ini_set('memory_limit','2048M');
date_default_timezone_set('Asia/Shanghai');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__));
define('CONF_PATH', ROOT_PATH . DS . 'conf');
define('APPLICATION_PATH', ROOT_PATH . DS . 'application');
define('LIBRARY_PATH', APPLICATION_PATH . DS . 'library');
require LIBRARY_PATH . DS . 'HttpServer.php';
$serverObj = HttpServer::getInstance();
$serverObj->setConfigIni(CONF_PATH . DS . 'application.ini');
$serverObj->start();