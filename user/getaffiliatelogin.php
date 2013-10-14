<?php
include_once '../common/dbconfig.php';
include_once "../config/config.php";
$username = $_REQUEST["username"];
$pass = $_REQUEST["pass"];
$gettodaydate  = date('Y-m-d');
db_connect();
$checkuseralreadyexits = "SELECT count(*) FROM ta_affiliate_request WHERE UserID ='$username' &&  password='$pass' && type='no'";
$checkuseralreadyexitsquery = mysql_query($checkuseralreadyexits);
$checkuseralreadyexitsqueryresult =  mysql_fetch_array($checkuseralreadyexitsquery);
$finalMsg = 'no';
if($checkuseralreadyexitsqueryresult[0] > 0)
{
    session_start();
	$_SESSION["aff_username"] = $username;
	$_SESSION["aff_password"] =$pass;
	$finalMsg = 'yes';
	}
else
{
	$finalMsg = 'no';
}
echo $finalMsg;
db_close();
?>