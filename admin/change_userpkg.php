<?php
 session_start();
 include "common/dbconfig.php";
 $newpackageid =$_REQUEST["packageid"];
 $username=$_REQUEST["username"];
 if(isset($newpackageid))
 {
  	$selquery		= "SELECT * FROM `ta_user_subscriptions` WHERE `UserName` = '$username'";
	db_connect();
	$resTemp 	= mysql_query($selquery) or die(mysql_error());
	db_close();
	for($i=0;$i<mysql_num_rows($resTemp);$i++)
	{
		$temp = mysql_fetch_array($resTemp);
		$username		=$temp['UserName'];
		$status	    	=$temp['status'];
		$email	    	=$temp['Email'];
		$packageid		=$temp['PackageID'];
		$subscr_id		=$temp['subscr_id'];
		$affiliateid		=$temp['affiliateid'];
		$SubsID 	    =$temp['SubsID'];
		$insquery = "INSERT INTO `ta_subscription_history` (`username` ,`Email` ,`PackageID` ,`subscr_id`,	`affiliateid` ,`cancelled_date`,`next_payment_date`)
					VALUES ('$username', '$email', '$packageid', '$subscr_id', '$affiliateid', '$phpdate', '$next_payment_date')";
		$res=mysql_query($insquery);
		$updatequery = "UPDATE `ta_user_subscriptions` SET `PackageID`='$newpackageid' WHERE  `UserName`='$username' "; 
		$updateresult  = mysql_query($updatequery);	
   }
   echo "Changed the user package successfully";
 }