<?php
session_start();
if(isset($_SESSION['username'])||$_SESSION['username']!=""){
   header("Location:newAccount.php");
}
else{
   header("Location:../index.php");
}
?>	
	
	
	