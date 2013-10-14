<?php 
// cron file for category  tweets 

ini_set("max_execution_time","20000000000000000000000");
ini_set("max_input_time","2500000");
ini_set("memory_limit","25000000M");
include "../shuffle.php";
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
include '../common/dbconfig.php';
include '../common/dkall.php';
//get  campaign ids 
   date_default_timezone_set("America/New_York");
   $phpdate = date('Y-m-d');
 

 
 
	 
		
	   	//$getalltweetsmessages ="SELECT * FROM ta_category_tweet_messages WHERE categoryid 	IN ($CIDS)  LIMIT 0,$Limitid";
	     $getalltweetsmessages ="SELECT * FROM ta_future_tweet_messages WHERE Date= '$phpdate' && Status='N'";
	   	
		$getalltweetsmessagesresults  = runQuery($getalltweetsmessages);
	 
		 
			 
		if(count($getalltweetsmessagesresults) >=1){
			
			//looping savetweets table 
			for($m=0;$m<count($getalltweetsmessagesresults);$m++){
				//get tewwt message 
		  	$tweetmessage = dkCreatStringWithShortUrls($getalltweetsmessagesresults[$m]["CampaignId"],'futuretweet',$getalltweetsmessagesresults[$m]["id"],stripslashes($getalltweetsmessagesresults[$m]["TweetMessage"]))  ;
			$UTweetMessage[$m] = $tweetmessage;
			//$UTweetMessage[$m] = $getalltweetsmessagesresults[$m]["TweetMessage"];
			
			 
			$CampaignID = $getalltweetsmessagesresults[$m]["CampaignId"];
			$rowid[$m] = $getalltweetsmessagesresults[$m]["id"];
			
			
			//get users for this campaign id 
			
			 //  $getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID'";
			  $getusersforthiscampaignid ="SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignID' AND Status='A'";
			$getusersforthiscampaignidresults  = runQuery($getusersforthiscampaignid);
			// split the users to array
			$getusersforthiscampaignidresults[0]["UserID"];
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
					
  //	$checktweetmessagestatus = "SELECT count(*) FROM ta_future_tweet_messages_status WHERE CampaignId='$CampaignID'  && MessageId='$rowid[$m]' && Status='Y'";
	//$checktweetmessagestatusresult   = runQuery($checktweetmessagestatus);
	 
	
	//if($checktweetmessagestatusresult[0][0] == 0 ){
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
					include "futuretweetsbykeys.php";
				
				
	//}
	
				
			//	}
				
				
			}
			
			//latest 
	//}
			
			}
			
		}	
	