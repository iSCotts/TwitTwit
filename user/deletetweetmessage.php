<?php
session_start();
include_once '../common/dbconfig.php';
$CampaignID = $_REQUEST["CampaignID"];
$rowid = $_REQUEST["rowid"];
$phpdate = date('Y-m-d H:i:s');
$query ="DELETE   FROM ta_save_tweets WHERE CampaignID='$CampaignID' && id='$rowid'";
db_connect();
mysql_query($query);
db_close();
