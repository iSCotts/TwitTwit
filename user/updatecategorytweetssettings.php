<?php
session_start();
include_once '../common/dbconfig.php';
$phpdate = date('Y-m-d H:i:s');
$freq_id = $_REQUEST["freq_id"];
$CampaignID = $_REQUEST["CampaignID"];
$selecetedarray = $_REQUEST["selecetedarray"];
// check campaign already exists 
$campaignalreadyesits = "SELECT count(*) FROM ta_category_tweet_messages_settings WHERE CampaignId='$CampaignID'";
db_connect();
$campaignalreadyesitsREsult  = mysql_query($campaignalreadyesits);
$campaignalreadyesitsREsultset  = mysql_fetch_array($campaignalreadyesitsREsult);
if($campaignalreadyesitsREsultset[0] == 0 )
{	 
	$inserttwettmessageto ="INSERT INTO  `ta_category_tweet_messages_settings` ( `freq_id` , `CategoryIds` , `CampaignId` ) VALUES ('$freq_id', '$selecetedarray', '$CampaignID')";
	$inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
	$lastid =  mysql_insert_id();
}
else
{	
	$inserttwettmessageto ="UPDATE  `ta_category_tweet_messages_settings` SET `freq_id` = '$freq_id' , `CategoryIds` = '$selecetedarray' WHERE  `CampaignId` ='$CampaignID'";
	$inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
	$lastid =  mysql_insert_id();
}
 // get tweet message using category id
$joinarray = explode(",",$selecetedarray);
$limitid = count($joinarray);
$tmessage = '';
$gettweetmessage = "SELECT * FROM ta_category_tweet_messages  WHERE categoryid IN ($selecetedarray) LIMIT 0,$limitid";
$gettweetmessageresult  = mysql_query($gettweetmessage);
db_close();
while($gettweetmessageresultvalue = mysql_fetch_array($gettweetmessageresult))
{
	$tmessage .= stripslashes($gettweetmessageresultvalue["TweetMesasge"])."\n\n";
}
echo $tmessage;
 	
 	

 
