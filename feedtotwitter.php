<?php
session_start();

//include_once "../config/config.php";
 
 $consumer_key       = 'NqTrtlSKiPh5AshpLttpQ'; //your app's consumer key
$consumer_secret   = 'yx908MDQzDSIlmJH9dKd5cWngNcBe1pFhTh8Zl6SVFE'; //your app's secret key


 require_once('twitteroauth/twitteroauth.php');
require_once('twitteroauth//OAuth.php');


//if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 ///$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
// $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
 $_SESSION['oauth_access_token'] =           $token  =   '40041578-AUcJt2Da0oL1E4bnUSlWqJT3iHIsXQDiB2kzrWeuh';
 $_SESSION['oauth_access_token_secret'] =    $secret =   'tG9Bcm0lqJw673WGBTHqzo0DJ6kmo2I1LrqgBHw4H0';

//}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
$status     =   'am senthil';
try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

    $params     =   array('status' => $status);
    //$params     =   array("status" => urlencode($status));
	//$params     =   "status=".urlencode($status);
	//$params     =   "status";
	
    $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',array('status' => $status)));
	//print "done";
	print "<pre>";
	print_r($do_dm);
	print "<pre>";
	
	 

}
catch(Exception $o ){
    print_r($o);
}
?>
