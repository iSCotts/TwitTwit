<?php

//define("USERNAME", "kumarphp7346");
//define("PASSWORD", "senthil");

include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
include_once ('../classes/class.twitter.php');
if ((int) $_REQUEST['name'] != 0) {
	$usrname = getUserName($_REQUEST['name']);
	$userName = $usrname[0]['UserName'];
} else {
	$userName = $_REQUEST['name'];
}
$getIDs = getUserPASSId($userName);
/**
 * initilize with twitter Api
 */

$summize = new summize("divyatjoseph", "divya1");
if ($getIDs[0]['type'] == 'no') {
	include ('../classes/twitteroauth.php');
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
}
elseif ($getIDs[0]['type'] == 'yes') {
	include_once ('../classes/class.twitter.php');
	$summize = new summize($userName, $getIDs[0]['secretkey']);
}
// Put all SimpleXML Object values into array so we can parse them with PHP's array tools
function simplexml2array($xml) {
   if (get_class($xml) == 'SimpleXMLElement') {
       $attributes = $xml->attributes();
       foreach($attributes as $k=>$v) {
           if ($v) $a[$k] = (string) $v;
       }
       $x = $xml;
       $xml = get_object_vars($xml);
   }
   if (is_array($xml)) {
       if (count($xml) == 0) return (string) $x; // for CDATA
       foreach($xml as $key=>$value) {
           $r[$key] = simplexml2array($value);
       }
       if (isset($a)) $r['@'] = $a;    // Attributes
       return $r;
   }
   return (string) $xml;
}

// Calls Twitter API and returns SimpleXML Object
$res=$summize->api($url,$method);
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

if($error = $summize->api("http://twitter.com/account/verify_credentials.xml")->error){ die("<strong>Error: </strong>$error"); }

// Gets a list of friends IDs and followers IDs
$friends = simplexml2array($summize->api("http://twitter.com/friends/ids.xml"));
$friends = $friends['id']; // Get rid of the multi-dimension variable
$followers = simplexml2array($summize->api("http://twitter.com/followers/ids.xml"));
$followers = $followers['id']; // Get rid of the multi-dimension variable

// Create arrays for queueing up follows/unfollows
$unfollowQueue = array(); 
$followQueue = array();

// Populate the queues
foreach(array_diff($friends, $followers) as $id){ array_push($unfollowQueue, $id); } // FRIENDS that are not in FOLLOWERS (unfollow)
foreach(array_diff($followers, $friends) as $id){ array_push($followQueue, $id); } // FOLLOWERS that are not in FRIENDS (follow)

// Process unfollow queue first
echo("<strong>Unfollowing...</strong><br />");
//foreach($unfollowQueue as $id){
for($i=0;$i<100;$i++)
{
	$id=$unfollowQueue[$i];
    $xml = $summize->api("http://twitter.com/friendships/destroy/$id.xml", "DELETE");
    if($error = $xml->error){
        echo("<span style='color:red;'>[ ERROR ]</span> $id ($error) <br />");
    } else {
        echo("<span style='color:green;'>[ SUCCESS ]</span> $id <br />");
    }
}
echo("<br /><br />");

echo("<strong>Following...</strong><br />");
foreach($followQueue as $id){
    $xml = $summize->api("http://twitter.com/friendships/create/$id.xml", "POST");
    if($error = $xml->error){
        echo("<span style='color:red;'>[ ERROR ]</span> $id ($error) <br />");
    } else {
        echo("<span style='color:green;'>[ SUCCESS ]</span> $id <br />");
    }
}

?> 