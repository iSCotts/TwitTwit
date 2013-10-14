<?php
include_once '../common/dbconfig.php';
$susernmaeee = $_REQUEST["ssusername"];
$CampaignIDuuuu = $_REQUEST["CampaignID"];
$username = $_REQUEST["usernamefff"];
db_connect();
// get user id by username 
$getuseridbyusername = "SELECT * FROM ta_users WHERE UserName='$username'";
$getuseridbyusernameresult  = mysql_query($getuseridbyusername);
$getuseridbyusernameresultq = mysql_fetch_array($getuseridbyusernameresult);
$addedusername =  $getuseridbyusernameresultq["UserID"];
// get all user field for using campaign id 
$getuseridbycampaignid = "SELECT * FROM ta_campaigns WHERE CampaignID='$CampaignIDuuuu'";
$getuseridbycampaignidresult  = mysql_query($getuseridbycampaignid);
$getuseridbycampaignidresultqqqqqqqqqq = mysql_fetch_array($getuseridbycampaignidresult);
$usersfromdatabase =  $getuseridbycampaignidresultqqqqqqqqqq["UserID"];
//concat all userid's with comma separated 
$makecommaseparated = $usersfromdatabase."-".$addedusername;
// 	Get REfID using username from users Table 
$getrefidusingusername ="SELECT * FROM ta_users WHERE UserName='$susernmaeee'";
$getrefidusingusernameresult  = mysql_query($getrefidusingusername);
$getrefidusingusernameresultq =  mysql_fetch_array($getrefidusingusernameresult);
$refid = $getrefidusingusernameresultq["RefID"];
// 	Get REfID using username from users Table 
// Update campaign table by campaign id and refid
$updatecampaigntablewithuseridsffff = "UPDATE `ta_campaigns` SET `UserID` = '$makecommaseparated' WHERE `CampaignID` ='$CampaignIDuuuu' AND RefID='$refid'";
$updatecampaigntablewithuseridsffffresuly   = mysql_query($updatecampaigntablewithuseridsffff);
//print "Saved";
echo "The account has been added-".$CampaignIDuuuu;
db_close();

  