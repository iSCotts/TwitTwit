<?php ob_start();
session_start();
include_once('common/sqlFunctions.php'); 
$username = $usernameK;
$password = $passwordK;

$status = $rssTweets[$i]["tweet"];
 
//$status = $rssTweets[0]["tweet"];

$phpdate = date('Y-m-d H:i:s');

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

	addapistatinfo("finaltweetpostusingpassword","statuses/update",$username, $phpdate);
	print $status;
	echo "Tweet Posted";
}
else{
	print $status;
	echo "Could not post Tweet to Twitter right now. Try again later.";
}
curl_close($curl);
}

?>
