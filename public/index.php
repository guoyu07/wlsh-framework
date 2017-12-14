<?php
define('APP_DEBUG',true);
if(APP_DEBUG){
    error_reporting(E_ALL);//使用error_reporting来定义哪些级别错误可以触发
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

//header('content-Type:text/html;charset=utf-8;');
$app = new Yaf\Application( ROOT_PATH . "/conf/application.ini");

$app->bootstrap()->run();

