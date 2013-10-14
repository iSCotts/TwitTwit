<?php
include_once '../common/dbconfig.php';
$freq_id 	= $_REQUEST["freq_id"];
$repeat 	= $_REQUEST["repeat"];
$random 	= $_REQUEST["random"];
$CampaignID = $_REQUEST["CampaignID"];
$rowid 		= $_REQUEST["rowid"];
$phpdate    = date('Y-m-d H:i:s');
$sql 		= "UPDATE `ta_save_tweets_settings` SET `Frequency` = '$freq_id',`Repeat` = '$repeat', `Random` = '$random' WHERE `CampaignID` ='$CampaignID' && `Id` ='$rowid' ";
db_connect();
mysql_query($sql);
db_close();
echo  "<div class=green>Saved</div>-".$CampaignID."-".$rowid;
	
	