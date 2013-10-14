<?php 
include '../common/secret.php';
include '../classes/twitteroauth.php';
$oAuthObj = new TwitterOAuth($consumer_key,$consumer_secret);
$url = 'http://twitter.com/users/show.json';
$x = get_object_vars($oAuthObj->get($url,array('screen_name'=>'sharonvivek')));
echo $x['error'];