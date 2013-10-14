<?php
session_start();

//include_once "../config/config.php";
 
// $consumer_key       = 'NqTrtlSKiPh5AshpLttpQ'; //your app's consumer key
//$consumer_secret   = 'yx908MDQzDSIlmJH9dKd5cWngNcBe1pFhTh8Zl6SVFE'; //your app's secret key



$consumer_key       = 'xJORoRaHuEVjJRXG0SXaA'; //your app's consumer key
$consumer_secret   = 'SdtvWaTIrrtu7wlvlgRAUZ95PbTRxgpTRDBFFcJr1pw'; //your app's secret key


 require_once('../feed1/twitteroauth/twitteroauth.php');
require_once('../feed1/twitteroauth/OAuth.php');


//if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 ///$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
// $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
 
 
 $_SESSION['oauth_access_token'] =           $token  =   $Getkeyfdetailsbyuseridresult[0]["key"];
 $_SESSION['oauth_access_token_secret'] =    $secret =   $Getkeyfdetailsbyuseridresult[0]["secretkey"];
 
 
 //$_SESSION['oauth_access_token'] =           $token  =   '92294609-TxnK0Cv10B8SSoffZTGR26iLIOv4zgljSjwQh7Sg';
 //$_SESSION['oauth_access_token_secret'] =    $secret =   'ml7HrAhBzACsnfa17GraSXVyj4Eq5R0myDDHOPJ3e5E';

//}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
     $status     =   $rssTweets[$i]["tweet"];
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
	 print "ok";
	//print "<pre>";
	//print_r($do_dm);
	//print "<pre>";
	
	 

}
catch(Exception $o ){
    print_r($o);
}
?>
