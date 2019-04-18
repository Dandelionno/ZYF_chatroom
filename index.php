<?php 

include_once 'init.php';


$module = isset($_GET['m']) ? $_GET['m'] : 'login';

$GV_T = [
    'page'=>[
        'title'=>'',
        'module'=>$module,
    ]
];
$GV = &$GV_T;


$smarty = new Smarty();
$smarty->template_dir = WEBROOTPATH."/client/tpl";
$smarty->compile_dir = WEBROOTPATH."/data/cache/templates";
$smarty->cache_dir = WEBROOTPATH."/data/cache/smartycache";//指定缓存存放目录


include_once WEBROOTPATH."/client/controller/layout.php";




