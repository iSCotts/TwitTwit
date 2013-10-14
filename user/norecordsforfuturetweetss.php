<?php
include_once '../common/dbconfig.php';
$CampaignID = $_REQUEST["CampaignID"];
$getrowsfromsavetweetmesages ="SELECT count(*)  FROM ta_future_tweet_messages WHERE CampaignID='$CampaignID'";
db_connect();
$getrowsfromsavetweetmesagesquery = mysql_query($getrowsfromsavetweetmesages);
db_close();
$getrowsfromsavetweetmesagesqueryresult   =  mysql_fetch_array($getrowsfromsavetweetmesagesquery);
if($getrowsfromsavetweetmesagesqueryresult[0][0]  >= 1)
{
	echo  "yes";
}
else
{
	echo  "no";
}

