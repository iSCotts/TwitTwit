<?php
session_start();

include_once "config.php";
 
if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
 $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
 $_SESSION['oauth_access_token'] =           $token  =   $tok['oauth_token'];
 $_SESSION['oauth_access_token_secret'] =    $secret =   $tok['oauth_token_secret'];

}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
$status     =   "testing status";
try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

  //  $params     =   array('status' => $status);
    //$params     =   array("status" => urlencode($status));
	//$params     =   "status=".urlencode($status);
	$params     =   "status";
	
    $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',array('status' => 'welcome liju ')));
	//print "done";
	print "<pre>";
	print_r($do_dm);
	print "<pre>";
	
	 

}
catch(Exception $o ){
    print_r($o);
}
?>
