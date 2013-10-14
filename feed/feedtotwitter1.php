<?php
session_start();
 include_once "../config/config.php";
$consumer_key =CONSUMER_KEY;
$consumer_secret = CONSUMER_SECRET;
require_once('../feed1/twitteroauth/twitteroauth.php');
require_once('../feed1/twitteroauth/OAuth.php');
include_once('../common/sqlFunctions.php');
$dt=date('Y-m-d H:i:s');

//if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 ///$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
// $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
// $_SESSION['oauth_access_token'] =           $token  =   '92294609-TxnK0Cv10B8SSoffZTGR26iLIOv4zgljSjwQh7Sg';
// $_SESSION['oauth_access_token_secret'] =    $secret =   'ml7HrAhBzACsnfa17GraSXVyj4Eq5R0myDDHOPJ3e5E';


         $token  =   '40041578-AUcJt2Da0oL1E4bnUSlWqJT3iHIsXQDiB2kzrWeuh';
    $secret =   'tG9Bcm0lqJw673WGBTHqzo0DJ6kmo2I1LrqgBHw4H0';
 
 
//}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

 
print $status     =   $rssTweets[$i]["tweet"];
//  $status     =  urlencode('qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq sddsdsdsd');
try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

    $params     =   array('status' => $status);
    //$params     =   array("status" => urlencode($status));
	//$params     =   "status=".urlencode($status);
	//$params     =   "status";
	
   // $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',$params));
    $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/account/end_session.xml', 'POST',array()));
	addapistatinfo("feedtotwitter","account/end_session",$token, $dt); 
	print "<pre>";
	print_r($do_dm);
	print "<pre>";
	
	 

}
catch(Exception $o ){
    print_r($o);
}
?>
