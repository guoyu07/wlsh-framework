<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-13
 * Time: 上午12:08
 */
class HMysql{
    private $db = false;

    public $affected_rows = 0;
    public $insert_id = 0;

    public function __construct(){
        $this->connect();
    }

    public function connect(){
        $this->db = new mysqli(Yaf\Application::app()->getConfig()->database->host,
            Yaf\Application::app()->getConfig()->database->username,
            Yaf\Application::app()->getConfig()->database->password,
            Yaf\Application::app()->getConfig()->database->database);
        //面向对象的昂视屏蔽了连接产生的错误，需要通过函数来判断
        if(mysqli_connect_error()){
            trigger_error('Connect Error: ' . mysqli_connect_error(),E_USER_ERROR);
        }
        //设置编码
        $this->db->set_charset("utf8");//或者 $mysqli->query("set names 'utf8'")
    }

    public function query($sql){
        $res = $this->db->query($sql);
        if ( $res ){
            $sql_info = explode(" ",ltrim($sql),2);
            $type = strtolower($sql_info[0]);
            if ( $type == "select" ){
                $res = $res->fetch_all(MYSQLI_ASSOC);
            }else if ( $type == "insert" ){
                $this->insert_id = $this->db->insert_id;
                $this->affected_rows = $this->db->affected_rows;
            }else if ( $type == "update" ){
                $this->affected_rows = $this->db->affected_rows;
            }else if ( $type == "delete" ){
                $this->affected_rows = $this->db->affected_rows;
            }
            return $res;
        }else{
            if ( $this->db->ping() ){
                return false;
            }else{ //断线自动重连
                $this->connect();
                return $this->query($sql);
            }
        }
    }

}