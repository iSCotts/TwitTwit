<?php
// cron file for saved tweets 
ini_set("max_execution_time","20000000000000000000000");
ini_set("max_input_time","2500000");
ini_set("memory_limit","25000000M");
include "../shuffle.php";
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
include '../common/dbconfig.php';
include '../common/dkall.php';
//*********************************************************************************************************//
 // get the server time in the format of 12 hour  OR 24 Hour 
 
	// check server time belongs in (1,2,3,6,12,24)
        date_default_timezone_set("America/New_York");
	 	$phpdate = date('Y-m-d H:i:s');
		$HM = date("H:i:s");
		$spilitHm =explode(":",$HM);
		$RequiredHour = $spilitHm[0];
		
		if($RequiredHour == "01" ){
			
		$WhereClause = " Frequency=1";	
		}
		
		else if($RequiredHour == "02" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2";	
		}
		
		else if($RequiredHour == "03" ){
			
		$WhereClause = " Frequency=1 OR Frequency=3";	
		}
		
		else if($RequiredHour == "04" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2 ";	
		}
		
		else if($RequiredHour == "05" ){
			
		$WhereClause = " Frequency=1";	
		}
		
		else if($RequiredHour == "06" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2 OR Frequency=3 OR Frequency=6";	
		}
		
		
		else if($RequiredHour == "07" ){
			
		$WhereClause = " Frequency=1";	
		}
		
		else if($RequiredHour == "08"){
			
		$WhereClause = " Frequency=1 OR Frequency=2";	
		}
		
		else if($RequiredHour == "09" ){
			
		$WhereClause = " Frequency=1 OR Frequency=3";	
		}
		
		
		else if($RequiredHour == "10" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2";	
		}
		
		
		else if($RequiredHour == "11" ){
			
		$WhereClause = " Frequency=1";	
		}
		
		
		else if($RequiredHour == "12" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2 OR Frequency=3 OR Frequency=6 OR Frequency=12";	
		}
		
		
		else if($RequiredHour == "13" ){
			
		$WhereClause = " Frequency=1";	
		}
		
		
		else if($RequiredHour == "14" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2";
			
		}
		

		else if($RequiredHour == "15" ){
			
		 $WhereClause = " Frequency=1 OR Frequency=3";
			
		}
		
		
		else if($RequiredHour == "16" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2";
			
		}
		
		else if($RequiredHour == "17" ){
			
		$WhereClause = " Frequency=1";
			
		}
		
		else if($RequiredHour == "18" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2 OR Frequency=3 OR Frequency=6";
			
		}
		
		else if($RequiredHour == "19" ){
			
		$WhereClause = " Frequency=1";
			
		}
		
		
		else if($RequiredHour == "20" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2";
			
		}
		
		
		else if($RequiredHour == "21" ){
			
		$WhereClause = " Frequency=1 OR Frequency=3";
			
		}
		
		
		else if($RequiredHour == "22" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2";
			
		}
		else if($RequiredHour == "23" ){
			
		$WhereClause = " Frequency=1";
			
		}
		
		
		else if($RequiredHour == "00" ){
			
		$WhereClause = " Frequency=1 OR Frequency=2 OR Frequency=3 OR Frequency=6 OR Frequency=12";	
		}
		
		else{
			
			
		}
		 
		
//*********************************************************************************************************//

		
		
//get  campaign ids 

$getallcampaignids = "SELECT * FROM  ta_save_tweets_settings WHERE $WhereClause";
 
$getallcampaignidsresult  = runQuery($getallcampaignids);

