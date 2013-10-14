<?php session_start();
$screen_name	= $_REQUEST['name'];
$email			= $_REQUEST['email'];
$checked_value			= $_REQUEST['twitacc'];
$dt=date('Y-m-d H:i:s');
include_once '../common/secret.php';
include_once '../classes/twitteroauth.php';
include_once '../common/dbconfig.php';
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
if(isset($email))
{
    if(isset($_SESSION['mailid']))
    unset($_SESSION['mailid']); 
    if($checked_value!="")
	{  
	    $getIDs =getUserPASSId($screen_name);
	  	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
		$url = "http://twitter.com/friendships/create/{$checked_value}.json";
		$results = $connection->post($url);
		addapistatinfo("follow","friendships/create",$screen_name, $dt); 
	}
	db_connect();
	$query 		    = "UPDATE `ta_users` SET `Email`='$email' WHERE `UserName` = '$screen_name' ";
	$query_result	=mysql_query($query);
	db_close();
	echo $screen_name;
}
