<?php 
session_start();
set_time_limit(0);
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
include_once 'myOAuth.php';
$username = $_SESSION['username'];
$sql= "SELECT `UserID` FROM `ta_users` WHERE `UserName` = '$username'";
$temp  = runQuery($sql);
if(count($temp)>0)
{
	$user_id = $temp[0]['UserID'];
	$sql	 = "DELETE FROM `ta_automated_unfollow_queue` WHERE `user_id` = '$user_id'";
	executeQuery($sql);
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
	if($_POST['flag']=='Y')
	{
		$sql = "SELECT a.`key`, a.`secretkey` FROM `ta_user_keys` a LEFT JOIN  `ta_users` b ON a.`Username` = b.`UserName` WHERE b.`UserID` = '$user_id'";
		$key_temp  = runQuery($sql);
		if(count($key_temp)>0)
		{
			$myOAuth = new myOAuth($key_temp[0]['key'],$key_temp[0]['secretkey']);
			$list	 = $myOAuth->not_following_list();
			$wait_span = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-$_POST['wait_span'],date('Y')));
			$sql= "SELECT `followed_user_name`,DATE_FORMAT(`followed_date_time`,'%Y-%m-%d') AS followed_date  FROM `ta_user_followed_keyword_users` WHERE DATE_FORMAT(`followed_date_time`,'%Y-%m-%d') <= '$wait_span' AND  `user_id` ='$user_id'";
			$temp2  = runQuery($sql);
			for($j=0;$j<count($temp2);$j++)
			{
				if(in_array($temp2[$j]['followed_user_name'],$list))
				{
				$sql= "INSERT INTO `ta_automated_unfollow_queue` (`user_id`, `unfollow_user_name`, `follow_date`) VALUES ('$user_id', '".$temp2[$j]['followed_user_name']."', '".$temp2[$j]['followed_date']."')";
				executeQuery($sql);
				}
			}
		}	
	}
	echo 'success';
}
else
{
	echo 'failed';
}