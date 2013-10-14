<?php
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
include '../common/dbconfig.php';
$name=$_REQUEST['name'];
$tweetmsg=$_REQUEST['tweetmsg'];
//get  campaign ids 
$phpdate = date('Y-m-d');
 
//get the username by userid 
$getusernamebyuserid = "SELECT * FROM ta_users  WHERE UserName ='$name'";
$getusernamebyuseridresult   = runQuery($getusernamebyuserid);
$uusernnname = $getusernamebyuseridresult[0]["UserName"];
// get userlogin details by username 
$getyuserlogindetailsbyusername = "SELECT * FROM ta_user_keys WHERE Username='$uusernnname'";
$getyuserlogindetailsbyusernameresult   = runQuery($getyuserlogindetailsbyusername);

$loginkey = $getyuserlogindetailsbyusernameresult[0]["key"];
$loginpassword = $getyuserlogindetailsbyusernameresult[0]["secretkey"];
include "hometweetsbykeys.php";
