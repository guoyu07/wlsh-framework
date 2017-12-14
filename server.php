<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-9
 * Time: 下午5:37
 */
ini_set('memory_limit','2048M');
error_reporting(E_ALL);
//error_reporting(0);
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