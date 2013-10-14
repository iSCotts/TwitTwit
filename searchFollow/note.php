<?php
ob_start();
session_start();
include_once '../mail/sendMail.php';
 

//$email=$_SESSION['email'];
$payment_status = $_POST['payment_status'];



include_once '../classes/dbClient.php';
	include_once '../common/sqlFunctions.php';
	
	
	 $dateforreport =   date("Y-m-d");
	$time = date("H:i:s");
	
	
	/*$sqlforupdate ="UPDATE `ta_user_subscriptions` SET `PaymentStatus` = '$_POST[payment_status]',
`Paymentdate` = '$_POST[payment_date]',
`Payment` = '$_POST[mc_gross]' ,
`SD` = '$dateforreport',
`ST` = '$time',
`paymenttype` = '$_POST[mc_gross]',
`txtid` = '$_POST[mc_gross]'
 WHERE  `Custom` ='$_POST[custom]'";*/
	$payment_type = $_POST["payment_type"];
	$txn_id = $_POST["txn_id"];
	
 
 $sqlforupdate ="UPDATE `ta_user_subscriptions` SET `PaymentStatus` = '$_POST[payment_status]',
`Paymentdate` = '$_POST[payment_date]',
`Payment` = '$_POST[mc_gross]' ,
`SD` = '$dateforreport',
`ST` = '$time',
`paymenttype` = '$payment_type',
`txtid` = '$txn_id'
 WHERE  `Custom` ='$_POST[custom]'";
 
	
	 runQuery($sqlforupdate);
	 
	 
	 
  
	 
	
	
	 
	
	
	
