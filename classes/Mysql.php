<?php
class Mysql extends Database {
	static private $instance;
	static private $instanceVlogic;

	//set database
	public function __construct($dbHost=null, $dbName=null, $dbUser=null, $dbPass=null) {
	//	parent::__construct($dbHost, $dbName, $dbUser, $dbPass);
	parent::__construct(HOST, DATABASE, USERNAME, PASSWORD);
	}
	// function to call constructor


	static function getInstance() {
		if(!Mysql::$instance) {
			Mysql::$instance = new Mysql(HOST, DATABASE, USERNAME, PASSWORD);
		}
		return Mysql::$instance;
	}
	static function getInstanceMysqli() {
		if(!Mysql::$instance) {
			Mysql::$instance = new Mysql(HOST, DATABASE, USERNAME, PASSWORD);
		}
		return Mysql::$instance;
	}
/*
	// calling database class __set function
	public function __set($name, $value) {
		if (isset($name) && isset($value)) {
			parent::__set($name, $value);
		}
	}
	// calling database class __set function
	public function __get($name) {
		if (isset($name)) {
			return parent::__get($name);
		}
	}
	
*/	// Check whether database is connected
	public function Connected() {
		if (is_resource($this->connection)) {
			return true;
		} else {
			return false;
		}
	}

	public function AffectedRows() {
		return mysql_affected_rows($this->connection);
	}
	public function insertId() {
		return mysql_insert_id($this->connection);
	}

	public function NumRows($result) {
		return mysql_num_rows($result);
	}
	// open table
	public function Open() {
		if (is_null($this->database))
		die("MySQL database not selected");
		if (is_null($this->hostname))
		die("MySQL hostname not set");

		$this->connection = @mysql_connect($this->hostname, $this->username, $this->password);

		if ($this->connection === false)
		die("Could not connect to database. Check your username and password then try again.\n");

		if (!mysql_select_db($this->database, $this->connection)) {
			die("Could not select database");
		}
	}

	// close table
	public function Close() {
		mysql_close($this->connection);
		$this->connection = null;
	}
	public function Insert($sql) {
		if ($this->connection === false) {
			die('No Database Connection Found.');
		}

		$result=@mysql_query($sql,$this->connection);
		if ($result === false) {
			die(mysql_error());
		}
	}

	public function Query($sql) {
		if ($this->connection === false) {
			die('No Database Connection Found.');
		}

		$result = @mysql_query($sql,$this->connection);
		if ($result === false) {
			die(mysql_error());
		}
		return $result;
	}

	public function FetchArray($result) {

		if ($this->connection === false) {
			die('No Database Connection Found.');
		}
		// $data = @mysql_fetch_array($result) ;
		$i=0;
		$array1=array();
		while ($data = @mysql_fetch_array($result)){
			$array1[$i]=$data;
			$i++;
		}
		if (!is_array($array1)) {
			die(mysql_error());
		}
		return $array1;
	}

	//-------------- mysqli-------------------------////////
	public function MysqliAffectedRows() {
		return mysqli_affected_rows($this->connection);
	}
	public function MysqliNumRows($result) {
		return mysqli_num_rows($result);
	}
	// open table

	public function MysqliOpen() {
		if (is_null($this->database))
		die("MySQL database not selected");
		if (is_null($this->hostname))
		die("MySQL hostname not set");
		$this->connection = @mysqli_connect($this->hostname, $this->username, $this->password);

		if ($this->connection === false)
		die("Could not connect to database. Check your username and password then try again.\n");

		if (!mysqli_select_db($this->connection,$this->database)) {
			die("Could not select database");
		}
	}
	public function MysqliQuery($sql) {
		if ($this->connection === false) {
			die('No Database Connection Found.');
		}

		$result = @mysqli_query($this->connection,$sql);

		if ($result === false) {
			die(mysqli_error());
		}
		return $result;
	}
	public function MysqliFetchArray($result) {

		if ($this->connection === false) {
			die('No Database Connection Found.');
		}
		// $data = @mysql_fetch_array($result) ;
		$i=0;
		$array1=array();
		while ($data = @mysqli_fetch_array($result)){
			$array1[$i]=$data;
			$i++;
		}
		if (!is_array($array1)) {
			die(mysql_error());
		}
		return $array1;
	}
	public function MysqliClose() {
		mysqli_close($this->connection);
		$this->connection = null;
	}
	//---------------------
	public function escapeDataSlashes($value)
	{
		return( mysql_real_escape_string($value,$this->connection ) );
	}
}
