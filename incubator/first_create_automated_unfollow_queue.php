<?php
set_time_limit(0);
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
include_once 'myOAuth.php';
$sql= "SELECT `user_id`, `wait_span` FROM `ta_automated_unfollow_settings` WHERE status ='Y'";
$temp  = runQuery($sql);
for($i=0;$i<count($temp);$i++)
{
	$sql = "SELECT a.`key`, a.`secretkey` FROM `ta_user_keys` a LEFT JOIN  `ta_users` b ON a.`Username` = b.`UserName` WHERE b.`UserID` = '".$temp[$i]['user_id']."'";
	$key_temp  = runQuery($sql);
	if(count($key_temp)>0)
	{
		$myOAuth = new myOAuth($key_temp[0]['key'],$key_temp[0]['secretkey']);
		$list	 = $myOAuth->not_following_list();
		$wait_span = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-$temp[$i]['wait_span'],date('Y')));
		$sql= "SELECT `followed_user_name`,DATE_FORMAT(`followed_date_time`,'%Y-%m-%d') AS followed_date  FROM `ta_user_followed_keyword_users` WHERE DATE_FORMAT(`followed_date_time`,'%Y-%m-%d') <= '$wait_span' AND  `user_id` ='".$temp[$i]['user_id']."'";
		$temp2  = runQuery($sql);
		for($j=0;$j<count($temp2);$j++)
		{
			if(in_array($temp2[$j]['followed_user_name'],$list))
			{
			$sql= "INSERT INTO `ta_automated_unfollow_queue` (`user_id`, `unfollow_user_name`, `follow_date`) VALUES ('".$temp[$i]['user_id']."', '".$temp2[$j]['followed_user_name']."', '".$temp2[$j]['followed_date']."')";
			executeQuery($sql);
			}
		}
	}	
}
?>