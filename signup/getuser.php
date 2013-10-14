<?php session_start();
$screen_name	= $_REQUEST['name'];
$email			= $_REQUEST['email'];
$pack			= $_REQUEST['pack'];
include_once '../common/secret.php';
include_once '../classes/twitteroauth.php';
include_once '../common/dbconfig.php';
$oAuthObj 		= new TwitterOAuth($consumer_key,$consumer_secret);
$url 			= 'http://twitter.com/users/show.json';
$x 				= get_object_vars($oAuthObj->get($url,array('screen_name'=>$screen_name)));
if($x['error'] !='') 
{
	echo 'error|Not a valid twitter username.';
}
else
{
	db_connect();
	$query 		= " SELECT COUNT(*) AS cnt FROM `ta_user_subscriptions` WHERE `UserName` = '$screen_name' AND `PackageID` !='0' ";
	$x 			= mysql_fetch_array(mysql_query($query));
	db_close();
	if($x['cnt'] !=0) 
	{
		echo 'error|you are a subscribed user, please login via "Login with twitter" in home page.';
	}
	else
	{
		echo "true|$screen_name/brk/$email/brk/$pack/brk/$_SESSION[affiliateid]";
	}
}