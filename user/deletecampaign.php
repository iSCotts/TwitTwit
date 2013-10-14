<?php
include_once '../common/dbconfig.php';
$cid = $_REQUEST["d"];
// delete tables related campaign 
db_connect();
$deletecampaignquery = "DELETE FROM ta_campaigns WHERE CampaignID='$cid'";
mysql_query($deletecampaignquery);
$deletefeedsquery = "DELETE FROM ta_feeds WHERE CampaignID='$cid'";
mysql_query($deletefeedsquery);
$deletefeedsresultsquery = "DELETE FROM  ta_feed_results WHERE CampaignID='$cid'";
mysql_query($deletefeedsresultsquery);
$deletekeywordUserssquery = "DELETE FROM  ta_keyword_users WHERE CampaignID='$cid'";
mysql_query($deletekeywordUserssquery);
$deleteSavetweetssquery = "DELETE FROM  ta_save_tweets WHERE CampaignID='$cid'";
mysql_query($deleteSavetweetssquery);
$deleteSavetweetsSettingsquery = "DELETE FROM  ta_save_tweets_settings WHERE CampaignID='$cid'";
mysql_query($deleteSavetweetsSettingsquery);
$deleteuturetweetmessagesquery = "DELETE FROM  ta_future_tweet_messages WHERE CampaignId='$cid'";
mysql_query($deleteuturetweetmessagesquery);
$deleteCategorytweetmessagesSettingsquery = "DELETE FROM  ta_category_tweet_messages_settings WHERE CampaignId='$cid'";
mysql_query($deleteCategorytweetmessagesSettingsquery);
db_close();