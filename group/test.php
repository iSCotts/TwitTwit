<?php
// Created by Chris S. / FluidMarkup.com / chris@fluidmarkup.com
// May 2009 / Twitter / API v1
// Remember to change USERNAME and PASSWORD below
// Modify/redistribute the script as you see fit, but please leave this header intact 

// Change this if required
define("USERNAME", "divyatjoseph");
define("PASSWORD", "divya1");

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
function api($url, $method="GET"){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
    $buffer = curl_exec($ch);
    curl_close($ch);
    return(simplexml_load_string($buffer));
}

if($error = api("http://twitter.com/account/verify_credentials.xml")->error){ die("<strong>Error: </strong>$error"); }

// Gets a list of friends IDs and followers IDs
$friends = simplexml2array(api("http://twitter.com/friends/ids.xml"));
$friends = $friends['id']; // Get rid of the multi-dimension variable
$followers = simplexml2array(api("http://twitter.com/followers/ids.xml"));
$followers = $followers['id']; // Get rid of the multi-dimension variable

// Create arrays for queueing up follows/unfollows
$unfollowQueue = array(); 
$followQueue = array();

// Populate the queues
foreach(array_diff($friends, $followers) as $id){ array_push($unfollowQueue, $id); } // FRIENDS that are not in FOLLOWERS (unfollow)
foreach(array_diff($followers, $friends) as $id){ array_push($followQueue, $id); } // FOLLOWERS that are not in FRIENDS (follow)

// Process unfollow queue first
echo("<strong>Unfollowing...</strong><br />");
foreach($unfollowQueue as $id){
    $xml = api("http://twitter.com/friendships/destroy/$id.xml", "DELETE");
    if($error = $xml->error){
        echo("<span style='color:red;'>[ ERROR ]</span> $id ($error) <br />");
    } else {
        echo("<span style='color:green;'>[ SUCCESS ]</span> $id <br />");
    }
}
echo("<br /><br />");

echo("<strong>Following...</strong><br />");
foreach($followQueue as $id){
    $xml = api("http://twitter.com/friendships/create/$id.xml", "POST");
    if($error = $xml->error){
        echo("<span style='color:red;'>[ ERROR ]</span> $id ($error) <br />");
    } else {
        echo("<span style='color:green;'>[ SUCCESS ]</span> $id <br />");
    }
}

?> 