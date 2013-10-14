<?php

ob_start();

session_start();

include  "../classes/dbClient.php";

include '../common/sqlFunctions.php';

include "includes/header.php";

include "includes/left.php";
$packageID = $_REQUEST["packageID"];


if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){





$sql = "SELECT * FROM ta_packages WHERE packageID ='$packageID'";

$getPackageList = runQuery($sql);

 

// Update Package area 

if(isset($_REQUEST["Update"]) && $_REQUEST["Update"] == "Update"){




$packageName = addslashes($_REQUEST["packageName"]);

$packageDesc = addslashes($_REQUEST["packageDesc"]);

$campaignLimit = addslashes($_REQUEST["campaignLimit"]);

$keywordLimit = addslashes($_REQUEST["keywordLimit"]);

$rssFeeds = addslashes($_REQUEST["rssFeeds"]);

$twitterAcc = addslashes($_REQUEST["twitterAcc"]);

$autoTweet = addslashes($_REQUEST["autoTweet"]);

$followLimit = addslashes($_REQUEST["followLimit"]);

$urlTrack = addslashes($_REQUEST["urlTrack"]);

$campStatistics = addslashes($_REQUEST["campStatistics"]);

$monPrice = addslashes($_REQUEST["monPrice"]);

$yearPrice = addslashes($_REQUEST["yearPrice"]);

$monButtonID = addslashes($_REQUEST["monButtonID"]);

$yearButtonID = addslashes($_REQUEST["yearButtonID"]);

$mstatus = addslashes($_REQUEST["mstatus"]);

$ystatus = addslashes($_REQUEST["ystatus"]);
$free_trial =$_REQUEST["free_trial"];


$dateforreport =   date("Y-m-d");

$time = date("H:i:s");

$DT = $dateforreport.' '.$time;



//$sql = "UPDATE `ta_packages` SET `packageName` = '$packageName',`packageDesc` = '$packageDesc',`Price` = '$Price',`Limit` = '$Limit',`TrialDays` = '$TrialDays',`subscription` = '$subscription' WHERE `packageID` ='$packageID'";



$sql = "UPDATE `ta_packages` SET `packageName`='$packageName',`packageDesc`='$packageDesc',`campaignLimit`='$campaignLimit',`keywordLimit`='$keywordLimit',`rssFeeds`='$rssFeeds',`twitterAcc`='$twitterAcc',`autoTweet`='$autoTweet',`followLimit`='$followLimit',`urlTrack`='$urlTrack',`campStatistics`='$campStatistics',`monPrice`='$monPrice',`yearPrice`='$yearPrice',`monButtonID`='$monButtonID',`yearButtonID`='$yearButtonID',`DT`='$DT',`mstatus`='$mstatus',`ystatus`='$ystatus',`free_trial`='$free_trial'  WHERE `packageID` ='$packageID'";

echo $sql;

if(executeQuery($sql) == 1){

header("Location:managepackages.php?act=2");

exit;

}

else{

$ErrorMessage = "Some problem while Updating ";

}



}

// Update Package area 







?>



<td height="380" align="center" valign="top">



<script	type="text/javascript">

function validate(theform)

{

if(theform.packageName.value=="")

{

alert("package name required");

theform.packageName.focus();

return false;

}

if(theform.packageDesc.value=="")

{

alert("package description required");

theform.packageDesc.focus();

return false;

}

if(theform.campaignLimit.value=="")

{

alert("campaign Limit required");

theform.campaignLimit.focus();

return false;

}

}

 </script>



  <form name="editpackages" id="editpackages"  action="" method="post"  onsubmit="return validate(this)">

    <table cellpadding="2" cellspacing="5" border="0">

	<tr>

		<td colspan="2" align="center">Edit Package</td>

	</tr>

	<input type="hidden" name="packageID" id="packageID"  value="<?php print $getPackageList[0]["packageID"] ?>">

	<tr>

		<td colspan="2" align="center"><?php print $ErrorMessage ?></td>

	</tr>

	<tr>

		<td class="label">Name of Package : </td>

		<td><input type="text" name="packageName" id="packageName" size="50" value="<?php print $getPackageList[0]["packageName"] ?>" /></td>

	</tr>





	<tr>

		<td class="label" valign="top" >Package Description : </td>

		<td><textarea name="packageDesc" id="packageDesc" style="height:50px;width:300px;"><?php print $getPackageList[0]["packageDesc"] ?></textarea></td>

	</tr>

	<tr>

		<td class="label">Free Trail : </td>

		<td><input <?php if($getPackageList[0]["free_trial"]  == 'Y') { ?> checked="checked" <?php }?> type="checkbox" name="free_trial" id="free_trial" value="Y" /></td>

	</tr>

	<tr>

		<td class="label">Campaigns : </td>

		<td><input type="text" name="campaignLimit" id="campaignLimit" size="8" value="<?php print $getPackageList[0]["campaignLimit"] ?>" /></td>

	</tr>

	<tr>

		<td class="label">Keywords : </td>

		<td><input type="text" name="keywordLimit" id="keywordLimit" size="8" value="<?php print $getPackageList[0]["keywordLimit"] ?>" /></td>

	</tr>

	<tr>

		<td class="label">RSS Feeds : </td>

		<td><input type="text" name="rssFeeds" id="rssFeeds" size="8" value="<?php print $getPackageList[0]["rssFeeds"] ?>" /></td>

	</tr>

	<tr>

		<td class="label">Twitter accounts : </td>

		<td><input type="text" name="twitterAcc" id="twitterAcc" size="8" value="<?php print $getPackageList[0]["twitterAcc"] ?>" /></td>

	</tr>

	<tr>

		<td class="label">Auto Tweet Features : </td>

		<td><input type="checkbox" name="autoTweet" id="autoTweet"  value="1" <?php if($getPackageList[0]["autoTweet"]==1) print "checked=checked"; ?> /></td>

	</tr>

	<tr>

		<td class="label">Number of Follows per Keyword : </td>

		<td><input type="text" name="followLimit" id="followLimit" size="8" value="<?php print $getPackageList[0]["followLimit"] ?>" /></td>

	</tr>

	<tr>

		<td class="label">URL Tracking : </td>

		<td><input type="checkbox" name="urlTrack" id="urlTrack" value="1" <?php if($getPackageList[0]["urlTrack"]==1) print "checked=checked"; ?> /></td>

	</tr>

	<tr>

		<td class="label">Campaign Statistics : </td>

		<td><input type="checkbox" name="campStatistics" id="campStatistics" value="1" <?php if($getPackageList[0]["campStatistics"]==1) print "checked=checked"; ?> /></td>

	</tr>

	<tr>

		<td class="label">Monthly Price : </td>

		<td><input type="text" name="monPrice" id="monPrice" size="8" value="<?php print $getPackageList[0]["monPrice"] ?>" /><input type="checkbox" name="mstatus" id="mstatus" value="1" <?php if($getPackageList[0]["mstatus"]==1) echo "checked=checked"; ?> /></td>

	</tr>

	<tr>

		<td class="label">Yearly Price : </td>

		<td><input type="text" name="yearPrice" id="yearPrice" size="8" value="<?php print $getPackageList[0]["yearPrice"] ?>" /><input type="checkbox" name="ystatus" id="ystatus" value="1" <?php if($getPackageList[0]["ystatus"]==1) echo "checked=checked"; ?> /></td>

	</tr>

	<tr>

		<td class="label">PayPal Button ID for monthly price: </td>

		<td><input type="text" name="monButtonID" id="monButtonID" size="20" value="<?php print $getPackageList[0]["monButtonID"] ?>" /></td>

	</tr>

	<tr>

		<td class="label">PayPal Button ID for yearly price: </td>

		<td><input type="text" name="yearButtonID" id="yearButtonID" size="20" value="<?php print $getPackageList[0]["yearButtonID"] ?>" /></td>

	</tr>

	<tr>

		<td colspan="2" align="center"><input type="submit" name="Update" id="Update" value="Update" /></td>

	</tr>

</table>

</form>

</td>

</tr>

<?php

include "includes/footer.php";

?>

 <?php

 }

 else

 {

 header("Location:index.php?act=3");

		exit;

 }

 

 ?>