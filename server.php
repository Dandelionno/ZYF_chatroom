<?php
// include_once 'source/websocketserver.class.php';
// include_once 'source/pdo.class.php';
// include_once 'source/user.class.php';
include_once 'init.php';

$server_config = [
//     'worker_num' => 2,
//     'reactor_num'=>8,
//     'task_worker_num'=>1,
//     'dispatch_mode' => 2,
//     'debug_mode'=> 1,
//     'daemonize' => true,
//     'log_file' => __DIR__.'/log/webs_swoole.log',
//     'heartbeat_check_interval' => 60,
//     'heartbeat_idle_time' => 600,
];
$WS_Server = new Websocket_Server("0.0.0.0", 9502, $server_config);
$WS_Server->run();
exit;



    





