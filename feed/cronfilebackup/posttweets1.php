<?php
session_start();
 
$username = $Getkeyfdetailsbyuseridresult[0]["Username"];
$password = $Getkeyfdetailsbyuseridresult[0]["secretkey"];

$status = $rssTweets[$i]["tweet"];

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

if ($resultArray['http_code'] == 200)
echo "Tweet Posted";
else
echo "Could not post Tweet to Twitter right now. Try again later.";

curl_close($curl);
}



     
  
?>
