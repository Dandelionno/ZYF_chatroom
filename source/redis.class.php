<?php 

class MyRedis
{
    protected $redis = null;
    public $redis_ip;
    public $port;
    
    
    public function __construct()
    {
        global $SYS;
        $this->redis_ip = $SYS['redis']['host'];
        $this->port = $SYS['redis']['port'];
        
        $this->redis = new Redis();
        $re = $this->redis->connect($this->redis_ip, $this->port);
        $this->redis->auth($SYS['redis']['auth']);        
    }    
    
    public function set($key, $value)
    {        
        if($this->redis == null){ return false; }
        $this->redis->set($key, $value);
        return true;
    }
    
    public function get($key)
    {
        if($this->redis == null){ return false; }
        
        return $this->redis->get($key);        
    }
    
    public function delete($key)
    {
        $this->redis->delete($key);
        return true;
    }
}


