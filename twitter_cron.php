<?php
include_once "config.php";

$sql        =   "SELECT * FROM options WHERE appid=1";
/*1 is your app you can dynamically map it for more than one application */
$result     =   $model->query($sql);

$token      =   $result[0]['twitter_token'];
$secret     =   $result[0]['twitter_secret'];
$status     =   "testing status";
/* you should make an admin from where you'll add status in database and retrieve those statuses and publish periodically */

//oAuth obj
try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

    $params     =   array('status' => $status);
    $do_dm      =   simplexml_load_string($to->OAuthRequest('http://twitter.com/statuses/update.xml', $params, 'POST'));
}
catch(Exception $o ){
    print_r($o);
}
?>
