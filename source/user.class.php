<?php 

class User extends PDO_DB
{
    const CURRUSERINFO_KEY = 'currentUserInfo';
    
    public function getUser($sarray=[], $select='')
    {
        $where = " 1 ";        
        if(count($sarray) > 0)
        {
            if(isset($sarray['username']))
            {
                $userName = trim($sarray['username']);
                $where .= " and username='{$userName}' ";
            }     
            if(isset($sarray['id']))
            {
                $id = intval($sarray['id']);
                $where .= " and id='{$id}' ";
            }  
        }
        
        $select = $select=='' ? 'id,username,image' : $select;
        
        $sql = "select {$select} from `".$this->table('user')."` where {$where}";
        
        $res = $this->query($sql);
        
        return $res;
    }
    
    public function checkUserPwd($pwd, $post_pwd)
    {
        $pwd = trim($pwd);
        $post_pwd = trim($post_pwd);
        return password_verify($post_pwd, $pwd);
    }
    
    public function getCurrentUser()
    {
        $currUserInfo = [];
        if(isset($_COOKIE[self::CURRUSERINFO_KEY]))
        {
            $currUserInfo = $_COOKIE[self::CURRUSERINFO_KEY];
            $currUserInfo = json_decode($currUserInfo, true);
        }
        
        return $currUserInfo;
    }
}