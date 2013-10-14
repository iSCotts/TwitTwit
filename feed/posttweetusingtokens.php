<?php
require_once('../common/twitteroauth.php');
require_once('../common/OAuth.php');
require_once('../common/commonfunctions.php');
include_once('../common/secret.php');

//$consumer_key       = 'xJORoRaHuEVjJRXG0SXaA'; //your app's consumer key
//$consumer_secret   = 'SdtvWaTIrrtu7wlvlgRAUZ95PbTRxgpTRDBFFcJr1pw'; //your app's secret key
$token  =   '92294609-TxnK0Cv10B8SSoffZTGR26iLIOv4zgljSjwQh7Sg';
 $secret =   'ml7HrAhBzACsnfa17GraSXVyj4Eq5R0myDDHOPJ3e5E';
 
 $status ="class test";
	print $PostTweetusingtokens = PostTweetUsingTokens($consumer_key, $consumer_secret, $token, $secret,$status);

	
?>
