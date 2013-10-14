<?php 
session_start();
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
$username = $_SESSION['username'];
$sql= "SELECT `UserID` FROM `ta_users` WHERE `UserName` = '$username'";
$temp  = runQuery($sql);
if(count($temp)>0)
{
	$user_id = $temp[0]['UserID'];
	$sql= "SELECT COUNT(*) AS cnt FROM `ta_automated_unfollow_settings` WHERE user_id = '$user_id'";
	$temp  = runQuery($sql);
	if($temp[0]['cnt']==0)
	{
		$sql= "INSERT INTO `ta_automated_unfollow_settings` (`aus_id`, `user_id`, `wait_span`, `status`) VALUES (NULL, '$user_id', '".$_POST['wait_span']."', '".$_POST['flag']."');";
		executeQuery($sql);
	}
	else
	{
		$sql= "UPDATE `ta_automated_unfollow_settings` SET `wait_span` = '".$_POST['wait_span']."', `status` = '".$_POST['flag']."' WHERE user_id = '$user_id'";
		executeQuery($sql);
	}
	echo 'success';
}
else
{
	echo 'failed';
}