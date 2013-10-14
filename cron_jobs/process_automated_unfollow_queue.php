<?php
set_time_limit(0);
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
include_once 'myOAuth.php';
$sql= "SELECT * FROM `ta_automated_unfollow_queue` GROUP BY `user_id`";
$temp  = runQuery($sql);
for($i=0;$i<count($temp);$i++)
{
	$auq_id				= $temp[$i]['auq_id']; 
	$user_id			= $temp[$i]['user_id']; 
	$unfollow_user_name	= $temp[$i]['unfollow_user_name']; 
	$follow_date		= $temp[$i]['follow_date']; 
	$sql = "SELECT a.`key`, a.`secretkey` FROM `ta_user_keys` a LEFT JOIN  `ta_users` b ON a.`Username` = b.`UserName` WHERE b.`UserID` = '$user_id'";
	$temp2  = runQuery($sql);
	if(count($temp2)>0)
	{
		$myOAuth = new myOAuth($temp2[0]['key'],$temp2[0]['secretkey']);
		$res = $myOAuth->unfollow_user($unfollow_user_name);
		if($res['error'] == '')
		{
			$sql= "DELETE FROM `ta_automated_unfollow_queue` WHERE `auq_id` ='$auq_id'";
			executeQuery($sql);
			$sql= "DELETE FROM `ta_user_followed_keyword_users` WHERE `user_id` ='$user_id' AND `followed_user_name` = '$unfollow_user_name' ";
			executeQuery($sql);
			$sql = "INSERT INTO `ta_automated_unfollow_log` (`user_id`, `unfollow_user_name`, `follow_date`, `unfollow_date`) VALUES ('$user_id', '$unfollow_user_name', '$follow_date', '".date('Y-m-d')."');";
			executeQuery($sql);
		    $sql = "INSERT INTO `ta_api_statistics`(`application`,`apitype`,`username`,`DT`) values ('process_unfollow_queue','friendships/destroy','cron', '".date('Y-m-d H:i:s')."');";
			executeQuery($sql);
		}
			echo "<br/> Success. User ".$user_id.' unfollowed '.$unfollow_user_name;
		}
		else
		{
			echo "<br/> Error: ".$res['error'].". User ".$user_id.' not unfollowed '.$unfollow_user_name;
		}
	}
}
?>