<?php
ini_set('display_errors', 'On');
ini_set('set_time_limit', '5');
error_reporting(E_ALL ^ E_NOTICE);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../../../../dump/yii_framework/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$floodblocker=dirname(__FILE__).'/protected/security/floodblocker.php';
$detectinjection=dirname(__FILE__).'/protected/security/detectinjection.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
require_once($floodblocker);
require_once($detectinjection);
$flb = new FloodBlocker ("/tmp/");
//70 requests in 10 seconds
  $flb->rules = array ( 10=>50000 );
  $res = $flb->CheckFlood ();
Yii::createWebApplication($config)->run();

  if ( 1==1 )
    {
    }
  else
    die ( 'Too many requests! Please try later.' );
