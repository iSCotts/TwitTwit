<?php
// cron file for category  tweets 

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
		
		if($RequiredHour == "01" ){
			
		$WhereClause = " freq_id=1";	
		}
		
		else if($RequiredHour == "02" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2";	
		}
		
		else if($RequiredHour == "03" ){
			
		$WhereClause = " freq_id=1 OR freq_id=3";	
		}
		
		else if($RequiredHour == "04" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2 ";	
		}
		
		else if($RequiredHour == "05" ){
			
		$WhereClause = " freq_id=1";	
		}
		
		else if($RequiredHour == "06" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6";	
		}
		
		
		else if($RequiredHour == "07" ){
			
		$WhereClause = " freq_id=1";	
		}
		
		else if($RequiredHour == "08"){
			
		$WhereClause = " freq_id=1 OR freq_id=2";	
		}
		
		else if($RequiredHour == "09" ){
			
		$WhereClause = " freq_id=1 OR freq_id=3";	
		}
		
		
		else if($RequiredHour == "10" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2";	
		}
		
		
		else if($RequiredHour == "11" ){
			
		$WhereClause = " freq_id=1";	
		}
		
		
		else if($RequiredHour == "12" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6 OR freq_id=12";	
		}
		
		
		else if($RequiredHour == "13" ){
			
		$WhereClause = " freq_id=1";	
		}
		
		
		else if($RequiredHour == "14" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2";
			
		}
		

		else if($RequiredHour == "15" ){
			
		 $WhereClause = " freq_id=1 OR freq_id=3";
			
		}
		
		
		else if($RequiredHour == "16" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2";
			
		}
		
		else if($RequiredHour == "17" ){
			
		$WhereClause = " freq_id=1";
			
		}
		
		else if($RequiredHour == "18" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6";
			
		}
		
		else if($RequiredHour == "19" ){
			
		$WhereClause = " freq_id=1";
			
		}
		
		
		else if($RequiredHour == "20" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2";
			
		}
		
		
		else if($RequiredHour == "21" ){
			
		$WhereClause = " freq_id=1 OR freq_id=3";
			
		}
		
		
		else if($RequiredHour == "22" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2";
			
		}
		else if($RequiredHour == "23" ){
			
		$WhereClause = " freq_id=1";
			
		}
		
		
		else if($RequiredHour == "00" ){
			
		$WhereClause = " freq_id=1 OR freq_id=2 OR freq_id=3 OR freq_id=6 OR freq_id=12";	
		}
		
		else{
			
			
		}
		 
		
//*********************************************************************************************************//

		
		
 
		
//get  campaign ids 

 // $getallcampaignids = "SELECT * FROM  ta_save_tweets_settings WHERE $WhereClause";
  $getallcampaignids = "SELECT * FROM  ta_category_tweet_messages_settings  WHERE $WhereClause ";
 
$getallcampaignidsresult  = runQuery($getallcampaignids);

for($h=0;$h<count($getallcampaignidsresult);$h++){
	
	//get tweets part 
		$makecaegoryarray = explode(",",$getallcampaignidsresult[$h]["CategoryIds"]);
		
	  	$Limitid = count($makecaegoryarray);
	  	
		$CampaignID =  $getallcampaignidsresult[$h]["CampaignId"];
		
		$CIDS = $getallcampaignidsresult[$h]["CategoryIds"];
		
	   	//$getalltweetsmessages ="SELECT * FROM ta_category_tweet_messages WHERE categoryid 	IN ($CIDS)  LIMIT 0,$Limitid";
	     	$getalltweetsmessages ="SELECT * FROM ta_category_tweet_messages WHERE categoryid 	IN ($CIDS) ORDER BY RAND()   LIMIT 0,$Limitid";
	   	
		$getalltweetsmessagesresults  = runQuery($getalltweetsmessages);
	 
		 
			 
		if(count($getalltweetsmessagesresults) >=1){
			
			//looping savetweets table 
			for($m=0;$m<count($getalltweetsmessagesresults);$m++){
				//get tewwt message 
		  	$tweetmessage = $getalltweetsmessagesresults[$m]["TweetMesasge"];
			$UTweetMessage[$m] = $getalltweetsmessagesresults[$m]["TweetMesasge"];
			
			$Ucategoryid[$m] = $getalltweetsmessagesresults[$m]["categoryid"];
			//$CampaignID = $getalltweetsmessagesresults[$m]["CampaignID"];
			$rowid[$m] = $getalltweetsmessagesresults[$m]["id"];
			
			
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
			 
			
			//check the tweet message already posted wit htwitter uisng message id ,campaign id , cateogry id ,statas 
					
  	$checktweetmessagestatus = "SELECT count(*) FROM ta_category_tweet_messages_status WHERE CampaignId='$CampaignID' && CategoryId='$Ucategoryid[$m]' && MessageId='$rowid[$m]' && Status='Y'";
	$checktweetmessagestatusresult   = runQuery($checktweetmessagestatus);
	 
	
	if($checktweetmessagestatusresult[0][0] == 0 ){
					$UpdatedTweetMessage = $tweetmessage;
					
					
					
			
			for($l=0;$l<count($userid);$l++){
				
			 //	for($TM=0;$TM<count($UTweetMessage);$TM++){
					
					
					
					
					
					
					
				//get the username by userid 
				  $getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID ='$userid[$l]'";
				$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
				$uusernnname = $getusernamebyuseridresult[0]["UserName"];
				// get userlogin details by username 
				
				  $getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
				$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);
				
					$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					include "categorytweetsbykeys.php";
				
				
	//}
	
				
			//	}
				
				
			}
			
			//latest 
	}
					
			
			}
			
		}
		else
		{
			$mesasge ="all messages are  posted with  twitter ";
			
		}
}
