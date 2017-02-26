<?php


$url = $_SERVER['REQUEST_URI'];
$rep_url = str_replace('/index.php', '', $url);
if($url!==$rep_url)
{
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: /'.ltrim($rep_url, '/'));
    exit();
} 

error_reporting(E_ALL);
ini_set('display_errors', 1);
// change the following paths if necessary
$yii=dirname(__FILE__).'/protected/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$functions=dirname(__FILE__).'/protected/config/functions.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($functions);
require_once($yii);
Yii::createWebApplication($config)->run();
