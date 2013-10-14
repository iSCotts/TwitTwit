<?php 
ob_start();
session_start();
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
$CampaignID = $_REQUEST["CampaignID"];
$feedrowid = $_REQUEST["feedrowid"];
$deletefeedresults = "DELETE  FROM ta_feed_results WHERE CampaignID='$CampaignID' && feedid='$feedrowid'"; 
$deletefeedresultsresult  = runQuery($deletefeedresults);
$sql = "DELETE  FROM ta_feeds WHERE CampaignID='$CampaignID' && id='$feedrowid'"; 
$GetAdminUserlist = runQuery($sql);
if($GetAdminUserlist  ==1)
{
	echo 'Problem while deleting ';
}
else
{
	echo 'User Deleted Succuessfully';
}