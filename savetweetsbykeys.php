<?php ob_start();
session_start();
include_once('common/secret.php');
//include_once "../config/config.php";
//$consumer_key       = 'xJORoRaHuEVjJRXG0SXaA'; //your app's consumer key
//$consumer_secret   = 'SdtvWaTIrrtu7wlvlgRAUZ95PbTRxgpTRDBFFcJr1pw'; //your app's secret key


 require_once('feed1/twitteroauth/twitteroauth.php');
 include_once('common/sqlFunctions.php');
//require_once('feed1/twitteroauth/OAuth.php');


//if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 ///$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
// $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
 
 
 $_SESSION['oauth_access_token'] =           $token  =  $loginkey;
 $_SESSION['oauth_access_token_secret'] =    $secret =  $loginpassword;
 $dt=date('Y-m-d H:i:s');
 
 //$_SESSION['oauth_access_token'] =           $token  =   '92294609-TxnK0Cv10B8SSoffZTGR26iLIOv4zgljSjwQh7Sg';
 //$_SESSION['oauth_access_token_secret'] =    $secret =   'ml7HrAhBzACsnfa17GraSXVyj4Eq5R0myDDHOPJ3e5E';

//}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
     $status     =   $tweetmessage;
     
     
     
     
  //   $status     =   $rssTweets[0]["tweet"];
   //print($status);
   //print "<br>";
 
//  $status     =  urlencode('qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq sddsdsdsd');
try {
    $to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);

      $params     =   array('status' => $status);
	 // print_r($params);

  
    //$params     =   array("status" => urlencode($status));
	//$params     =   "status=".urlencode($status);
	//$params     =   "status";
	
    $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',$params));
	// print "ok";
	addapistatinfo("savetweetsbykeys","statuses/update",$token, $dt); 
	print "<pre>";
	print_r($do_dm);
	print "<pre>";
	//update the post tweet status to save tweets table 
	$updatestatustotweetstable="UPDATE `ta_save_tweets` SET `PostStatus` = 'Y' WHERE `id` ='$rowid' && CampaignID='$CampaignID'";
	$updatestatustotweetstableresult  = runQuery($updatestatustotweetstable);
	 
	 

}
catch(Exception $o ){
    print_r($o);
}
?>
