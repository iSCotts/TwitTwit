<?php
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';

$packgquery="SELECT u.`UserID`, u.`RefID`, u.`UserName`,p.`packageID`,p.`campaignLimit`,p.`keywordLimit`,p.`rssFeeds`,p.`twitterAcc`,p.`autoTweet`,p.`followLimit`,us.DT  FROM `ta_user_subscriptions`us LEFT JOIN `ta_packages` p ON us.`packageID`=p.`packageID` LEFT JOIN  `ta_users` u ON us.`UserName`=u.`UserName` WHERE  status='Y'";
$packgresult 	  = runQuery($packgquery);
$current_date=date("Y-m-d");
for($c=0;$c<count($packgresult);$c++)
{
	$ex_date=explode(" ",$packgresult[$c]['DT']);
	$next_date =  date("Y-m-d",strtotime(date("Y-m-d", strtotime($ex_date[0])) . " +4 day"));
	if($next_date>$current_date)
	{
		$campaignLimit =$packgresult[$c]['campaignLimit'];
		$keywordLimit  =$packgresult[$c]['keywordLimit'];
		$rssFeeds        =$packgresult[$c]['rssFeeds'];
		$twitterAcc     =$packgresult[$c]['twitterAcc'];
		$autoTweet    =$packgresult[$c]['autoTweet'];
		$followLimit     =$packgresult[$c]['followLimit'];
		$UserID     		 =$packgresult[$c]['UserID'];
		$RefID     		 =$packgresult[$c]['RefID'];
		$campquery	 = "SELECT CampaignID FROM `ta_campaigns` WHERE `RefID` = '$RefID'  order by DT ASC";
		$campresult 	 = runQuery($campquery);
		for($i=0;$i<count($campresult);$i++)
		{
			$campid=$campresult[$i]['CampaignID'];
			$feedquery		= "SELECT count(*) as cnt FROM `ta_feeds` WHERE `CampaignID` = '$campid' order by DT ASC";
			$feedresult 	= runQuery($feedquery);
			if($feedresult[0]['cnt']>$rssFeeds)
			{
			$sql = "DELETE FROM `ta_feeds` WHERE  `CampaignID`='$campid'";
			executeQuery($sql);
			} 
		} 
		for($j=0;$j<count($campresult);$j++)
		{
			if($j+1>$campaignLimit)
			{
			$campid=$campresult[$j]['CampaignID'];
			$sql = "DELETE FROM `ta_campaigns` WHERE  `CampaignID`='$campid'";
			executeQuery($sql);
			}
		}
		 $query = " SELECT * FROM  `ta_users` WHERE `RefID` = '$UserID' order by DT ASC";
		$temp  = runQuery($query);
		for($j=0;$j<count($temp);$j++)
		{
			if($j+1>$twitterAcc)
			{
			$UserID=$temp[$j]['UserID'];
			$sql = "DELETE FROM `ta_users` WHERE  `UserID`='$UserID'";
			executeQuery($sql);
			}
		}
			 $keyquery	= "SELECT *  FROM `ta_keyword_users` AS ku LEFT JOIN `ta_keyword` AS k ON ku.`keyId` = k.`KeyID` WHERE `UserID` = '$UserID' order by DT ASC";
		$keyresult 	= runQuery($keyquery);
		for($k=0;$k<count($keyresult);$k++)
		{
			if($k+1>$keywordLimit)
			{
			$keyid=$keyresult[$j]['keyId'];
			$sql = "DELETE FROM `ta_keyword_users` WHERE  `keyId`='$keyid'";
			executeQuery($sql);
				}
	}
	 }
}