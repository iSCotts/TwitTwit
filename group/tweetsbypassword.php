<?php
session_start();
ob_start();
 
  $username = $loginname;
  $password = $loginpassword;
  $status = $TweetMessage;
 
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

	//print $status;
	echo "Tweet Posted";
	$phpdate = date('Y-m-d H:i:s');
    addapistatinfo("promotegroups","statuses/update",$username, $phpdate); 
	//check first same id's already exists 
		
}
else{
	//print $status;
	echo "Could not post Tweet to Twitter right now. Try again later.";
}


curl_close($curl);
}



     
  
?>