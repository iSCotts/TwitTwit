<?php 
session_start();
include_once '../common/dbconfig.php';
$phpdate 				= date('Y-m-d H:i:s');
$freq_id				= $_REQUEST["freq_id"];
$CampaignID 			= $_REQUEST["CampaignID"];
$selecetedarray 		= $_REQUEST["selecetedarray"];
$joinarray 				= explode(",",$selecetedarray);
$limitid 				= count($joinarray);
$tmessage 				= '';
$gettweetmessage 		= "SELECT * FROM ta_category_tweet_messages  WHERE categoryid IN ($selecetedarray) LIMIT 0,$limitid";
db_connect();
$gettweetmessageresult	= mysql_query($gettweetmessage);
while($gettweetmessageresultvalue = mysql_fetch_array($gettweetmessageresult))
{
	$tmessage .= stripslashes($gettweetmessageresultvalue["TweetMesasge"])."\n\n";
}
db_close();
echo $tmessage;
 	
 	

 