for($h=0;$h<count($getallcampaignidsresult);$h++){
	
	//get tweets part 
	// first case is random only 
	if($getallcampaignidsresult[$h]["Random"] ==1  && $getallcampaignidsresult[$h]["Repeat"] == 0)
	{
		$CampaignID =  $getallcampaignidsresult[$h]["CampaignID"];
	 	$getalltweetsmessages ="SELECT * FROM ta_save_tweets WHERE CampaignID='$CampaignID' AND PostStatus='N' ORDER BY RAND() LIMIT 0,1";
		$getalltweetsmessagesresults  = runQuery($getalltweetsmessages);
		
		if(count($getalltweetsmessagesresults) >=1){
			
			//looping savetweets table 
			
			for($m=0;$m<count($getalltweetsmessagesresults);$m++){
			//get tewwt message 
			$tweetmessage = dkCreatStringWithShortUrls($getalltweetsmessagesresults[$m]["CampaignID"],'savetweet',$getalltweetsmessagesresults[$m]["id"],stripslashes($getalltweetsmessagesresults[$m]["TweetMessage"]));
			$CampaignID = $getalltweetsmessagesresults[$m]["CampaignID"];
			$rowid = $getalltweetsmessagesresults[$m]["id"];
			
			
			//get users for this campaign id 
			
			// $getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
			$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID' AND Status='A'";
			$getusersforthiscampaignidresults  = runQuery($getusersforthiscampaignid);
			// split the users to array
			
			$splitusers = explode("-",$getusersforthiscampaignidresults[0]["UserID"]);
			//remove the empty array field
			$userpos = 0;
			for($e=0;$e<count($splitusers);$e++){
				
				if($splitusers[$e] != ""){
				$userid[$userpos]  =$splitusers[$e];
				$userpos++;
				}
				
				
			}//remove the empty array field
			
			 
			
			// get the users array finally 
			 
			
			
			for($l=0;$l<count($userid);$l++){
				
				//get the username by userid 
				$getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID ='$userid[$l]'";
				$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
				$uusernnname = $getusernamebyuseridresult[0]["UserName"];
				// get userlogin details by username 
				
				$getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
				$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);
				
				$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
				$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
				include "savetweetsbykeys.php";
						}
			
			
			}
			
		}
		else
		{
			$mesasge ="all messages are  posted with  twitter ";
			
		}
		
	}
	
	
	
	
	// second case random = 0 and repeat =1 
	
	 
	if($getallcampaignidsresult[$h]["Random"] ==0  && $getallcampaignidsresult[$h]["Repeat"] == 1)
	{
		$CampaignID =  $getallcampaignidsresult[$h]["CampaignID"];
		$getalltweetsmessages ="SELECT * FROM ta_save_tweets WHERE CampaignID='$CampaignID' AND PostStatus='N' LIMIT 0,1";
		$getalltweetsmessagesresults  = runQuery($getalltweetsmessages);
		
		if(count($getalltweetsmessagesresults) >=1){
			
			//looping savetweets table 
			for($m=0;$m<count($getalltweetsmessagesresults);$m++){
				//get tewwt message 
			$tweetmessage = dkCreatStringWithShortUrls($getalltweetsmessagesresults[$m]["CampaignID"],'savetweet',$getalltweetsmessagesresults[$m]["id"],stripslashes($getalltweetsmessagesresults[$m]["TweetMessage"]));
			$CampaignID = $getalltweetsmessagesresults[$m]["CampaignID"];
			$rowid = $getalltweetsmessagesresults[$m]["id"];
			//get users for this campaign id 
			
			//$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
			
			$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID' AND Status='A'";
			$getusersforthiscampaignidresults  = runQuery($getusersforthiscampaignid);
			// split the users to array
			
			$splitusers = explode("-",$getusersforthiscampaignidresults[0]["UserID"]);
			//remove the empty array field
			$userpos = 0;
			
			for($e=0;$e<count($splitusers);$e++){
				
				if($splitusers[$e] != ""){
				$userid[$userpos]  =$splitusers[$e];
				$userpos++;
				}
				
				
			}//remove the empty array field
			
			// get the users array finally 
			
			for($l=0;$l<count($userid);$l++){
				
				//get the username by userid 
				$getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID ='$userid[$l]'";
				$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
				$uusernnname = $getusernamebyuseridresult[0]["UserName"];
				// get userlogin details by username 
				
				$getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
				$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "yes")
				{
					$loginname = $getyuserlogindetailsbyusernameresult[0]["Username"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					include "savetweetsbypassword.php";
				}
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "no")
				{
					$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					
					include "savetweetsbykeys.php";
				}
				
				
			}
			
			
			}
			
		}
		else
		{
			$mesasge ="you have update the status of all rows for campaigns ids ";
			$updateteetstatustono = "UPDATE  `ta_save_tweets` SET `PostStatus` = 'N' WHERE `CampaignID` ='$CampaignID'";
			$updateteetstatustonoresult   = runQuery($updateteetstatustono);
			
			
		}
		 
	}
	// third case random = 1 and repeat =1 
	
	 
	if($getallcampaignidsresult[$h]["Random"] ==1  && $getallcampaignidsresult[$h]["Repeat"] == 1)
	{
		$CampaignID =  $getallcampaignidsresult[$h]["CampaignID"];
		$getalltweetsmessages ="SELECT * FROM ta_save_tweets WHERE CampaignID='$CampaignID' AND PostStatus='N' ORDER BY RAND() LIMIT 0,1";
		$getalltweetsmessagesresults  = runQuery($getalltweetsmessages);
		if(count($getalltweetsmessagesresults) >=1){
			
			//looping savetweets table 
			for($m=0;$m<count($getalltweetsmessagesresults);$m++){
				//get tewwt message 
			$tweetmessage = dkCreatStringWithShortUrls($getalltweetsmessagesresults[$m]["CampaignID"],'savetweet',$getalltweetsmessagesresults[$m]["id"],stripslashes($getalltweetsmessagesresults[$m]["TweetMessage"]));
			$CampaignID = $getalltweetsmessagesresults[$m]["CampaignID"];
			$rowid = $getalltweetsmessagesresults[$m]["id"];
					
			//get users for this campaign id 
			
			//$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
			$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID' AND Status='A'";
			$getusersforthiscampaignidresults  = runQuery($getusersforthiscampaignid);
			// split the users to array
			
			$splitusers = explode("-",$getusersforthiscampaignidresults[0]["UserID"]);
			//remove the empty array field
			$userpos = 0;
			for($e=0;$e<count($splitusers);$e++){
				
				if($splitusers[$e] != ""){
				$userid[$userpos]  =$splitusers[$e];
				$userpos++;
				}
				
				
			}//remove the empty array field
			
			// get the users array finally 
			
			for($l=0;$l<count($userid);$l++){
				
				//get the username by userid 
				$getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID ='$userid[$l]'";
				$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
				$uusernnname = $getusernamebyuseridresult[0]["UserName"];
				// get userlogin details by username 
				
				$getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
				$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "yes")
				{
					$loginname = $getyuserlogindetailsbyusernameresult[0]["Username"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					include "savetweetsbypassword.php";
				}
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "no")
				{
					$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					
					include "savetweetsbykeys.php";
				}
				
				
			}
			
			
			}
			
		}
		else
		{
			$mesasge ="you have update the status of all rows for campaigns ids ";
			$updateteetstatustono = "UPDATE  `ta_save_tweets` SET `PostStatus` = 'N' WHERE `CampaignID` ='$CampaignID'";
			$updateteetstatustonoresult   = runQuery($updateteetstatustono);
			
			
		}
		
	}
	
	
	
	
	
	
	
	// fourth  case random = 0 and repeat =0 
	
	 
	if($getallcampaignidsresult[$h]["Random"] ==0  && $getallcampaignidsresult[$h]["Repeat"] == 0)
	{
		$CampaignID =  $getallcampaignidsresult[$h]["CampaignID"];
		$getalltweetsmessages ="SELECT * FROM ta_save_tweets WHERE CampaignID='$CampaignID' AND PostStatus='N' LIMIT 0,1";
		$getalltweetsmessagesresults  = runQuery($getalltweetsmessages);
		
		if(count($getalltweetsmessagesresults) >=1){
			
			//looping savetweets table 
			for($m=0;$m<count($getalltweetsmessagesresults);$m++){
				//get tewwt message 
		   $tweetmessage = dkCreatStringWithShortUrls($getalltweetsmessagesresults[$m]["CampaignID"],'savetweet',$getalltweetsmessagesresults[$m]["id"],stripslashes($getalltweetsmessagesresults[$m]["TweetMessage"]));
			$CampaignID = $getalltweetsmessagesresults[$m]["CampaignID"];
			$rowid = $getalltweetsmessagesresults[$m]["id"];
			
			
			//get users for this campaign id 
			
			//$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
			$getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID' AND Status='A'";
			$getusersforthiscampaignidresults  = runQuery($getusersforthiscampaignid);
			// split the users to array
			
			$splitusers = explode("-",$getusersforthiscampaignidresults[0]["UserID"]);
			//remove the empty array field
			$userpos = 0;
			for($e=0;$e<count($splitusers);$e++){
				
				if($splitusers[$e] != ""){
				$userid[$userpos]  =$splitusers[$e];
				$userpos++;
				}
				
				
			}//remove the empty array field
			
			// get the users array finally 
			
			for($l=0;$l<count($userid);$l++){
				
				//get the username by userid 
				$getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID ='$userid[$l]'";
				$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
				$uusernnname = $getusernamebyuseridresult[0]["UserName"];
				// get userlogin details by username 
				
				$getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
				$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "yes")
				{
					$loginname = $getyuserlogindetailsbyusernameresult[0]["Username"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					include "savetweetsbypassword.php";
				}
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "no")
				{
					$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					
					include "savetweetsbykeys.php";
				}
				
				
			}
			
			
			}
			
		}
		else
		{
			$mesasge ="you have update the status of all rows for campaigns ids ";
			//$updateteetstatustono = "UPDATE  `ta_save_tweets` SET `PostStatus` = 'N' WHERE `CampaignID` ='$CampaignID'";
			//$updateteetstatustonoresult   = runQuery($updateteetstatustono);
			
		}
		
	}

}
