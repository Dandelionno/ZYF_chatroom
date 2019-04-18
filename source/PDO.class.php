<?php 
class PDO_DB
{
    public $db_conn = null;
    private $affectRowsNum = 0;
    private $dbType = "";
    public $table_prefix;
    
    function __construct($config)
    {
        $host = $config['host'];
        $dbName = $config['dbname'];
        $userName = $config['username'];
        $pwd = $config['pwd'];
        $is_persistent = isset($config['is_persistent']) ? true: false;
        
        $this->table_prefix = $config['table_prefix'];
        
        $this->db_connect($host, $dbName, $userName, $pwd, $is_persistent);
    }
    
    public function db_connect($host, $dbName, $user, $pwd, $is_persistent=false, $dbType="mysql")
    {
        try
        {
            $attr_arr = array();
            if($is_persistent)
            {
                $attr_arr = array(PDO::ATTR_PERSISTENT => true);
            }
            $pdo_db_conn = new PDO("{$dbType}:host={$host};dbname={$dbName}", $user, $pwd, $attr_arr);
            
        }catch ( PDOException $e)
        {
            die ("Error: " . $e->getMessage() . "\n");
        }
        
        $pdo_db_conn->exec("SET sql_mode=''");
        $pdo_db_conn->exec("SET NAMES 'utf8'");
        
        $this->dbType = $dbType;
        $this->db_conn = $pdo_db_conn;
        
        return $pdo_db_conn;
    }
    
    public function query($sql, $if_fetch = true)
    {        
        $rs = $this->db_conn->query($sql);
        $res = [];
        
        if($this->db_conn->errorCode() > 0)
        {
            echo $this->dbType.":执行时出现错误。错误码（".$this->db_conn->errorCode()."）"."，错误信息：".print_r($this->db_conn->errorInfo(), true);
            
        }else
        {
            if($if_fetch)
            {
                $res = $rs->fetchAll(PDO::FETCH_ASSOC);
            }
            
            $this->affectRowsNum = $rs->rowCount();
        }
        
        return $res;
    }
    
    public function insert($tableName, $fieldSet)
    {
        if($tableName == ""){ return false; }
        $tsql_set = $this->Array2SetSql($fieldSet);
        if($tsql_set == ""){ return false; }
        
        $insert_sql = "insert into ".$this->table($tableName)." set $tsql_set";
        $this->query($insert_sql);
        
        return $this->insert_id();
    }
    
    public function update($tableName, $wherecond, $fieldSet)
    {        
        if($tableName == ""){ return false; }
        if($wherecond == ""){ return false; }
        $tsql_set = $this->Array2SetSql($fieldSet);
        if($tsql_set == ""){ return false; }
        
        $update_sql = "update ".$this->table($tableName)." set $tsql_set where $wherecond";
        $this->query($update_sql);         
        if($this->errno() != 0){ return false; }
        
        return true;
    }
    
    public function delete($tableName, $wherecond)
    {
        if($tableName == ""){ return false; }
        if($wherecond == ""){ return false; }
        
        $delete_sql = "delete from ".$this->table($tableName)." where $wherecond";
        
        $this->query($delete_sql);   
        if($this->errno() != 0){ return false; }
        
        return true;
    }
    
    public function batchInsert($tableName, $colunms, $insertData)
    {
        
    }
    
    public function getAffectedRowsNum()
    {
        return $this->affectRowsNum;
    }
    
    function insert_id()
    {
        if($this->db_conn == null ){ return 0;}
        
        return $this->db_conn->lastInsertId();
    }
    
    function table($tableName)
    {
        return $this->table_prefix.$tableName;
    }
    
    function Array2SetSql($arr)
    {
        if(empty($arr)){ return "";}
        
        $tsql = "";
        
        foreach ($arr as $key=>$value)
        {
            if(!is_numeric($value))
            {
                $value = "'$value'";
            }
            $tsql .= "$key=$value,";
        }
        //去掉最后一个逗号
        if(substr($tsql, strlen($tsql)-1,1) == ","){ $tsql = substr($tsql, 0 , strlen($tsql)-1);}
        
        return $tsql;
    }
    
    function pdo_ping(){
        try{            
            $this->db_conn->getAttribute(PDO::ATTR_SERVER_INFO);
        } catch (PDOException $e) {
            if(strpos($e->getMessage(), 'MySQL server has gone away')!==false){
                return false;
            }
        }
        return true;
    }
    
    function error() {
        if($this->db_conn == null ){ return "";}
        
        $errorInfo = $this->db_conn->errorInfo();
        return $errorInfo[2];
    }
    
    function errno() {
        
        if($this->db_conn == null ){ return 0;}
        
        $errorInfo = $this->db_conn->errorInfo();
        return intval($errorInfo[1]);
    }
}
