<?php
include_once '../classes/dbClient.php';
include ('../common/sqlFunctions.php');

/*$user_update_sql1="update ta_keyword_users SET KeywordStatus='A' where `UserId` IN (select UserID from  ta_users  where DATEDIFF(now(), login_date) <7)";
runQuery($user_update_sql1);
$user_update_sql2="update ta_keyword_users SET KeywordStatus='B' where `UserId` IN (select UserID from  ta_users  where DATEDIFF(now() ,login_date) >7)";
runQuery($user_update_sql2);
*/
$query = "SELECT `id`, `keyId`, `UserId`,`KeywordStatus`  FROM `ta_keyword_users`";
$temp  = runQuery($query);
for($i=0;$i<count($temp);$i++)
{
	$cdate = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-3,date('Y')));
	$query = "SELECT COUNT(*) AS cnt FROM `ta_user_followed_keyword_users` WHERE `user_id` = '".$temp[$i]['UserId']."' AND `key_id` = '".$temp[$i]['keyId']."' AND DATE_FORMAT(`followed_date_time`,'%Y-%m-%d') >= '$cdate' ";
	$temp2 = runQuery($query);
	if($temp2[0]['cnt'] == 0)
	{
		$status = 'B';
	}
	else
	{
		$status = 'A';
	}
	$query = "UPDATE`ta_keyword_users` SET KeywordStatus = '$status' WHERE id ='".$temp[$i]['id']."'";
	runQuery($query);
}
?>
