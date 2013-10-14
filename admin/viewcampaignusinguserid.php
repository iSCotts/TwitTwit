<?php
 include "configoriginal.php";
$ciduuu = $_REQUEST["id"];
$getallcampaigns ="SELECT * FROM  ta_campaigns";
$getallcampaignsquery = mysql_query($getallcampaigns);
while($getallcampaignsqueryresult = mysql_fetch_array($getallcampaignsquery)){
	  $cid = $getallcampaignsqueryresult[CampaignID];
	  $userid = $getallcampaignsqueryresult[UserID];
	  $campname = $getallcampaignsqueryresult[CampaignName];
 if($userid != ""){
		$splituserid = explode("-",$userid);
		 $k=0;
		for($p=0;$p<count($splituserid);$p++){
			if($splituserid[$p] != ""){
			$originalarray[$k] = $splituserid[$p];
			$k++;
			}
		}
		if(count($originalarray) >1){
		if(in_array($ciduuu,$originalarray)){
			
			//remove selected userid from table 
			$m = 0;
			for($h=0;$h<count($originalarray);$h++)
			{
				if($originalarray[$h] != $ciduuu)
				{
					$updatearray[$m] =$originalarray[$h];
					 $m++;
				}
			}
			//join userid'd 
			$juserids = join("-",$updatearray);
			//$updatecampaigntable = "UPDATE `ta_campaigns` SET `UserID` = '$juserids' WHERE  `CampaignID` ='$cid'";
			//mysql_query($updatecampaigntable);
			echo "<table cellspacing=2 cellpadding=2><tr><td>Campaign Name  </td><td>  : $campname</td></tr>";
				}
	
		}
	
		else
		{
		//if(in_array($cid,$originalarray)){
			if($ciduuu == $originalarray[0]){
			//remove selected userid from table 
			 //delete campaign row completely 
		//  $deletecampaignquery123 = "DELETE   FROM ta_campaigns WHERE    	CampaignID='$cid'";
		//mysql_query($deletecampaignquery123);
		
		}		
			
		}
	}

}
