<?php
ini_set("max_execution_time","20000000000000000000000");
ini_set("max_input_time","2500000");
ini_set("memory_limit","25000000M");
include "../shuffle.php";
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';

// get current date 

$gettodaydate  = date('Y-m-d');

//get all campaigns data 

$getallcampaignsdata ="SELECT * FROM ta_campaigns";
$getallcampaignsdataresult = runQuery($getallcampaignsdata);

for($m=0;$m<count($getallcampaignsdataresult);$m++){
	
	//get start date and end date 
	$CampaignID = $getallcampaignsdataresult[$m]["CampaignID"];
	
	if($getallcampaignsdataresult[$m]["StartDT"] == $gettodaydate){
		//update campaign table with status Active
		//$updatecampaignwithstatus ="UPDATE  `ta_campaigns` SET `Status` = 'Active' WHERE `CampaignID` ='$CampaignID'";
		$updatecampaignwithstatus ="UPDATE  `ta_campaigns` SET `Status` = 'A' WHERE `CampaignID` ='$CampaignID'";
		$updatecampaignwithstatusresult = runQuery($updatecampaignwithstatus);
		
	}
	if(($getallcampaignsdataresult[$m]["EndDT"] =="0000-00-00")&&($getallcampaignsdataresult[$m]["StartDT"]<=$gettodaydate))
	{
		
		//update campaign table with status DeActive
		//$updatecampaignwithstatus ="UPDATE  `ta_campaigns` SET `Status` = 'DeActive' WHERE `CampaignID` ='$CampaignID'";
		$updatecampaignwithstatus ="UPDATE  `ta_campaigns` SET `Status` = 'A' WHERE `CampaignID` ='$CampaignID'";
		$updatecampaignwithstatusresult = runQuery($updatecampaignwithstatus);
			
	}
  else if($getallcampaignsdataresult[$m]["EndDT"] <= $gettodaydate)
	{
		
		//update campaign table with status DeActive
		//$updatecampaignwithstatus ="UPDATE  `ta_campaigns` SET `Status` = 'DeActive' WHERE `CampaignID` ='$CampaignID'";
		$updatecampaignwithstatus ="UPDATE  `ta_campaigns` SET `Status` = 'D' WHERE `CampaignID` ='$CampaignID'";
		$updatecampaignwithstatusresult = runQuery($updatecampaignwithstatus);
			
	}
	
		
}
