<?php
ob_start();
session_start();
      $username = $_SESSION["username"];
		//$password = $_SESSION["password"];
		
		
		
	// $username = 'streetjammer';
		//$password = 'logicsupport123';
		
		
/*$url = "http://twitter.com/account/end_session.json";

$httpReq = curl_init();
curl_setopt($httpReq, CURLOPT_URL, $url);
curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
curl_setopt($httpReq, CURLOPT_USERPWD, $username . ':' . $password);
curl_setopt($httpReq, CURLOPT_POST, true);
 



$jsonret = curl_exec($httpReq);
curl_close($httpReq);

$data = json_decode($jsonret);

	print "<pre>";
	print_r($data);
	 print "<pre>";
	 
	 */
	 
	// if($data->error == "Logged out."){
	 $_SESSION["username"] = '';
	// $_SESSION["password"] ='';
	 session_destroy();
	// header("Location:../index.php");
	 header("Location:../index");
	 exit;
	 
	// }
	 
	 
	?>
				
				 
				