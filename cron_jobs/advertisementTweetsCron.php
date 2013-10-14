<?php
ini_set("max_execution_time","20000000000000000000000");
ini_set("max_input_time","2500000");
ini_set("memory_limit","25000000M");
date_default_timezone_set("America/New_York");
include_once('../config/config.php');
include_once('../common/twitteroauth.php');
include_once('../classes/dbClient.php');
include_once('../common/sqlFunctions.php');
$consumer_key = CONSUMER_KEY;
$consumer_secret =CONSUMER_SECRET;
function dkWeekRange($date) {
    $ts = strtotime($date);
    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
    return array(date('Y-m-d', $start),
                 date('Y-m-d', strtotime('next saturday', $start)));
}
$x = dkWeekRange(date('Y-m-d'));
$phpdate = date('Y-m-d H:i:s');
$HM = date("H:i:s");
$spilitHm =explode(":",$HM);
$RequiredHour = $spilitHm[0];
$WhereClause = "where frequency='00' ";
if($x[0] == date('Y-m-d') && $RequiredHour == "00")
{
	$WhereClause.= " OR frequency='168' ";	
}
if($RequiredHour == "05"  || $RequiredHour == "11" || $RequiredHour == "15"  || $RequiredHour == "23" ){
	$WhereClause.= " OR  frequency='06' ";	
	if($RequiredHour == "11" ) $WhereClause.= " OR frequency='12' ";	
}
else if($RequiredHour == "23" ){
	$WhereClause.= " OR  frequency='23' OR frequency='12'  ";	
}
//*********************************************************************************************************//
$query  = "SELECT * FROM  ta_adv_tweets  $WhereClause and poststatus='N' limit 0,1";
$tempR  = runQuery($query);
$yCount = count($tempR );
if($yCount > 0)
{
	 $query  = "SELECT b.`Username`, b.`key`, b.`secretkey` FROM `ta_user_keys` b LEFT JOIN `ta_user_subscriptions` a ON a.`UserName`=b.`Username`  WHERE a.`PackageID` = 0";
	$userR  = runQuery($query);
	$xCount	= count($userR );
	if($xCount > 0)
	{
		for($i=0;$i<$yCount;$i++)
		{
			for($j=0;$j<$xCount;$j++)
			{
				$tOAobj   =   new TwitterOAuth($consumer_key, $consumer_secret, $userR[$j]['key'], $userR[$j]['secretkey']);
				$tweetmessage =  $tempR[$i]['tweetmessage'];
				$userName = $userR[$j]['Username'];
				$params   =   array('status' =>$tweetmessage);
				$tOAobj->post('http://twitter.com/statuses/update.json',$params);
				$query = "INSERT INTO ta_adv_tweets_log(username,tweetmessage,DT) VALUES('$userName' ,'$tweetmessage' ,'$phpdate' )";
				runQuery($query);
			}
		}
	}
	$tweetid=$tempR[0]['t_id'];
	$updatequery = "UPDATE  `ta_adv_tweets` SET poststatus='Y' where t_id=".$tweetid;
	runQuery($updatequery);
}
$selquery  = "SELECT * FROM  ta_adv_tweets where poststatus='N'";
$selcount = runQuery($selquery);
if(count($selcount)==0)
{
$updatenquery = "UPDATE  `ta_adv_tweets` SET poststatus='N' where `repeat`=1";
runQuery($updatenquery);
}