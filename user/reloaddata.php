<?php
ob_start();
session_start();
 
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';
 
 if (isset ($_REQUEST['CamID']))
  {
  	    $campaignID=$_REQUEST['CamID'];
		$_SESSION["SCampaignId"]  = $_REQUEST["CamID"];
		$campainDetails = getCampaignUser($_REQUEST['CamID']);
		$campaignRefid=$campainDetails[0]['RefID'];
		$GetUsersbyrefid2 ="SELECT * FROM ta_users WHERE RefID='$campaignRefid'";
		$GetUsersbyrefidResult2  = runQuery($GetUsersbyrefid2);
		$uname=$GetUsersbyrefidResult2[0]['UserName'];
		$campaignUser = explode('-', $campainDetails[0]['UserID']);
		$campaignUserCount = count($campaignUser);
		$userNames = array ();
		for ($i = 0; $i < $campaignUserCount; $i++) {
			$userFromDB = getUserName($campaignUser[$i]);
			if($userFromDB[0]['UserName']!="")
			{
			array_push($userNames, $userFromDB[0]['UserName']);
			}
		}
		$userNamesCount = count($userNames);
		echo "<div style=\"text-align:right; padding:0 60px 0 0;\">
		Select User <select  class=\"inner_option_medium01\" id=\"usersList1\" name=\"usersList1\" onchange=\"userlist('{$campaignID}','1',this.value);\">";
					for($i = 0; $i < $userNamesCount; $i++)
								 {
				echo "<option value=\"$userNames[$i]\">$userNames[$i]</option>";
								}
				echo "</select></div>
						<div id =\"usersListDiv1\"></div>";
	} 
	?>