<?php ob_start();
session_start();
include_once('../common/secret.php');
$username=$_SESSION['username'];
 require_once('twitteroauth/twitteroauth.php');
 $_SESSION['oauth_access_token'] =           $token  =  $loginkey;
 $_SESSION['oauth_access_token_secret'] =    $secret =  $loginpassword;
 
 $to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
$status     =   $TweetMessage;

try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

    $params     =   array('status' => $status);
		
    $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',$params));
	// print "ok";
	//print "<pre>";
	//print_r($do_dm);
	//print "<pre>";
	//update the post tweet status to save tweets table 
	$phpdate = date('Y-m-d H:i:s');
	addapistatinfo("promotegroups","statuses/update",$token, $phpdate);

}
catch(Exception $o ){
    print_r($o);
}
?>
