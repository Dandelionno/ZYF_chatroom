<?php 
//定义根目录
define('WEBROOTPATH', __DIR__);

include_once WEBROOTPATH.'/source/pdo.class.php';
include_once WEBROOTPATH.'/source/redis.class.php';
include_once WEBROOTPATH.'/source/user.class.php';
include_once WEBROOTPATH.'/source/websocketserver.class.php';
include WEBROOTPATH.'/source/smarty/Smarty.class.php';


error_reporting(E_ALL);

if(isset($_SERVER['HTTP_HOST']))
{
    define("V_SERVER_HOST", "http://".$_SERVER['HTTP_HOST']);
}


    

$SYS = [
    'db'=>[
        'host'=>'127.0.0.1',
        'dbname'=>'chatroom',
        'username'=>'root',
        'pwd'=>'root',
        'table_prefix'=>'tbl_',
    ],
    'redis'=>[
        'host'=>'127.0.0.1',
        'port'=>6379,
        'auth'=>'123456',
    ],
];


