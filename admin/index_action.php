<?php
		ob_start();
		include  "../classes/dbClient.php";
		include '../common/sqlFunctions.php';
		
// Check username and password matches 

		$Getnumberofrows = getAdminLogin($_REQUEST["username"],$_REQUEST["password"]);
		$sql="SELECT * FROM ta_admin_users WHERE username ='$_REQUEST[username]' && password = '$_REQUEST[password]'  && status='Active'";
		 $Getadminusertype = runQuery($sql);
		
// Check username and password matches 
		if($Getnumberofrows == 1)
		{
		session_start();
		$_SESSION["uname"] = $_REQUEST["username"];
		$_SESSION["atype"] = $Getadminusertype[0]["type"];
		$_SESSION["type"] = "yes";
		header("Location:homepage.php");
			}
		else
		{
		header("Location:index.php?act=1");
		exit;
		}					

?>