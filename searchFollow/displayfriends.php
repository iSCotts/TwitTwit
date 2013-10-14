<?php
/*
 * Created on 02-Feb-2010
 * Author :	liju
 * File:	userList.php
 *
 */
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');

$userdet=$_REQUEST['user'];
print $user;
$user=explode("+",$userdet);
print "user". $user=$user[0];
print "usertype".$usertype=$user[1];
print "key".$key=$user[2];
print "secretkey".$secretkey=$user[3];
exit;
if ($usertype == 'no') {
		/**
		 * validation using Keys
			*/
include ('../classes/twitteroauth.php');
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $userList[$i]['key'], $userList[$i]['secretkey']);
} else
	if ($usertype == 'yes') {
			/**
			 * validation normal
			 */
include_once ('../classes/class.twitter.php');
$summize = new summize($userList[$i]['Username'], $userList[$i]['secretkey']);
		}
// Put all SimpleXML Object values into array so we can parse them with PHP's array tools

// Calls Twitter API and returns SimpleXML Object
//$res=$summize->api($url,$method);
/*function api($url, $method="GET"){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
    $buffer = curl_exec($ch);
    curl_close($ch);
    return(simplexml_load_string($buffer));
}*/

//if($error = $summize->api("http://twitter.com/account/verify_credentials.xml")->error){ die("<strong>Error: </strong>$error"); }

// Gets a list of friends IDs and followers IDs
//$friends = simplexml2array($summize->api("http://twitter.com/friends/ids.xml"));
//$friends = $friends['id']; // Get rid of the multi-dimension variable




/*$userList=getAutoTextUserName($_GET['userID'],$_GET['q'],$_GET['campaignId']);
$userListCount=count($userList);
if($userListCount==0){
	echo "NO USERS";
}else{
for($i=0;$i<$userListCount;$i++){
	echo "{$userList[$i]['from_user']} \n";
}
}
*/
?>
