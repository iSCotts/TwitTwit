<?php
// cron file for category  tweets 

session_start();
ob_start();

ini_set("max_execution_time","20000000000000000000000");
ini_set("max_input_time","2500000");
ini_set("memory_limit","25000000M");


include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
$temp=$_SESSION['username'];
//get  campaign ids 
  $phpdate = date('Y-m-d');
   $pageurl=$_SERVER['HTTP_REFERER'];
   $TweetMessage = "There is an interesting group in twitjix.com. Please come and join ".$pageurl;
					
				//get the username by userid 
				$getusernamebyuserid = "SELECT * FROM ta_users  WHERE UserName ='$_SESSION[username]'";
				$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
				$uusernnname = $getusernamebyuseridresult[0]["UserName"];
				// get userlogin details by username 
				
				$getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
				$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "yes")
				{
					$loginname = $getyuserlogindetailsbyusernameresult[0]["Username"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					include "tweetsbypassword.php";
					header("location:".$pageurl);
				}
				
				if($getyuserlogindetailsbyusernameresult[0]["type"] == "no")
				{
					$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
					$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
					include "tweetsbykeys.php";
				    header("location:".$pageurl);
				}	
				$_SESSION['username']=$temp;
				