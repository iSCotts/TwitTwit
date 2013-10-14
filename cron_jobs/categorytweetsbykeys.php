<?php ob_start();
session_start();
include_once('../common/sqlFunctions.php'); 
include_once "../config/config.php";
$consumer_key       = CONSUMER_KEY; //your app's consumer key
$consumer_secret   = CONSUMER_SECRET; //your app's secret key


 require_once('../feed1/twitteroauth/twitteroauth.php');
 
//require_once('feed1/twitteroauth/OAuth.php');


//if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 ///$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
// $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
 
 
 $_SESSION['oauth_access_token'] =           $token  =  $loginkey;
 $_SESSION['oauth_access_token_secret'] =    $secret =  $loginpassword;
 
 
 //$_SESSION['oauth_access_token'] =           $token  =   '92294609-TxnK0Cv10B8SSoffZTGR26iLIOv4zgljSjwQh7Sg';
 //$_SESSION['oauth_access_token_secret'] =    $secret =   'ml7HrAhBzACsnfa17GraSXVyj4Eq5R0myDDHOPJ3e5E';

//}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];
     $status     =   $UpdatedTweetMessage;
     
     
     
     
     
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
	$phpdate = date('Y-m-d H:i:s');
    $do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',$params));
	addapistatinfo("categorytweets","statuses/update",$token, $phpdate);
    // print "ok";
	print "<pre>";
	print_r($do_dm);
	print "<pre>";
	//update the post tweet status to save tweets table 
	
	
	//check first same id's already exists 
	
	$checkingsameids ="SELECT count(*) FROM ta_category_tweet_messages_status WHERE CampaignId='$CampaignID' && CategoryId='$Ucategoryid[$m]' &&  MessageId='$rowid[$m]'  && Status='Y' ";
	$checkingsameidsresult  = runQuery($checkingsameids);
	
	if($checkingsameidsresult[0][0] == 0 ){
		
		
	
	//update the post tweet status to save tweets table 
	$updatestatustotweetstable="INSERT INTO  `ta_category_tweet_messages_status` (
 
`CampaignId` ,
`CategoryId` ,
`MessageId` ,
`Status` ,
`DT`
)
VALUES (  '$CampaignID', '$Ucategoryid[$m]', '$rowid[$m]', 'Y', '$phpdate')";
	
	$updatestatustotweetstableresult  = runQuery($updatestatustotweetstable);
	 
	}
	
	

}
catch(Exception $o ){
    print_r($o);
}
?>
