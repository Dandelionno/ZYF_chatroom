<?php 
class Websocket_Server
{
    public $host;
    public $port;
    public $server_config = [];
    protected $event = [];
    protected $ws = null;
    
    /**
     * 在线用户信息$userList
     * 数据格式 [
     *      fd=>[
     *          'userid'=>用户id,
                'username'=>用户名
                'image'=>用户头像,
     *      ], xN
     * ]
     */
    protected $userList = [];
    
    
    function __construct($host="0.0.0.0", $port=9502, $config=[])
    {
        $this->host = $host;
        $this->port = $port;
        $this->server_config = $config;        
    }
    
    public function run()
    {
        //创建websocket服务器对象
        $ws = new swoole_websocket_server($this->host, $this->port);
        
        //服务的基本设置
        $ws->set($this->server_config);
        $this->ws = $ws;
        
        $this->On('open', [$this, 'OnOpen']);
        $this->On('message', [$this, 'OnMessage']);
        $this->On('close', [$this, 'OnClose']);
        
        
        echo "开启websocket服务\n";
        $ws->start();
    }
    
    /**
     * @desc 发送给客户端的信息处理函数
     * string $data 信息内容
     * int $type 信息类型(1:用户信息, 2:系统信息, 3:发送在线用户信息 , 4:程序信息)
     */
    public function formatMsgToClient($data, $type=1){
        $response = [
            'type'=>$type,
            'data'=>$data,
        ];
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    
    public function OnOpen($ws, $request)
    {
//         var_dump($request->fd, $request->get, $request->server);
                
        //通知其他人该用户上线了
        foreach($ws->connections as $conn)
        {
            if($conn == $request->fd){ continue; }
//             $response = $this->formatMsgToClient("编号{$request->fd}上线了", 2);
//             $ws->push($conn, $response);
        }
        
        $response = $this->formatMsgToClient(['fd'=>$request->fd], 4);
        $ws->push($request->fd, $response);
    }
    
    public function OnMessage($ws, $frame)
    {
//         echo "Message: {$frame->data}\n";
        
        $data = json_decode($frame->data, true);
        if(!$data){ return false; }
        
        switch ($data['type'])
        {
            case 1://用户之间发送消息
                foreach($ws->connections as $conn)
                {
                    if($conn == $frame->fd){ continue; }
                    
                    $msg = [
                        'msg'=>$data['data']['msg'],
                        'user'=>$this->userList[$frame->fd],//发送消息的用户信息
                    ];
                    $response = $this->formatMsgToClient($msg, 1);
                    $ws->push($conn, $response);
                }
                
                
                //记录聊天记录
                $chatRecordArr = [
                    'fd'=>$frame->fd,
                    'userid'=>$this->userList[$frame->fd]['userid'],
                    'msg'=>$data['data']['msg'],
                ];
                
                $chatRecordLog = json_encode($chatRecordArr, JSON_UNESCAPED_UNICODE)."\n";
                file_put_contents(WEBROOTPATH.'/data/chatrecord.txt', $chatRecordLog, FILE_APPEND);
                                
                break;
                
            case 3://用户上线传来的用户信息
                $userCls = new User();                
                $userInfo = $userCls->getUser(['id'=>$data['data']['userid']]);
                $userInfo = $userInfo[0];
                
                $this->userList[$data['data']['fd']] = [
                    'userid'=>$userInfo['id'],
                    'username'=>$userInfo['username'],
                    'image'=>$userInfo['image'],
                ];
                
                $this->sendOnlineUserInfo($ws);
                break;
        }       
    }
    
    public function OnClose($ws, $fd)
    {
        unset($this->userList[$fd]);
        echo "client-{$fd} is closed\n";
    }
    
    //把在线的用户信息发送到每个客户端
    public function sendOnlineUserInfo($ws)
    {
        if(!$ws){
            $ws = $this->ws;
        }
        
        
        $onlineUserList = [];
        foreach($this->userList as $fd => $userInfo)
        {
            if(!isset($onlineUserList[$userInfo['userid']]))
            {
                $onlineUserList[$userInfo['userid']] = $userInfo;
            }else{
                continue;//用户可能开了多个页面，这里跳过相同的用户
            }
        }
        
        foreach($ws->connections as $conn)
        {
            $response = $this->formatMsgToClient($onlineUserList, 3);
            $ws->push($conn, $response);
        }
    }
    
    
    //绑定事件
    public function On($event, $callback)
    {
        if($this->ws == null)
        {
            return false;
        }
        if( is_callable($callback) )
        {
            $this->ws->on($event, $callback);
        }
        
        return true;
    }
    
    public function setEvent($name, $function)
    {
        $this->event[$name] = [$name, $function];
        return true;
    }
    
    public function getServer()
    {
        return $this->ws;
    }
}
