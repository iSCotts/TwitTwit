<?php
session_start();

// get the user keys for particular  user using session 

	  $getuserkeysinfoByUser = "SELECT * FROM ta_user_keys WHERE Username='$_SESSION[username]'";
	 
	
	$getuserkeysinfoByUserResult  = runQuery($getuserkeysinfoByUser);
	 
	
	// Check the Password type (If is Tokens /Password)
	
	if($getuserkeysinfoByUserResult[0]["type"] == 'yes'){
		
	  	$Uname = $getuserkeysinfoByUserResult[0]["Username"];
	  	$Pasword = $getuserkeysinfoByUserResult[0]["secretkey"];
		 
		
		//-------------------------------------------------------------------------------------------------
		include "posttweetsaftercreaterssusingpassword.php";
		//-------------------------------------------------------------------------------------------------
			
		
	}
	
	
	if($getuserkeysinfoByUserResult[0]["type"] == 'no'){
		
	  	$authkey = $getuserkeysinfoByUserResult[0]["key"];
	  	$Skey = $getuserkeysinfoByUserResult[0]["secretkey"];
		
	 
		
		//-------------------------------------------------------------------------------------------------
		include "posttweetsaftercreaterssusingkeys.php";
		//-------------------------------------------------------------------------------------------------
				
		
		
	}
	
	