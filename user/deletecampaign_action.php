<?php
ob_start();
session_start();
include "../config/config.php";
include "../common/sqlFunctions.php";
include "../classes/Database.php";
include "../classes/Mysql.php";

$CampaignID = $_REQUEST["CampaignID"];
$username = $_REQUEST["username"];

 
		
	 
	 
	 
	 
	    // get user id by username 
	     $getuseridbyusername = "SELECT * FROM ta_users WHERE UserName='$username'";
	    $getuseridbyusernameresult  = runQuery($getuseridbyusername);
	    $addedusername =  $getuseridbyusernameresult[0]["UserID"];
	    
	    
 // get all user field for using campaign id 
 
	     $getuseridbycampaignid = "SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
	    $getuseridbycampaignidresult  = runQuery($getuseridbycampaignid);
	    $usersfromdatabase =  $getuseridbycampaignidresult[0]["UserID"];
	    
	    
	    $splitthedatabaseusers = explode("-",$usersfromdatabase);
	    $output = '';
	    for($k=0;$k<count($splitthedatabaseusers);$k++)
	    {
	    	if($splitthedatabaseusers[$k] != $addedusername){
			if(intval($splitthedatabaseusers[$k]))
			{
	    	$output .=$splitthedatabaseusers[$k]."-";
			}
	    	}
	    	
	    	
	    }

	//concat all userid's with comma separated 
  	$makecommaseparated = $output;
  	
  	
 

 	// 	Get REfID using username from users Table 
 	
	$getrefidusingusername ="SELECT * FROM ta_users WHERE UserName='$_SESSION[username]'";
	$getrefidusingusernameresult  = runQuery($getrefidusingusername);
  	$refid = $getrefidusingusernameresult[0]["RefID"];
	// 	Get REfID using username from users Table 
	
	
	// Update campaign table by campaign id and refid

	   $updatecampaigntablewithuserids = "UPDATE `ta_campaigns` SET `UserID` = '$makecommaseparated' WHERE `CampaignID` ='$CampaignID' AND RefID='$refid'";
	 
	
	
	$updatecampaigntablewithuseridsresult   = runQuery($updatecampaigntablewithuserids);
	
	
	
	
	  $getgroupeduserids ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
	$getgroupeduseridsresult  = runQuery($getgroupeduserids);
	$splitgroupeduserids = explode("-",$getgroupeduseridsresult[0]["UserID"]);

 
 
 

	if(array_sum($splitgroupeduserids) >=1 ){
			
	for($t=0;$t<count($splitgroupeduserids);$t++){
	//pass each and every userid to  JS function

		
		if($splitgroupeduserids[$t] != ""){
			
		// get username by userid
	  //	$getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID='$splitgroupeduserids[$t]'";
	//	$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
		//$ousername = $getusernamebyuseridresult[0]["UserName"];

			$vvalue  = "yes";
			
	?>

  
 <?php
		}
		

	}
	}
	else
	{
		
		$vvalue  = "no";
		
	}
	
		 
		
		
	//print "Deleted";
	print "The account has been deleted-".$CampaignID."-".$vvalue;
	
//	header("Location:managecampaign.php?act=5");
	//exit;
	

 
		