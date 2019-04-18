<?php 
$GV['page']['title'] = '聊天室';


$UserCls = new User();
$currUser = $UserCls->getCurrentUser();
if(count($currUser) <= 0)
{
    header("Location:".V_SERVER_HOST."/login.php");
}

$currUserInfo = $UserCls->getUser([
    'username'=>$currUser['username'],
]);
$currUserInfo = $currUserInfo[0];



$TV['currUserInfo'] = $currUserInfo;
$TV['currUser'] = $currUser;


