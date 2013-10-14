<?php
include "common/dbconfig.php";
include "common/sqlFunctions.php";
$rowid = $_REQUEST["rowid"];
$phpdate = date('Y-m-d H:i:s');
$campaignID='0';
$appType = 'admin_posttweets';
$comId = '0';
$tweetmessage = trim($_REQUEST["tweetmessage"]);
$frequency =$_REQUEST["frequ"];
$repeat =$_REQUEST["repeat"];
db_connect();
$status     =  dkCreatStringWithShortUrls($campaignID,$appType,$comId,$tweetmessage);
//$inserttwettmessageto ="UPDATE `ta_adv_tweets` SET `tweetmessage` = '$status' WHERE `t_id` ='$rowid'";
$inserttwettmessageto ="UPDATE `ta_adv_tweets` SET `tweetmessage` = '$status',`frequency`='$frequency',`repeat`='$repeat ' WHERE `t_id` ='$rowid'";
$inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
 echo $dividf = $_REQUEST["did"]."-".$rowid."-".$frequency."-".$repeat;
 db_close();
 
	
 

 
