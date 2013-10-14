<?php 
ini_set("max_execution_time","20000000000000000000000");
ini_set("max_input_time","2500000");
ini_set("memory_limit","25000000M");
include "../shuffle.php";
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';

 
//*********************************************************************************************************//
 // get the server time in the format of 12 hour  OR 24 Hour 
 
	// check server time belongs in (1,2,3,6,12,24)
	   date_default_timezone_set("America/New_York");
	 
	 	$phpdate = date('Y-m-d H:i:s');
	
	
		$HM = date("H:i:s");
		$spilitHm =explode(":",$HM);
		$RequiredHour = $spilitHm[0];
		
		if($RequiredHour == 01 ){
			
		$WhereClause = "AND freq_id=1";	
		}
		
		if($RequiredHour == 02 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";	
		}
		
		if($RequiredHour == 03 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=3";	
		}
		
		if($RequiredHour == 04 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2 ";	
		}
		
		if($RequiredHour == 05 ){
			
		$WhereClause = "AND freq_id=1";	
		}
		
		if($RequiredHour == 06 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6";	
		}
		
		
		if($RequiredHour == 07 ){
			
		$WhereClause = "AND freq_id=1";	
		}
		
		if($RequiredHour == 08 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";	
		}
		
		if($RequiredHour == 09 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=3";	
		}
		
		
		if($RequiredHour == 10 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";	
		}
		
		
		if($RequiredHour == 11 ){
			
		$WhereClause = "AND freq_id=1";	
		}
		
		
		if($RequiredHour == 12 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6 OR freq_id=12";	
		}
		
		
		if($RequiredHour == 13 ){
			
		$WhereClause = "AND freq_id=1";	
		}
		
		
		if($RequiredHour == 14 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";
			
		}
		

		if($RequiredHour == 15 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=3";
			
		}
		
		
		if($RequiredHour == 16 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";
			
		}
		
		if($RequiredHour == 17 ){
			
		$WhereClause = "AND freq_id=1";
			
		}
		
		if($RequiredHour == 18 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6";
			
		}
		
		if($RequiredHour == 19 ){
			
		$WhereClause = "AND freq_id=1";
			
		}
		
		
		if($RequiredHour == 20 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";
			
		}
		
		
		if($RequiredHour == 21 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=3";
			
		}
		
		
		if($RequiredHour == 22 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2";
			
		}
		if($RequiredHour == 23 ){
			
		$WhereClause = "AND freq_id=1";
			
		}
		
		
		if($RequiredHour == 00 ){
			
		$WhereClause = "AND freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6 OR freq_id=12";	
		}
		
		
		
//*********************************************************************************************************//

		
		

// Get All Active feed url's from feeds table 
	$Getallactivefeedurls ="SELECT * FROM ta_feeds WHERE isactive='1' $WhereClause";
	$Getallactivefeedurlsresult = runQuery($Getallactivefeedurls);
	
	for($p=0;$p<count($Getallactivefeedurlsresult);$p++){
	//get users by ccampaign id
	  $CampaignID =$Getallactivefeedurlsresult[$p]["CampaignID"];
	
  	//$getusersbycampaignid ="SELECT * FROM ta_campaigns WHERE  CampaignID='$CampaignID' AND Status='Active'";
  	$getusersbycampaignid ="SELECT * FROM ta_campaigns WHERE  CampaignID='$CampaignID' AND Status='A'";
	$getusersbycampaignidresult = runQuery($getusersbycampaignid);
	$usersvalues = $getusersbycampaignidresult[0]["UserID"];
	$splituservalueswithcomma =explode("-",$usersvalues);
	
     //get user name from users table using userid
	 for($q=0;$q<count($splituservalueswithcomma);$q++)
	 {
		 	if($splituservalueswithcomma[$q] != ""){
		 		
		 		$getusernamebyuserid ="SELECT * FROM ta_users WHERE UserID='$splituservalueswithcomma[$q]'";
		 		$getusernamebyuseridresult =runQuery($getusernamebyuserid);
		 		
		 		$Username = $getusernamebyuseridresult[0]["UserName"];
		 		
		 		//get login details from userkeys using username 
		 		$getlogindetailsbyuserid ="SELECT * FROM ta_user_keys WHERE Username='$Username'";
		 		$getlogindetailsbyuseridresult =runQuery($getlogindetailsbyuserid);
		 		//check userkeys type and assign username and password 
				$usernameK =$getlogindetailsbyuseridresult[0]["key"];
				$passwordK =$getlogindetailsbyuseridresult[0]["secretkey"];
				include "getfeedresultsusingkeys.php";
		 		
		 	}
	 }		
	}
