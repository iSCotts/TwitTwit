<?php
session_start();
ob_start();
 include_once('common/sqlFunctions.php');
  $username = $loginname;
  $password = $loginpassword;

  $status = $tweetmessage;
  
 $dt=date('Y-m-d H:i:s');
//$status = $rssTweets[0]["tweet"];



if ($status) {
	 
	
$tweetUrl = 'http://www.twitter.com/statuses/update.xml';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "$tweetUrl");
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, "status=$status");
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

$result = curl_exec($curl);
$resultArray = curl_getinfo($curl);
print "<pre>";
print_r($resultArray);
print "<pre>";
if ($resultArray['http_code'] == 200){

	print $status;
	echo "Tweet Posted";
	
	//update the post tweet status to save tweets table 
	$updatestatustotweetstable="UPDATE `ta_save_tweets` SET `PostStatus` = 'Y' WHERE `id` ='$rowid' && CampaignID='$CampaignID'";
	$updatestatustotweetstableresult  = runQuery($updatestatustotweetstable);
	addapistatinfo("savetweetsbypassword","statuses/update",$username, $dt); 
	
	
}
else{
	print $status;
	echo "Could not post Tweet to Twitter right now. Try again later.";
}


curl_close($curl);
}



     
  
?>
