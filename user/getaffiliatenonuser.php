<?php
session_start();
$_SESSION["aff_username"]=$_REQUEST["username"];
include_once '../common/dbconfig.php';
include_once "../config/config.php";
$username = $_REQUEST["username"];
$pass = $_REQUEST["pass"];
$email = $_REQUEST["email"];
$gettodaydate  = date('Y-m-d');
db_connect();
$checkuseralreadyexits = "SELECT count(*) FROM ta_affiliate_request WHERE UserID ='$username'";
$checkuseralreadyexitsquery = mysql_query($checkuseralreadyexits);
$checkuseralreadyexitsqueryresult =  mysql_fetch_array($checkuseralreadyexitsquery);
$finalMsg = 'no';
if($checkuseralreadyexitsqueryresult[0] == 0)
{
	$token = md5(uniqid(rand(),1));
	$sql = "INSERT INTO  `ta_affiliate_request` (`UserID` ,`password` ,`EmailId` ,`Date`,`affiliateid`,`type`,`Status`) VALUES ( '$username', '$pass', '$email', '$gettodaydate' ,'$token','no','A') ";
	mysql_query($sql);
	$finalMsg = 'yes';
	$url= SITE_URL."index.php?q=".$token;
	$to = $email;
	$Mesasge = "Your Affiliate URL ".$url;
	$subject = "Your Affiliate URL";
	$headers = 'From: no-reply@twitjix.com' . "\r\n" .
			'Reply-To: no-reply@twitjix.com' . "\r\n" .
			'Cc: no-reply@twitjix.com' . "\r\n".
			'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $Mesasge, $headers);
}
else
{
			$finalMsg = 'no';
}
echo $finalMsg;
db_close();
?>