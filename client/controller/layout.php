<?php 
$TV_T = [];
$TV = &$TV_T;


$filePath = WEBROOTPATH."/client/controller/{$module}.php";
if(file_exists($filePath))
{
    include_once $filePath;
}else{
    echo "module not exist！";
    exit;
}



$smarty->assignByRef('GV', $GV);
$smarty->assignByRef('TV', $TV);

$smarty->display('layout.html');

