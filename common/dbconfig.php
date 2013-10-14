<?php
/*----------------------------------------------------------------------
	FileName		:	dbconfig.php
	Date			:	03-May-2010	
	Utility			:	Database connectivity for the entire application.
	Update History	:	
------------------------------------------------------------------------*/
// Database Configuration Variables 
if(file_exists("config/config.php"))
{
include_once ("config/config.php");
}
if(file_exists("../config/config.php"))
{
include_once ("../config/config.php");
}
	$db_host	=	HOST;		//	HostName	
	$db_user	=	USERNAME;			//	UserName	
	$db_pass	=	PASSWORD;			//  Password
	$db_name	=	DATABASE;		//	Database Name
// Database Connection 
	function db_connect()
	{
		global $db_host,$db_user,$db_pass,$db_name;
		$con	=	mysql_connect($db_host,$db_user,$db_pass);	
		if($con)
		{
			mysql_select_db($db_name) or die('Database does not exists !<br>Check your configurtion.<br>'.mysql_error());
		}
		else
		{
			echo "Cannot connect to database server !<br>Check your configuration.";
		}
	}
//  Close Database connection 
	function db_close()
	{
		if($con)
		{
			mysql_close($con);
		}
	}
/*---------------------------------------------------------------------------------
Note	: For each db operations make sure that the db connection is opened, and 
after the operation it is closed. It is highly recommended for synchronization.
-----------------------------------------------------------------------------------*/
?>