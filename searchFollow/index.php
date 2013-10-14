<?php
/*
 * Created on 19-Jan-2010
 * Author :	liju
 * File:	index.php
 *
 */
session_start();
if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
{
include ('../classes/dbClient.php');
include ('../common/sqlFunctions.php');

?>
<script
	src="../js/jquery.js" type="text/javascript"></script>
<script
	src="../js/jquery.pagnation.js" type="text/javascript"></script>
<script
	src="search.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<style>
	.qp_counter {
	        margin:  10px;
	}
	pre {
	        margin: 20px 0 10px 0;
	        background: #ccc !important;
	        padding: 10px;
	}
	a.qp_disabled {
	        color: #888;
	}
</style>
<?php
$campaign=getCampaignUser($_REQUEST['CampaignID']);
$campaignUser=explode('-',$campaign[0]['UserID']);
$campaignUserCount=count($campaignUser);
$userNames=array();
for($i=1;$i<$campaignUserCount;$i++){
	$userFromDB=getUserName($campaignUser[$i]);
	array_push($userNames,$userFromDB[0]['UserName']);
}
$userNamesCount=count($userNames);


?>

<select id="usersList" name="usersList" onchange="userlist('<?php echo $_REQUEST['CampaignID']?>');">
<?php
	print "<option value=\"0\">Select User</option>";
	for($i=0;$i<$userNamesCount;$i++){
		print "<option value=\"{$userNames[$i]}\">{$userNames[$i]}</option>";
	}
?>
</select>

<div id ="usersListDiv">

	</div>
<?php }
else
{
	header("Location:../index.php");	
}
?>
