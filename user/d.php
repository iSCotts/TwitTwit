<?php
ob_start();
session_start();
 
//exit;
 
 $updatedsessionusername =  $_SESSION["username"];
   $refuser = $_SESSION["username"];
    $refpassword = $_SESSION["password"];
include "../common/sqlFunctions.php";
include "../classes/Database.php";
include "../classes/Mysql.php";
include "../config/config.php";
		
       $usernamenew = $_REQUEST["username1"];
	   
$passwordnew = $_REQUEST["password1"];
$url = "http://twitter.com/account/verify_credentials.json";

$httpReq = curl_init();
curl_setopt($httpReq, CURLOPT_URL, $url);
curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
curl_setopt($httpReq, CURLOPT_USERPWD, $usernamenew . ':' . $passwordnew);

$jsonret = curl_exec($httpReq);
curl_close($httpReq);

$data = json_decode($jsonret);

	 $_SESSION["username"] =$refuser;
	 $_SESSION["password"] =$refpassword;
	 
	// print $data->screen_name;
	 //print $_REQUEST["username1"];
	 //exit;
	 if($data->screen_name == $usernamenew){
	 
	  
	
	   // Check USer Name Exists In Users Table IF Not Insert in USer Table 
	   $phpdate = date( 'Y-m-d H:i:s' );
	   // $sql = "SELECT count(*) FROM Users WHERE UserName 	='$usernamenew' AND RefID='$refuser'";
	      $sql = "SELECT count(*) FROM ta_users WHERE UserName 	='$usernamenew'  ";
	 // exit;
	  $GetNoOfUsers = runQuery($sql);
	  
	  
	  
	  if($GetNoOfUsers[0][0] == 0){
	  
	   //-------------------
	    $sqlsubs = "SELECT *  FROM ta_user_subscriptions WHERE UserName 	='$updatedsessionusername'";
	  
	  $GetSubscriberscount = runQuery($sqlsubs);
	 
	  $refidcount = $GetSubscriberscount[0]["SubsID"];
	   
	   //get currrent user name ref id 
	        $sqlrefi8d = "SELECT * FROM ta_users WHERE UserName 	='$updatedsessionusername'  ";
	   
	   	  
	  $GetNoOfUserssqlrefi8d = runQuery($sqlrefi8d);
	    $maxrefid =   $GetNoOfUserssqlrefi8d[0]["RefID"];
	  
	  //get currrent user name ref id 
	   
	   
	   //-------------------
	      $sql = "INSERT INTO  `ta_users` (`RefID`, `UserName`, `Password`, `Email`, `DT`) VALUES ( '$maxrefid', '$usernamenew', password('$passwordnew'),'', '$phpdate');";
	 
	  $GetNoOfUsers = runQuery($sql);
	  
	  
	    
	    //Insert user keys tabl to username/password -------------------
	  $insertuserkey ="INSERT INTO `ta_user_keys` (`Username`, `key`, `secretkey`, `type`) VALUES ('$usernamenew', '', '$passwordnew', 'yes')";
	    		
	    	 $insertuserkeyresult  = runQuery($insertuserkey);
	  
	  
	  }
	  else{
	  // header("Location: mutipleaccount.php?act=3");
	   header("Location: add_account?act=3");
	 exit;
	  }
	  
	  // Check USer Name Exists In Users Table IF Not Insert in USer Table 
	  
	 header("Location: add_account?act=2");
	 exit;
	 }
	 
	 else
	 {
	 
	  
	 
	// header("Location: mutipleaccount.php?act=1");
	 header("Location: add_account?act=1");
	 exit;
	 
	
	 
	 
	 }
	?>
				
				 
				