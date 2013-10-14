<?php
session_start();
include_once '../common/dbconfig.php';
$phpdate = date('Y-m-d H:i:s');
$tweetmessage = addslashes($_REQUEST["tweetmessage"]);
db_connect();
$selectqry="SELECT * from `ta_save_tweets` where `CampaignID`='$_REQUEST[CampaignID]' and `TweetMessage`= '$tweetmessage'";
$getqryresult  = mysql_query($selectqry);
$getqrylastresult = mysql_fetch_array($getqryresult);
if(mysql_num_rows($getqryresult)>0)
{
$lastid="Tweet already exists, Please try again";
}
else{
$query ="INSERT INTO `ta_save_tweets` (`CampaignID` , `TweetMessage` , `PostStatus` , `DT` ) VALUES ('$_REQUEST[CampaignID]', '$tweetmessage', 'N', '$phpdate')";
mysql_query($query);
$lastid =  mysql_insert_id();
}
db_close();
echo $dividf = $_REQUEST["did"]."-".$lastid;
 
 
	
 

 
