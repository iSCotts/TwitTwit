<?php
session_start();
include_once '../common/dbconfig.php';
$phpdate = date('Y-m-d H:i:s');
$tweetmessage = addslashes($_REQUEST["tweetmessage"]);
$dateid = addslashes($_REQUEST["dateid"]);
$CampaignID = addslashes($_REQUEST["CampaignID"]);
$did = addslashes($_REQUEST["did"]);
$query ="INSERT INTO  `ta_future_tweet_messages` (`CampaignId` , `TweetMessage` , `Date` , `DT` , `Status`) VALUES ('$CampaignID', '$tweetmessage', '$dateid', '$phpdate', 'N')";
db_connect();
mysql_query($query);
$lastid =  mysql_insert_id();
db_close();
echo $_REQUEST["did"]."-".$lastid;
 
 
	
 

 
