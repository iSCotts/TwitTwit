<?php ob_start();
session_start();
$orginal_user = $_SESSION["username"];
include '../classes/EpiCurl.php';
include '../classes/EpiOAuth.php';
include '../classes/EpiTwitter.php';
include '../common/secret.php';
include  "../classes/dbClient.php";
include "../common/sqlFunctions.php";
if(isset($_REQUEST["denied"]) && $_REQUEST["denied"]!="" )
{
	header("location:../index.php");
}
try{
		$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
		$twitterObj->setToken($_GET['oauth_token']);
		$token = $twitterObj->getAccessToken();
		$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
		$twitterInfo= $twitterObj->get_accountVerify_credentials();
		addapistatinfo("signin","account/verify_credentials",$orginal_user,""); 
		addapistatinfo("signin","oauth/request_token",$orginal_user,""); 
		addapistatinfo("signin","oauth/access_token",$orginal_user,""); 
		addapistatinfo("signin","oauth/authorize",$orginal_user,""); 
		addapistatinfo("signin","oauth/authenticate",$orginal_user,""); 
		if($twitterInfo->screen_name == '')
		{
			header("Location:../index.php?act=1");
		}
		else
		{
			//------------------------------------------dk-------------------------------------
			$username	= $twitterInfo->screen_name;
			$phpdate	= date( 'Y-m-d H:i:s' );
			
			$query = "SELECT count(*) AS cnt FROM ta_users WHERE UserName 	='$username'";
			$tempR = runQuery($query);
			unset($_SESSION["username"]);
			$_SESSION["username"] = $orginal_user;
			$query = "SELECT count(*) AS cnt FROM ta_user_subscriptions WHERE UserName 	='$username'";
			$tempUSR = runQuery($query);
			// User Subscriptions not available for new user
			
		/*	if(($tempUSR[0]['cnt'] == 0 && $orginal_user=="")||($tempR[0]['cnt'] == 0 && $tempUSR[0]['cnt'] == 0 && $orginal_user=="" ))
				{
				$query = "INSERT INTO `ta_interested_users` (`ta_username`,`ta_key` ,`ta_secretkey`,`ta_date`)VALUES (  '$username', '$token->oauth_token', '$token->oauth_token_secret', '$phpdate')";
				runQuery($query);
				$orginal_user="";
				$_SESSION["username"]="";
				$final_url = "Location: ../pricing.php";
				}
			else 
			{*/
			$query = "SELECT count(*) AS cnt FROM ta_users WHERE UserName 	='$username'";
			$tempR = runQuery($query);
		
			if($tempR[0]['cnt'] == 0)
			{
				if($orginal_user!="")
				{
					$final_url = "Location:../user/add_account.php?act=2";
					$query = " SELECT RefID FROM ta_users WHERE UserName 	='$orginal_user' ";
					$tempR = runQuery($query);
					if(count($tempR) == 0) header("location:../index.php");
					$RefID =  $tempR[0]['RefID'];
				}
				else
				{
					$final_url = "Location:../user/home";
					$_SESSION["username"] = $twitterInfo->screen_name;
					$_SESSION["password"] = $twitterInfo->screen_name;
					//setcookie('oauth_token', $token->oauth_token);
					//setcookie('oauth_token_secret', $token->oauth_token_secret);
					$query = "SELECT MAX( `RefID` ) FROM `ta_users`";
					$tempR = runQuery($query);
					$RefID =  $tempR[0][0]+1;
					$newuser=$_SESSION["username"];
					$getmailquery = "SELECT Email FROM ta_users WHERE UserName ='$newuser' ";
					$emailresult = runQuery($getmailquery);
					if($emailresult[0]['Email']!="")
					{
					$_SESSION["mailid"] = "yes";
					}
					else{
					$_SESSION["mailid"]="no";
					}
				}
				
				// checking User Subscriptions available or not for new user
				$query = "SELECT count(*) AS cnt FROM ta_user_subscriptions WHERE UserName 	='$username'";
				$tempUSR = runQuery($query);
				// User Subscriptions not available for new user
				if($tempUSR[0]['cnt'] == 0)
				{
					$query = "INSERT INTO `ta_user_subscriptions` ( `UserName` ,`PackageID` ,`FeatureID` ,`DT`)VALUES (  '$username', '0', '0', '$phpdate')";
					runQuery($query);
				}
				// creating user table entry for new user
				$query = "INSERT INTO  `ta_users` (`RefID`, `UserName`,`DT`,`login_date`) VALUES ( '$RefID', '$username','$phpdate','$phpdate')";
				runQuery($query);
				// creating UserKeys table entry for new user
				$query = "INSERT INTO `ta_user_keys` (`Username` ,`key` ,`secretkey`,`type`) VALUES ( '$username', '$token->oauth_token', '$token->oauth_token_secret','no')";
				runQuery($query);
				// creating groupMemberprofile table entry for new user
				$query = "INSERT INTO `ta_group_member_profile` ( `memberName` ,`profileImage`,`memberLocation`,`profileDesc`,`memberUrl`)VALUES (  '$username', '$twitterInfo->profile_image_url' ,'$twitterInfo->location', '$twitterInfo->description', '$memberurl')";
				runQuery($query);
				
			}
			else
			{
				if($_SESSION["username"]!="")
				{
					$final_url = "Location:../user/add_account.php?act=3";
				}
				else 
				{
				
					$query = "SELECT `key`, `secretkey` FROM `ta_user_keys` WHERE `Username` = '$username'";
					$tempR = runQuery($query);
					if(count($tempR)>0)
					{
						if($token->oauth_token != $tempR[0]['key'] || $token->oauth_token_secret != $tempR[0]['key'])
						{
							$query = "UPDATE `ta_user_keys` SET `key` ='$token->oauth_token' ,`secretkey`='$token->oauth_token_secret', `type` = 'no' WHERE `Username` = '$username' ";
							executeQuery($query);
						}
					}
					else
					{
					
					// redirects to pricing page
						$query = "INSERT INTO `ta_user_keys` (`Username` ,`key` ,`secretkey`,`type`) VALUES ( '$username', '$token->oauth_token', '$token->oauth_token_secret','no')";
						runQuery($query);
					}
				
					$final_url = "Location:../user/home";
					$_SESSION["username"] = $twitterInfo->screen_name;
					$_SESSION["password"] = $twitterInfo->screen_name;
					$newuser=$_SESSION["username"];
					$getrefidquery = "SELECT RefID FROM ta_users WHERE UserName ='$newuser' ";
					$refidresult = runQuery($getrefidquery);
					$refid=$refidresult[0]['RefID'];
					$useridquery = "SELECT UserID FROM ta_users WHERE RefID 	='$refid'  order by UserID ASC Limit 1";
					$useridresult = runQuery($useridquery);
					$userid=$useridresult[0]['UserID'];
					$getemailquery = "SELECT Email FROM ta_users WHERE UserID='$userid'";
					$emailresult = runQuery($getemailquery);
					$querynew = "UPDATE `ta_users` SET `login_date` ='$phpdate' WHERE `UserName` = '$username' ";
					executeQuery($querynew);
					if($emailresult[0]['Email']!="")
					{
					$_SESSION["mailid"] =  "yes";
					}
					else{
					$_SESSION["mailid"] ="no";
					}
					//setcookie('oauth_token', $token->oauth_token);
					//setcookie('oauth_token_secret', $token->oauth_token_secret);
				}
			}
		//	}
			header($final_url);
		//------------------------------------------dk-------------------------------------
		}
 }
catch(Exception $e){
    header("Location:../twit_err");
  }
?>

