<?php
$ipTest=array(
	'localhost',
	'campain.local',
	// '199.168.188.18'
);
// you need to change this for your timezone
date_default_timezone_set("America/Bogota"); 
error_reporting(E_ALL);

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// define if you are in production mode or not, this maybe more beautiful? tell me please
if(in_array($_SERVER['HTTP_HOST'],$ipTest))
	defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
function __app() { return Yii::app(); }
Yii::createWebApplication($config)->run();