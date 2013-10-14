<?php
/*
 * Created on 02-Feb-2010
 * Author :	liju
 * File:	manualUnfollow.php
 *
 */

 $campaignID=4;
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');
session_start();
if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
{
/**
 * getusername
 */
 $campaign=getCampaignUser($campaignID);
$campaignUser=explode('-',$campaign[0]['UserID']);
$campaignUserCount=count($campaignUser);
$userNames=array();
//print_r($campaignUser);

for($i=1;$i<$campaignUserCount;$i++){
	$userFromDB[0]=$campaignUser[$i];
	$userFromDB1=getUserName($campaignUser[$i]);
	$userFromDB[1]=$userFromDB1[0]['UserName'];
	array_push($userNames,$userFromDB);
}
$userNamesCount=count($userNames);
?>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="search.js"></script>
<script type='text/javascript' src='../js/autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="autocomplete.css" />
<script type='text/javascript' src='searchFollow.js'></script>

Select User
<select id="name" name="name" onchange="initializeTextbox();">
<?php
	print "<option value=\"0\">Select User</option>";
	for($i=0;$i<$userNamesCount;$i++){
		print "<option value=\"{$userNames[$i][0]}\">{$userNames[$i][1]}</option>";
	}
?>
</select>
Unfollow User
<input type="text" name="course" id="course" /><br/>
<span style="color:red">Shows following users in this campaign</span>
<div id="usersListDiv"></div>
<input type="hidden"  name="campaign" id="campaign" value="<?php echo $campaignID?>" />
<br/>
<input type="button" class="button" name="Unfollow" value="Unfollow" onclick="unfollowUser();"/>
<?php }
else
{
	header("Location:../index.php");	
}
?>