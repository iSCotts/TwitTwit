<?php
include_once '../common/dbconfig.php';
$CampaignID = $_REQUEST["CampaignID"];
$feedrowid = $_REQUEST["feedrowid"];
$getRssDetails = "SELECT * FROM ta_feeds WHERE CampaignID='$CampaignID' && id 	='$feedrowid'";
db_connect();
$getRssDetailsResults  = mysql_query($getRssDetails);
db_close();	  
$getRssDetailsResults  = mysql_fetch_array($getRssDetailsResults);
$feedname = $getRssDetailsResults["feedname"];
$feedurl = $getRssDetailsResults["feedurl"];
$posturl = $getRssDetailsResults["posturl"];
$shorturl = $getRssDetailsResults["shorturl"];
$sortid = $getRssDetailsResults["sortid"];
$freq_id = $getRssDetailsResults["freq_id"];
$showdesc = $getRssDetailsResults["showdesc"];
print $result = $feedname."!".$feedurl."!".$posturl."!".$shorturl."!".$freq_id."!".$showdesc."!".$sortid."!".$feedrowid;
