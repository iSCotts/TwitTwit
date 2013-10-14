<?php

	include_once '../classes/dbClient.php';
	include_once '../common/sqlFunctions.php';
		
	$payment_status = $_REQUEST["payment_status"];
	$payment_date = $_REQUEST["payment_date"];
	$payment_type = $_REQUEST["payment_type"];
	$mc_gross    = $_REQUEST["mc_gross"];
	$txn_id = $_REQUEST["txn_id"];
	$custom = $_REQUEST["custom"];
	$dateforreport =   date("Y-m-d");
	$time = date("H:i:s");
	$insertdata = "INSERT INTO `ta_user_subscriptions` (`UserName` ,`Email` ,`PackageID` ,`FeatureID` ,`DT` ,`Custom` ,`PaymentStatus` ,`Paymentdate` ,`Payment` ,`SD` ,`ST` ,`paymenttype` ,`txtid`)
VALUES ('', '', '', NULL , '', '$custom', '$payment_status', '$payment_date', '$mc_gross', '$dateforreport', '$time', '$payment_type', '$txn_id')";
	runQuery($insertdata);
	