<?php
session_start();
include "../config/configoriginal.php";
 $rowid = $_REQUEST["rowid"];
 $phpdate = date('Y-m-d H:i:s');
 $inserttwettmessageto ="DELETE   FROM ta_adv_tweets WHERE t_id='$rowid'";
 $inserttwettmessagetoresult  = mysql_query($inserttwettmessageto);
	
 

 
