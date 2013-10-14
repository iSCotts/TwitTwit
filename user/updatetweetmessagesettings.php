<?php
include_once '../common/dbconfig.php';
$freq_id =$_REQUEST["freq_id"];
$repeat =$_REQUEST["repeat"];
$random =$_REQUEST["random"];
$CampaignID =$_REQUEST["CampaignID"];
$phpdate = date('Y-m-d H:i:s');
$sql ="INSERT INTO  `ta_save_tweets_settings` (`CampaignID` , `Frequency` , `Repeat` , `Random` ) VALUES ( '$CampaignID', '$freq_id', '$repeat', '$random')";
db_connect();
mysql_query($sql);
$lastid =  mysql_insert_id();
db_close();
echo '<div class=green>Saved</div>-'.$CampaignID.'-'.$lastid;
	
	