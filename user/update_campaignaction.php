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
$campaignrowid = $_REQUEST["campaignrowid"];
if($startdate>$phpdate)
{
	$status ="D";
}
else
{
	 $status ="A";
}
// Check the campaign name already exists in campaign table 
//$checkcampaignavilable = "SELECT count(*) FROM ta_campaigns WHERE CampaignName='$campaignname'";
$checkcampaignavilable="SELECT  c.CampaignID as campid FROM ta_campaigns c LEFT JOIN ta_users u ON c.`RefID`=u.`RefID` where c.`CampaignName` ='$campaignname' and u.`RefID`='$refid' and c.`CampaignID`!='$campaignrowid'";
$checkcampaignavilableresult = mysql_query($checkcampaignavilable);
$checkcampaignavilableresult1 = mysql_fetch_array($checkcampaignavilableresult);
// IF campaign name is not avilable will insert 
if(mysql_num_rows($checkcampaignavilableresult)== 0)
{
	$updatecampaign = "UPDATE `ta_campaigns` SET `CampaignName` = '$campaignname',`Campaigndesc` = '$campaignnamedesc',`StartDT` = '$startdate',`EndDT` = '$enddate' WHERE `CampaignID` ='$campaignrowid'";
	$updatecampaignresultr  = mysql_query($updatecampaign);
	echo "<div class=green>Saved</div>-".$campaignrowid;
}
else
{
	$lastid = 0;
	echo "Your details already there try again-".$lastid;
}
db_close();
	  
	  
