<?php
include "configoriginal.php";
$cid = $_REQUEST["d"];
$uk = $_REQUEST["uk"];
$status = $_REQUEST["status"];
if($status=="B")
{
$updatequery = "UPDATE  `ta_users` SET `ACStatus` = 'B' WHERE  `UserID` ='$cid'";
mysql_query($updatequery);
}
if($status=="P")
{
$updatequery = "UPDATE  `ta_users` SET `ACStatus` = 'P' WHERE  `UserID` ='$cid'";
mysql_query($updatequery);
}
//echo "bsearchusers.php?uk=$uk";
// header("Location:bsearchusers.php?uk=$uk");