<?php ob_start();
session_start();
include_once '../common/dbconfig.php';
include_once '../common/dkall.php';
include_once '../common/secret.php';
$username=$_SESSION['username'];
include_once('../common/twitteroauth.php');
 $_SESSION['oauth_access_token'] =           $token  =  $loginkey;
 $_SESSION['oauth_access_token_secret'] =    $secret =  $loginpassword;
 $to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
$campaignID='0';
$appType = 'posttweets';
$comId = '0';
$text = $tweetmsg;
$status     =  dkCreatStringWithShortUrls($campaignID,$appType,$comId,$text);
try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);
    $params     =   array('status' => $status);
	$do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',$params));
	$phpdate = date('Y-m-d H:i:s');
	addapistatinfo("hometweets","statuses/update",$token, $phpdate);
}
catch(Exception $o ){
    print_r($o);
}
?>
