<?php
session_start();
include_once '../common/dbconfig.php';
$rowid = $_REQUEST["rowid"];
$phpdate = date('Y-m-d H:i:s');
$tweetmessage = addslashes($_REQUEST["tweetmessage"]);
db_connect();
$selectqry="SELECT * from `ta_save_tweets` where `CampaignID`='$_REQUEST[CampaignID]' and `TweetMessage`= '$tweetmessage' and `id`!='$rowid'";
$getqryresult  = mysql_query($selectqry);
$getqrylastresult = mysql_fetch_array($getqryresult);
if(mysql_num_rows($getqryresult)>0)
{
$result="Tweet already exists, Please try again";
}
else{
$query ="UPDATE `ta_save_tweets` SET `TweetMessage` = '$tweetmessage' WHERE `id` ='$rowid' ";
mysql_query($query);
$result=1;
}
db_close();
echo $dividf = $_REQUEST["did"]."-".$rowid."-".$result;
 
 
	
 

 
