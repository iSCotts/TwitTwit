<?php
include_once '../common/dbconfig.php';
$type= $_REQUEST["type"];
$cid= $_REQUEST["cid"];

// update campaign status 
if($type == "pause")
{
	$updatecampaignstatus = "UPDATE `ta_campaigns` SET `Status` = 'D' WHERE  `CampaignID` ='$cid'";
	db_connect();
	mysql_query($updatecampaignstatus);
	db_close();
	echo  "<img src=../images/play.png title='Play The Campaign' alt='' onclick=updateplaypasuse('play','".$cid."') >";
}
else if($type == "play")
{
	$updatecampaignstatus = "UPDATE `ta_campaigns` SET `Status` = 'A' WHERE  `CampaignID` ='$cid'";
	db_connect();
	mysql_query($updatecampaignstatus);
	db_close();
	echo  "<img src=../images/pause.png title='Pause The Campaign' alt='' onclick=updateplaypasuse('pause','".$cid."') >";
}
