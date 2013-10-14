<?php
$twitter_api_url = "http://twitter.com/statuses/update.xml";
$twitter_data = "status=Visit http://www.twitjix.com";
$twitter_user = "divyatjoseph";
$twitter_password = "divya1";
$ch = curl_init($twitter_api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $twitter_data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, "{$twitter_user}:{$twitter_password}");
$twitter_data = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($httpcode != 200) {
echo "<strong>Don't Panic!</strong> Something went wrong, and the tweet wasn't posted correctly.";
}
?>