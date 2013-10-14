<?php
 
session_start();

 
  ////include "../classes/dbClient.php";
//include "../common/sqlFunctions.php";

include "../config/configoriginal.php";

$rowid = $_REQUEST["rowid"];



 
	
	$phpdate = date('Y-m-d H:i:s');
	$tweetmessage = addslashes($_REQUEST["tweetmessage"]);
	
	$inserttwettmessageto ="UPDATE `ta_category_tweet_messages` SET `TweetMesasge` = '$tweetmessage' WHERE `id` ='$rowid'";
	 
	   $inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
	   
	 
	 
 print $dividf = $_REQUEST["did"]."-".$rowid;
 
 
	
 

 
