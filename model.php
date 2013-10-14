<?php
        /*
         * @author: Md. Mahmud Ahsan
         * @visit: http://thinkdiff.net
         * @description: database functionalities
         */
include_once "config/config.php";		 
		 print "inside model";
class Model{
    private $host   =   '';
    private $user   =   '';
    private $pass   =   '';
    private $db     =   '';

    function __construct($dbconfig){
        $this->host     =  HOST;
        $this->user     =  USERNAME;
        $this->pass     =  PASSWORD;
        $this->db       =   DATABASE;
    }

    function connectDb(){
		print "db connect";
        $link = mysql_connect($this->host , $this->user , $this->pass );
        if (!$link){
            die (mysql_error());
        }
        mysql_select_db($this->db);

    }

    function closeDb(){
        mysql_close();
    }

    function query($sql){
        $this->connectDb();
        $data      =  array();
        $result    =  mysql_query($sql);

        if (!empty($result))
        $rows      =  mysql_num_rows($result);
        else
        $rows      =  '';

        if (!empty($rows)){
            while ($rows = mysql_fetch_assoc($result)){
                $data[]   = $rows;
            }
        }
        $this->closeDb();

        return $data;
    }

    function insert($sql){
        $this->connectDb();
        $result    =  mysql_query($sql);
        $this->closeDb();
        return $result;
    }

    function insertAndGetId($sql){
        $this->connectDb();
        $result    =  mysql_query($sql);
        $id        =  mysql_insert_id();
        $this->closeDb();
        return $id;
    }

    function update($sql){
        $this->connectDb();
        mysql_query($sql);
        $this->closeDb();
    }
    function delete($sql){
        $this->connectDb();
        mysql_query($sql);
        return mysql_affected_rows();
        $this->closeDb();
    }
}
?>
