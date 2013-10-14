<?php
 
 
      $username = $_SESSION["username"];   
		$password = $_SESSION["password"];
		
		 // $username = "kumarphp7346";
		// $password = "senthil";
		
include "../common/sqlFunctions.php";
		 
		
		
		
$url = "http://twitter.com/followers/ids.json";
$dt=date('Y-m-d H:i:s');
addapistatinfo("followers","followers/ids",$username, $dt); 

$httpReq = curl_init();
curl_setopt($httpReq, CURLOPT_URL, $url);
curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
curl_setopt($httpReq, CURLOPT_USERPWD, $username . ':' . $password);

$jsonret = curl_exec($httpReq);
curl_close($httpReq);

$data = json_decode($jsonret);

	//print "<pre>";
	$followerresult = count($data);
	// print "<pre>";
	 
	 
	 
	?>
				
				 
				