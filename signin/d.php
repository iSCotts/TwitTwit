<?php
ob_start();
session_start();
include "../classes/dbClient.php";
include "../common/sqlFunctions.php";

$username = $_REQUEST["username"];

$password = $_REQUEST["password"];
$dt=date('Y-m-d H:i:s');
$url = "http://twitter.com/account/verify_credentials.json";
addapistatinfo("signin","account/verify_credentials",$username, $dt); 
$httpReq = curl_init();
curl_setopt($httpReq, CURLOPT_URL, $url);
curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
curl_setopt($httpReq, CURLOPT_USERPWD, $username . ':' . $password);

$jsonret = curl_exec($httpReq);
curl_close($httpReq);

$data = json_decode($jsonret);

$profileimage=$data->profile_image_url;
$location=$data->location;
$description=$data->description;
$memberurl=$data->url;
if ($data->screen_name == $username) {

	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;

	// Check USer Name Exists In Users Table IF Not Insert in USer Table 
	$phpdate = date('Y-m-d H:i:s');
	$sql = "SELECT count(*) FROM ta_users WHERE UserName 	='$username'";

	$GetNoOfUsers = runQuery($sql);
	if ($GetNoOfUsers[0][0] == 0)
	 {
		$sqlsubs = "SELECT count(*) FROM ta_user_subscriptions WHERE UserName 	='$username'";
		$GetSubscriberscount = runQuery($sqlsubs);
		if ($GetSubscriberscount[0][0] == 0) {
			$refidcount = 0;
		} else {
			$sqlsubs = "SELECT * FROM ta_user_subscriptions WHERE UserName 	='$username'";
			$GetSubscriberscountvars = runQuery($sqlsubs);
			$refidcount = $GetSubscriberscountvars[0]["SubsID"];
		}
		$getmaxrefid = "SELECT MAX( `RefID` )FROM `ta_users`";
 		$getmaxrefidresult = runQuery($getmaxrefid);
 		$refidvalue =  $getmaxrefidresult[0][0]+1;
 		
		$sql = "INSERT INTO  `ta_users` (`RefID`, `UserName`, `Password`, `Email`, `DT`) VALUES ( '$refidvalue', '$username', password('$password'),'', '$phpdate');";
		$GetNoOfUsers = runQuery($sql);
		// Insert Empty Package ID in Subscription table 
		$sqlsubs = "INSERT INTO `ta_user_subscriptions` ( `UserName` ,`PackageID` ,`FeatureID` ,`DT`)VALUES (  '$username', '0', '0', '$phpdate')";
		$GetNoOfUserssqlsubs = runQuery($sqlsubs);
		$sql1 = "INSERT INTO `ta_user_keys` (`Username` ,`key` ,`secretkey`,`type`)VALUES ( '$username', '', '$password','yes')";
		$GetNoOfUsers = runQuery($sql1);
		 //insert into groupMembers table 
		$sqlmembers = "INSERT INTO `ta_group_member_profile` ( `memberName` ,`profileImage`,`memberLocation`,`profileDesc`,`memberUrl`)VALUES (  '$username', '$profileimage','$location','$description','$memberurl')";
		$GetNoOfmembers = runQuery($sqlmembers);
		  	} 
		  	else {

	}

	// Check USer Name Exists In Users Table IF Not Insert in USer Table 

	//header("Location: ../user/".$username);
	if(isset($_SESSION['pageurl']))
	{
	header("Location:".$_SESSION['pageurl']);
	}else{
	header("Location: ../user/home.php");
	}
	exit;
} else {
	header("Location:../index.php?act=1");
	exit;

}
?>
				
				 
				