<?php
ob_start();
session_start();
 $username = $_SESSION["username"];
 $_SESSION["username"] = '';
 $_SESSION["affiliateid"] = '';
 $_SESSION["aff_username"] = '';
 session_destroy();
 header("Location:../index");	 
	?>
				
				 
				