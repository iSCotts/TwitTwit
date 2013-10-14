<?php
session_start();
$_GET['action']='ipn';
$username = $_REQUEST['os0'];
$_SESSION['username']="divya";
 $item_name = $_POST['item_name'];
 $item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
 $payment_amount = $_POST['mc_gross'];
 $payment_currency = $_POST['mc_currency'];
 $txn_id = $_POST['txn_id'];
echo  $item_name;
echo  $item_number ;
echo $payment_status;
echo  $payment_amount;
echo  $payment_currency;
echo  $txn_id ;
echo $username;
?>