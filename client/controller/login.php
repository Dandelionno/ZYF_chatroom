<?php

$GV['page']['title'] = '登录';


if(isset($_GET['act']))
{
    $act = $_GET['act'];
    $response = [
        'result'=>true,
        'data'=>'',
    ];
    switch ($act)
    {
        case 'login':            
            $userName = trim($_POST['username']);
            $pwd = trim($_POST['pwd']);
            $isRemPwd = intval($_POST['rempwd']);
            
            if($userName=='' || $pwd=='')
            {
                $response['result'] = false;
                $response['data'] = '用户名或者密码不能为空';
                break;
            }            
            
            $UserCls = new User();
            $userInfo = $UserCls->getUser(['username'=>$userName], '*');
            if(count($userInfo) <= 0)
            {
                $response['result'] = false;
                $response['data'] = '用户名错误';
                break;
            }
            $userInfo = $userInfo[0];
            
            if( !$UserCls->checkUserPwd($userInfo['password'], $pwd) )
            {
                $response['result'] = false;
                $response['data'] = '密码错误';
                break;
            }
            
            //记住密码
            if($isRemPwd == 1)
            {
                $isRemember = json_encode([
                    'username'=>$userInfo['username'],
                    'pwd'=>$pwd,
                ], JSON_UNESCAPED_UNICODE);
                setcookie('isRemember', $isRemember, time()+3600*24*365, '/');
            }else{
                setcookie('isRemember', '', time()-100, '/');
            }
            
            $userInfo = json_encode([
                'userid'=>$userInfo['id'],
                'username'=>$userInfo['username'],
            ], JSON_UNESCAPED_UNICODE);
            setcookie(User::CURRUSERINFO_KEY, $userInfo, time()+3600*24,  '/');
            
            
            $response['data'] = [
                'url'=>V_SERVER_HOST."/index.php?m=client",
            ];
            break;
    }
    
    echo json_encode($response);
    exit;
}

//是否记住密码
$isRemember = false;
$userInfo_rem = [];
if(isset($_COOKIE['isRemember']))
{    
    if(count($_COOKIE['isRemember']) > 0)
    {
        $isRemember = true;
        $userInfo_rem = $_COOKIE['isRemember'];
        $userInfo_rem = json_decode($userInfo_rem, true);
    }
}


$TV['isRemember'] = $isRemember;
$TV['userInfo_rem'] = $userInfo_rem;

