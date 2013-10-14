<?php
session_start();

 
  ////include "../classes/dbClient.php";
//include "../common/sqlFunctions.php";

include "../config/configoriginal.php";



 $categoryrowid = $_REQUEST["categoryrowid"];
 $rowid = $_REQUEST["rowid"];
 
	
	$phpdate = date('Y-m-d H:i:s');
	 
	
	  $inserttwettmessageto ="DELETE   FROM ta_category_tweet_messages WHERE categoryid='$categoryrowid' && id='$rowid'";
	 
	   $inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
	   
	 
 //print $dividf = $_REQUEST["did"]."-".$lastid;
 
 
	
 

 
