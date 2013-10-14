<?php
include "common/dbconfig.php";
include "common/sqlFunctions.php";
db_connect();
$phpdate = date('Y-m-d H:i:s');
$frequency=$_REQUEST["frequency"];
$campaignID='0';
$appType = 'admin_posttweets';
$comId = '0';
$tweetmessage =trim($_REQUEST["tweetmessage"]);
$repeat =$_REQUEST["repeat"];
$status     =  dkCreatStringWithShortUrls($campaignID,$appType,$comId,$tweetmessage);
$inserttwettmessageto ="INSERT INTO `ta_adv_tweets` (`tweetmessage`,`frequency`,`poststatus`,`repeat`,`DT`) VALUES ('$status','$frequency','N','$repeat','$phpdate')";
$inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
$lastid =  mysql_insert_id();
db_close();
echo $_REQUEST["did"]."-".$lastid."-".$frequency."-".$repeat;


	
 

 
