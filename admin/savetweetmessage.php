<?php
session_start();

 
  ////include "../classes/dbClient.php";
//include "../common/sqlFunctions.php";

include "../config/configoriginal.php";


$categoryrowid =$_REQUEST["categoryrowid"];

 
	
	$phpdate = date('Y-m-d H:i:s');
	$tweetmessage = addslashes($_REQUEST["tweetmessage"]);
	
	$inserttwettmessageto ="INSERT INTO `ta_category_tweet_messages` (
 
`categoryid` ,
`TweetMesasge` ,
`DT`
)
VALUES (
  '$categoryrowid', '$tweetmessage', '$phpdate')";
	
	
	 
	   $inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
	   
	$lastid =  mysql_insert_id();
	 
 print $dividf = $_REQUEST["did"]."-".$lastid;
 
 
	
 

 
