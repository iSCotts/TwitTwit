<?php
session_start();
ob_start();
 
  $username = $loginname;
  $password = $loginpassword;

     $status = $UpdatedTweetMessage;
 include_once('common/sqlFunctions.php'); 
  
 
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

if ($resultArray['http_code'] == 200){

	print $status;
	echo "Tweet Posted";
	$phpdate = date('Y-m-d H:i:s');
	
	//check first same id's already exists 
	
	 
	
	//update the post tweet status to save tweets table 
	$updatestatustotweetstable="UPDATE  `ta_future_tweet_messages` SET `Status` = 'Y' WHERE  `id` ='$rowid[$m]'";
	
	$updatestatustotweetstableresult  = runQuery($updatestatustotweetstable);
	 
	addapistatinfo("futuretweetsbypassword","statuses/update",$username, $phpdate);
	
	
}
else{
	print $status;
	echo "Could not post Tweet to Twitter right now. Try again later.";
}


curl_close($curl);
}



     
  
?>
