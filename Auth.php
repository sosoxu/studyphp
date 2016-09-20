<?php

/**
 * Created by PhpStorm.
 * User: sosoxu
 * Date: 2016/9/20
 * Time: 18:56
 */
/*
 *
 * @ID:      验证登陆类
 *
 * @class:   Auth.class.php
 *
 * @auther:  欣儿
 *
 * @time:    2015/03/12
 *
 * @web:     http://my.oschina.net/xinger
 *
**/
class Auth {
    //外部设置
    //cookie设置
    var $cookie_time;//         7200
    var $cookie_where;//        '/'
    var $cookie_domain;//       'yourweb.com'
    var $cookie_secure;//       1和0
    //数据库设置
    var $select_uid;//          'uid'
    var $select_table;//        'user'
    var $select_usersname;//    'email'
    var $select_password;//     'password'
    //盐
    var $salt;//                "12332"
    var $guest_name;//          'Guest'
    //用户获取值
    var $user_id;
    var $username;
    var $ok;
    var $pre;//                 'auth_'
    var $depr;//                '-'
    //内部变量
    private $pre_username;
    private $pre_password;
    public function __construct($config=array()){
        $this->set($config);
        $this->pre_username=sha1(md5($this->pre.'username'));
        $this->pre_password=sha1(md5($this->pre.'password'));
    }
    public function set($config){
        $this->cookie_time       = isset($config['cookie_time'])?$config['cookie_time']: 7200;
        $this->cookie_where      = isset($config['cookie_where'])?$config['cookie_where']:'/';
        $this->cookie_domain = isset($config['cookie_domain'])?$config['cookie_domain']:'';
        $this->cookie_secure = isset($config['cookie_secure'])?$config['cookie_secure']:'';
        $this->select_uid        = isset($config['select_uid'])?$config['select_uid']:'uid';
        $this->select_table      = isset($config['select_table'])?$config['select_table']:'table';
        $this->select_usersname  = isset($config['select_usersname'])?$config['select_usersname']:'user_name';
        $this->select_password   = isset($config['select_password'])?$config['select_password']:'password';
        $this->salt              = isset($config['salt'])?$config['salt']:'sghsdghsdg';//
        $this->guest_name        = isset($config['guest_name'])?$config['guest_name']:'Guest';//
        $this->pre               = isset($config['auth'])?$config['auth']:'auth_';
        $this->depr              = isset($config['depr'])?$config['depr']:'-';
    }
    //
    public function init(){
        $this->user_id       = 0;
        $this->username      = $this->guest_name;
        $this->ok            = false;
        if(!$this->check_session()){
            $this->check_cookie();
        }
        return $this->ok;
    }
    //验证SESSION
    private function check_session(){
        if(!empty($_SESSION[$this->pre_username])&&!empty($_SESSION[$this->pre_password])){
            return $this->check($_SESSION[$this->pre_username],$_SESSION[$this->pre_password]);
        } else {
            return false;
        }
    }
    //验证COOKIE
    private function check_cookie(){
        if(!empty($_COOKIE[$this->pre_username])&&!empty($_COOKIE[$this->pre_password])){
            return $this->check($_COOKIE[$this->pre_username],$_COOKIE[$this->pre_password]);
        } else {
            return false;
        }
    }
    //登陆
    public function login($username,$password){
        $sql    = "select ".$this->select_uid." from ".$this->select_table." where ".$this->select_usersname."='$username' and ".$this->select_password."='$password'";
        $result = mysql_query($sql);
        $rows   = mysql_num_rows($sql);
        if($rows==1){
            $this->user_id   = mysql_result($result,0,0);
            $this->username  = $username;
            $this->ok        = true;
            $username   = $username.$this->depr.$this->get_ip();
            $user_name  = $this->encrypt($username,'E',$this->salt);
            $_SESSION[$this->pre_username]=$user_name;
            $_SESSION[$this->pre_password]=md5(md5($password,$this->salt));
            setcookie($this->pre_username,$user_name,time()+$this->cookie_time,$this->cookie_where,$this->cookie_domain,$this->cookie_secure);
            setcookie($this->pre_password,md5(md5($password,$this->salt)),time()+$this->cookie_time,$this->cookie_where,$this->cookie_domain,$this->cookie_secure);
            return true;
        }
        return false;
    }
    //验证
    private function check($username,$password){
        $user_name  = $this->encrypt($username,'D',$this->salt);
        $name       = explode($this->depr, $user_name);
        $username   = $name[0];
        $ip         = isset($name[1]) ? $name[1] : NULL;
        if($ip !== $this->get_ip()) return false;
        static $vars = array();
        if(!empty($vars)&&is_array($vars)&&isset($vars[$username.$password])){
            $this->user_id   = $vars['user_id'];
            $this->username  = $vars['username'];
            $this->ok        = $vars['ok'];
            return true;
        }
        $sql    = "select ".$this->select_uid.",".$this->select_password." from ".$this->select_table." where ".$this->select_usersname."='$username'";
        $query  = mysql_query($sql);
        $result = mysql_fetch_array($query);
        $row    = mysql_num_rows($sql);
        if($row == 1){
            $db_password=$result[$this->select_password];
            if(md5(md5($db_password,$this->salt)) == $password){
                $this->user_id   = $vars['user_id']  = $result[$this->select_uid];
                $this->username  = $vars['username'] = $username;
                $this->ok        = $vars['ok']       = true;
                $vars[$username.$password]          = md5($username.$password);
                return true;
            }
        }
        return false;
    }
    //退出
    public function logout(){
        $this->user_id       = 0;
        $this->username      = $this->guest_name;
        $this->ok            = false;
        $_SESSION[$this->pre_username]="";
        $_SESSION[$this->pre_password]="";
        setcookie($this->pre_username,"",time()-$this->cookie_time,$this->cookie_where,$this->cookie_domain,$this->cookie_secure);
        setcookie($this->pre_password,"",time()-$this->cookie_time,$this->cookie_where,$this->cookie_domain,$this->cookie_secure);
    }
    //加密
    public function encrypt($string,$operation,$key='') {
        $key=md5($key);
        $key_length=strlen($key);
        $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
        $string_length=strlen($string);
        $rndkey=$box=array();
        $result='';
        for($i=0;$i<=255;$i++)
        {
            $rndkey[$i]=ord($key[$i%$key_length]);
            $box[$i]=$i;
        }
        for($j=$i=0;$i<256;$i++)
        {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp=$box[$i];
            $box[$i]=$box[$j];
            $box[$j]=$tmp;
        }
        for($a=$j=$i=0;$i<$string_length;$i++)
        {
            $a=($a+1)%256;
            $j=($j+$box[$a])%256;
            $tmp=$box[$a];
            $box[$a]=$box[$j];
            $box[$j]=$tmp;
            $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
        }
        if($operation=='D')
        {
            if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8))
            {
                return substr($result,8);
            }
            else
            {
                return'';
            }
        }
        else
        {
            return str_replace('=','',base64_encode($result));
        }
    }
    public function get_ip() {
        return $_SERVER['REMOTE_ADDR'];
    }
}