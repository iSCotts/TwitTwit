<?php
include '../classes/dbClient.php';
include "../common/EpiCurl.php";
include "../common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
$url=$twitterObj->getAuthenticateUrl();
header("location:".$url);
?>

