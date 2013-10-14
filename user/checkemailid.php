<?php
include_once '../common/dbconfig.php';
$usernamea = $_REQUEST["usernamea"];
$gettodaydate  = date('Y-m-d');
$checkemailid = "SELECT * FROM ta_user_subscriptions WHERE UserName ='$usernamea'"; 
db_connect();
$checkemailidquery = mysql_query($checkemailid);
db_close();
$checkemailidqueryresult  =  mysql_fetch_array($checkemailidquery);
if($checkemailidqueryresult["Email"]  !="")
{
	echo $checkemailidqueryresult["Email"];
}
else
{
	echo 0;
}