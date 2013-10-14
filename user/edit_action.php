<?php
ob_start();
session_start();
 $refuser = $_SESSION["username"];
 $refpassword = $_SESSION["password"];
include "../config/config.php";
include "../common/sqlFunctions.php";
include "../classes/Database.php";
include "../classes/Mysql.php";

		
       $usernamenew = $_REQUEST["username1"];
	       $uidnew = $_REQUEST["uidnew"];
$passwordnew = $_REQUEST["password1"];
$RefID = $_REQUEST["RefID"];
 

$url = "http://twitter.com/account/verify_credentials.json";
$dt=date('Y-m-d H:i:s');
addapistatinfo("edit_action","account/verify_credentials",$usernamenew, $dt); 
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
	   // $sql = "SELECT count(*) FROM ta_users WHERE UserName 	='$usernamenew' AND RefID='$refuser'";
	   // $sql = "SELECT count(*) FROM ta_users WHERE UserName 	='$usernamenew'  ";
	   
	      $sql = "SELECT count(*) FROM ta_users WHERE UserName 	='$usernamenew'  AND Password=password('$passwordnew')";
	   
	   
		
	 // exit;
	  $GetNoOfUsers = runQuery($sql);
	  if($GetNoOfUsers[0][0] == 0  ||  $GetNoOfUsers[0][0] == 1){
	  
	    //-------------------
	    $sqlsubs = "SELECT *  FROM ta_user_subscriptions WHERE UserName 	='$refuser'";
	  
	  $GetSubscriberscount = runQuery($sqlsubs);
	 
	  $refidcount = $GetSubscriberscount[0]["SubsID"];
	   
	   //-------------------
	   
	   
	    //get currrent user name ref id 
	      $sqlrefi8d = "SELECT * FROM ta_users WHERE UserName 	='$refuser'  ";	  
	  $GetNoOfUserssqlrefi8d = runQuery($sqlrefi8d);
	  $maxrefid =   $GetNoOfUserssqlrefi8d[0]["RefID"];
	  
	  //get currrent user name ref id 
	  
	  
	   	
	   // $sql = "INSERT INTO  `ta_users` (`RefID`, `UserName`, `Password`, `Email`, `DT`) VALUES ( '$maxrefid', '$usernamenew', password('$passwordnew'),'', '$phpdate');";
   // $sql = "UPDATE  `ta_users` SET `RefID` = '$refidcount',`UserName` = '$usernamenew',`Password` =password('$passwordnew') WHERE  `UserID` ='$uidnew'";
  //  $sql = "UPDATE  `ta_users` SET `RefID` = '$refidcount',`UserName` = '$usernamenew',`Password` =password('$passwordnew') WHERE  `UserID` ='$uidnew' AND RefID='$RefID'";
     // $sql = "UPDATE  `ta_users` SET `RefID` = '$refidcount',`Password` =password('$passwordnew') WHERE  `UserID` ='$uidnew' AND RefID='$RefID'";
     
	   $sql = "UPDATE  `ta_users` SET `RefID` = '$RefID',`Password` =password('$passwordnew') WHERE  `UserID` ='$uidnew' AND RefID='$RefID'";
    
    
    
    
	 
	  $GetNoOfUsers = runQuery($sql);
	  
	  // update to user keys  table  as well 
	  
	  // check the user name avilable or not in userkeys table 
	    $checkuseravilableinuserkeys = "SELECT count(*) FROM ta_user_keys WHERE Username='$usernamenew'";
	   $checkuseravilableinuserkeysresult  = runQuery($checkuseravilableinuserkeys);
	   
	  
	   
	   
	    if($checkuseravilableinuserkeysresult[0][0] == 1){
	    	// update username/pwd with type = yes mode 
	    	
	    	  $updatekeysquery ="UPDATE `ta_user_keys` SET `key` = '',`secretkey` = '$passwordnew',`type` = 'yes' WHERE `Username` ='$usernamenew'";	
	    	 $updatekeysqueryresult  = runQuery($updatekeysquery);
	        }
	  
	        
	    if($checkuseravilableinuserkeysresult[0][0] == 0){
	    	// update username/pwd with type = yes mode 
	    	
	    	  $updatekeysquery ="INSERT INTO `ta_user_keys` (`Username`, `key`, `secretkey`, `type`) VALUES ('$usernamenew', '', '$passwordnew', 'yes')";
	    		
	    	 $updatekeysqueryresult  = runQuery($updatekeysquery);
	        }
	        
	        
	   
	  //   header("Location: ../index?act=3");
	   header("Location: add_account?act=5");
	        
	 exit;
	  }
	  else{
	//   header("Location: mutipleaccount.php?act=3");
	   header("Location: add_account?act=3");
	 exit;
	  }
	  
	  // Check USer Name Exists In Users Table IF Not Insert in USer Table 
	  
	 header("Location: add_account?act=5");
	 exit;
	 }
	 
	 else
	 {
	 
	  
	 
	// header("Location: mutipleaccount.php?act=1");
	 header("Location: add_account?act=1");
	 exit;
	 
	
	 
	 
	 }
	?>
				
				 
				