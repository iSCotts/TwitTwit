<?php
session_start();
include_once '../common/dbconfig.php';
db_connect();
// 	Get REfID using username from users Table 
$getrefidusingusername ="SELECT * FROM ta_users WHERE UserName='$_SESSION[username]'";
$getrefidusingusernameresult  = mysql_query($getrefidusingusername);
$getrefidusingusernameresultresult = mysql_fetch_array($getrefidusingusernameresult);
//$refid = $getrefidusingusernameresultresult[0]["RefID"];
$refid = $getrefidusingusernameresultresult["RefID"];
// 	Get REfID using username from users Table 
// get All values From Add Campaingn Form 
$campaignname = addslashes($_REQUEST["campaignname"]);
$campaignnamedesc = addslashes($_REQUEST["campaignnamedesc"]);
$startdate = $_REQUEST["startdate"];
$enddate = $_REQUEST["enddate"];
$phpdate = date('Y-m-d');
if($startdate>$phpdate)
{
	$status ="D";
}
else
{
	 $status ="A";
}
// Check the campaign name already exists in campaign table 
$checkcampaignavilable="SELECT u.`UserID`,c.`CampaignName` FROM ta_campaigns c LEFT JOIN ta_users u ON c.`RefID`=u.`RefID` where c.`CampaignName` ='$campaignname' and u.`RefID`='$refid'";
//$checkcampaignavilable = "SELECT count(*) FROM ta_campaigns WHERE CampaignName='$campaignname'";
$checkcampaignavilableresult = mysql_query($checkcampaignavilable);
$checkcampaignavilableresult = mysql_fetch_array($checkcampaignavilableresult);
// IF campaign name is not avilable will insert 
if($checkcampaignavilableresult[0][0] == 0)
{
	$Insertcampaign = "INSERT INTO `ta_campaigns` (`RefID`,`CampaignName` ,`Campaigndesc`,`DT` ,`StartDT` ,`EndDT` ,
	`Status`)VALUES ('$refid','$campaignname', '$campaignnamedesc','$phpdate', '$startdate', '$enddate', '$status')";
	$Insertcampaignresult  = mysql_query($Insertcampaign);
	$lastid = mysql_insert_id();
	$_SESSION["SCampaignId"] = $lastid;
	echo '<div class=green>Saved</div>-'.$lastid;
}
else
{
	$lastid = 0;
	echo  "Your details already there try again-".$lastid;
}
db_close();	  