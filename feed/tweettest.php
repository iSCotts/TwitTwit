<?php
$str = 'tG9Bcm0lqJw673WGBTHqzo0DJ6kmo2I1LrqgBHw4H0==';
echo urldecode($str);


 

$username = 'lgx2';
$password = 'test123';
$status = 'TASSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS';

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