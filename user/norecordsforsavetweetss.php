<?php
include_once '../common/dbconfig.php';
$CampaignID = $_REQUEST["CampaignID"];
$getrowsfromsavetweetmesages ="SELECT count(*)  FROM ta_save_tweets WHERE CampaignID='$CampaignID'";
db_connect();
$getrowsfromsavetweetmesagesquery = mysql_query($getrowsfromsavetweetmesages);
$getrowsfromsavetweetmesagesqueryresult   =  mysql_fetch_array($getrowsfromsavetweetmesagesquery);
if($getrowsfromsavetweetmesagesqueryresult[0][0]  >= 1)
{
	echo  "yes";
}
else
{
	echo  "no";
$deletesavetweetsrowusingcampaignid = "DELETE   FROM ta_save_tweets_settings WHERE CampaignID='$CampaignID'";
$deletesavetweetsrowusingcampaignidresult  = mysql_query($deletesavetweetsrowusingcampaignid);
}
db_close();