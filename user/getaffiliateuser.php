<?php
include_once '../common/dbconfig.php';
include_once "../config/config.php";
$username = $_REQUEST["username"];
$susername = $_REQUEST["susername"];
$gettodaydate  = date('Y-m-d');
db_connect();
$checkemailidalreadyexits = "SELECT count(*) FROM ta_affiliate_request WHERE EmailId ='$username' and type='yes'";
$checkemailidalreadyexitsquery = mysql_query($checkemailidalreadyexits);
$checkemailidalreadyexitsqueryresult =  mysql_fetch_array($checkemailidalreadyexitsquery);
$finalMsg = 'no';
if($checkemailidalreadyexitsqueryresult[0] == 0)
{
	$token = md5(uniqid(rand(),1));
	$sql = "INSERT INTO  `ta_affiliate_request` (`UserID` ,`EmailId` ,`Date`,`affiliateid`,`type`,`Status`) VALUES ( '$susername', '$username', '$gettodaydate' ,'$token','yes','A') ";
	mysql_query($sql);
	$url= SITE_URL."index.php?q=".$token;
	$to = $username;
	$Mesasge = "Your Affiliate URL ".$url;
	$subject = "Your Affiliate URL";
	$headers = 'From: no-reply@twitjix.com' . "\r\n" .
			'Reply-To: no-reply@twitjix.com' . "\r\n" .
			'Cc: no-reply@twitjix.com' . "\r\n".
			'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $Mesasge, $headers);
	// check usersubscription table have email id ID not nede to  uodate the email record to that table 
	$checkemailidexists ="SELECT * FROM ta_user_subscriptions WHERE UserName ='$susername'";
	$checkemailidexistsquery = mysql_query($checkemailidexists);
	$checkemailidexistsqueryresult = mysql_fetch_array($checkemailidexistsquery);
	if(count($checkemailidexistsqueryresult)>0)
	{
		if(empty($checkemailidexistsqueryresult["EmailId"]))
		{
			$updateusersusbtable = "UPDATE  `ta_user_subscriptions` SET `Email` = '$_REQUEST[username]' WHERE  UserName ='$susername'";
			mysql_query($updateusersusbtable);
			$finalMsg = 'yes';
		}
		else
		{
			$finalMsg = 'no';
		}
	}
	else
	{
			$finalMsg = 'no';
	}
}
else
{
			$finalMsg = 'no';
}
echo $finalMsg;
db_close();
?>