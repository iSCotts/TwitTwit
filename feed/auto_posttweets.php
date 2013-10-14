<?php
ob_start();
 
/*
 * Created on 29-Dec-2009
 * Author :	Liju
 * File:	feedCron.php
 *
 */
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
 
// $xmlDoc = new DOMDocument();
 
// Get the All usesr from Users Table 

  $getallusers ="SELECT * FROM ta_users";
 
$getallusersresult = runQuery($getallusers);
//print_r($getallusersresult);
//print count($getallusersresult);
// Get the All usesr from Users Table 



for($in=0;$in<count($getallusersresult);$in++){
// get the   UserKeys url area 
      $UserName = $getallusersresult[$in]["UserName"];

  $Getkeyfdetailsbyuserid = "SELECT * FROM ta_user_keys WHERE Username ='$UserName'";
$Getkeyfdetailsbyuseridresult = runQuery($Getkeyfdetailsbyuserid);



 // get the server time in the format of 12 hour  OR 24 Hour 
 
	// check server time belongs in (1,2,3,6,12,24)
	
		

// get the   feed url area 

  $Getfeeddetailsbyuserid = "SELECT * FROM ta_feeds WHERE UserID ='$UserName'";
$Getfeeddetailsbyuserid = runQuery($Getfeeddetailsbyuserid);


for($p=0;$p<count($Getfeeddetailsbyuserid);$p++){

// Check the Password type for ket table 




 


if($Getkeyfdetailsbyuseridresult[0]["type"] == 'no')
{
include "posttweetsbykey1.php";
//include "testfeed2.php";

}
if($Getkeyfdetailsbyuseridresult[0]["type"] == 'yes')
{
include "posttweetsbypassword.php";
}

}



}
 
 
 
?>