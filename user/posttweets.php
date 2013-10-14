<?php  ob_start();
session_start();
include_once('../common/secret.php');
$userName=$_SESSION["username"];
require_once('../feed1/twitteroauth/twitteroauth.php');
require_once('../feed1/twitteroauth/OAuth.php');
require_once('../common/sqlFunctions.php');

//if ((!isset($_SESSION['oauth_access_token'])) || ($_SESSION['oauth_access_token'])=='') {

 ///$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
// $tok = $to->getAccessToken();

 /* Save tokens for later  - might be wise to
 * store the oauth_token and secret in a database, and
 * only store the oauth_token in a cookie or session for security purposes */
 
 
   $_SESSION['oauth_access_token'] =           $token  =   $authkey;
   $_SESSION['oauth_access_token_secret'] =    $secret =   $Skey;
 
 
 
 $dt=date('Y-m-d H:i:s');
 //$_SESSION['oauth_access_token'] =           $token  =   '92294609-TxnK0Cv10B8SSoffZTGR26iLIOv4zgljSjwQh7Sg';
 //$_SESSION['oauth_access_token_secret'] =    $secret =   'ml7HrAhBzACsnfa17GraSXVyj4Eq5R0myDDHOPJ3e5E';

//}

$to     =   new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

$token  =   $_SESSION['oauth_access_token'];
$secret =   $_SESSION['oauth_access_token_secret'];



              $status     =   $rssTweets[0]["tweet"];
         
         
         
             // $status =  str_replace('"','&quot;',$status);
             // $status =  str_replace('"','',$status);
            //exit;
            
            
           
            
           // $status = stripslashes($status);
            //	$status = preg_replace('/<[^>]*>/', '', $status);
            	
            	//$status = strip_tags($status);
            	
            	
   //  exit;
     
// exit;
 
     
     
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
    addapistatinfo("posttweets","statuses/update",$token, $dt); 
	// print "ok";
	print "<pre>";
	print_r($do_dm);
	print "<pre>";
	
	// exit;
	 

}
catch(Exception $o ){
    print_r($o);
  //  exit;
    
}
?>
