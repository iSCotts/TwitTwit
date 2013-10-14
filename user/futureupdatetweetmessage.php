<?php
session_start();
include_once '../common/dbconfig.php';
$rowid = $_REQUEST["rowid"];
$phpdate = date('Y-m-d H:i:s');
$tweetmessage = addslashes($_REQUEST["tweetmessage"]);
$dateid = addslashes($_REQUEST["dateid"]);
$query ="UPDATE `ta_future_tweet_messages` SET `TweetMessage` = '$tweetmessage'  ,  `Date` = '$dateid', `Status` = 'N' WHERE `id` ='$rowid' ";
db_connect();
mysql_query($query);
db_close(); 
echo $dividf = $_REQUEST["did"]."-".$rowid;
 
 
	
 

 
