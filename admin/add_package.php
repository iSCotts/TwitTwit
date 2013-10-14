<?php

ob_start();

session_start();

include  "../classes/dbClient.php";

include '../common/sqlFunctions.php';

include "includes/header.php";

include "includes/left.php";



if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){



	// Insert Package area

	if(isset($_REQUEST["Add"]) && $_REQUEST["Add"] == "Add"){



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

        $mstatus =$_REQUEST["mstatus"];

		$ystatus =$_REQUEST["ystatus"];
		$free_trial =$_REQUEST["free_trial"];

		$dateforreport =   date("Y-m-d");
		

		$time = date("H:i:s");

		$DT = $dateforreport.' '.$time;



		$sql = "INSERT INTO `ta_packages` (`packageName`,`packageDesc`,`campaignLimit`,`keywordLimit`,`rssFeeds`,`twitterAcc`,`autoTweet`,`followLimit`,`urlTrack`,`campStatistics`,`monPrice`,`yearPrice`,`monButtonID`,`yearButtonID`,`DT`,`mstatus`,`ystatus`,`free_trial`) VALUES ('$packageName','$packageDesc','$campaignLimit','$keywordLimit','$rssFeeds','$twitterAcc','$autoTweet','$followLimit','$urlTrack','$campStatistics','$monPrice','$yearPrice','$monButtonID','$yearButtonID','$DT','$mstatus','$ystatus','$free_trial')";

		

		if(executeQuery($sql) == 1){

			header("Location:managepackages.php?act=1");

			exit;

		}

		else{

			$ErrorMessage = "Failed adding the new package. Please try again.";

		}



	}

	// Insert Package area

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

<form name="addpackage" id="addpackage" action="add_package.php" method="post" onsubmit="return validate(this)">

<table cellpadding="2" cellspacing="5" border="0">

	<tr>

		<td colspan="2" align="center">Add Package</td>



	</tr>

	<tr>

		<td colspan="2" align="center"><?php print $ErrorMessage ?></td>

	</tr>

	<tr>

		<td class="label">Name of Package : </td>

		<td><input type="text" name="packageName" id="packageName" size="50" /></td>

	</tr>





	<tr>

		<td class="label" valign="top">Package Description : </td>

		<td><textarea name="packageDesc" id="packageDesc" style="height:50px;width:300px;"></textarea></td>

	</tr>
	<tr>

		<td class="label">Free Trail : </td>

		<td><input type="checkbox" name="free_trial" id="free_trial" value="Y" /></td>

	</tr>
	<tr>

		<td class="label">Campaigns : </td>

		<td><input type="text" name="campaignLimit" id="campaignLimit" size="8" /></td>

	</tr>

	<tr>

		<td class="label">Keywords : </td>

		<td><input type="text" name="keywordLimit" id="keywordLimit" size="8" /></td>

	</tr>

	<tr>

		<td class="label">RSS Feeds : </td>

		<td><input type="text" name="rssFeeds" id="rssFeeds" size="8" /></td>

	</tr>

	<tr>

		<td class="label">Twitter accounts : </td>

		<td><input type="text" name="twitterAcc" id="twitterAcc" size="8" /></td>

	</tr>

	<tr>

		<td class="label">Auto Tweet Features : </td>

		<td><input type="checkbox" name="autoTweet" id="autoTweet" value="1" /></td>

	</tr>

	<tr>

		<td class="label">Number of Follows per Keyword : </td>

		<td><input type="text" name="followLimit" id="followLimit" size="8" /></td>

	</tr>

	<tr>

		<td class="label">URL Tracking : </td>

		<td><input type="checkbox" name="urlTrack" id="urlTrack" value="1" /></td>

	</tr>

	<tr>

		<td class="label">Campaign Statistics : </td>

		<td><input type="checkbox" name="campStatistics" id="campStatistics" value="1" /></td>

	</tr>

	<tr>

		<td class="label">Monthly Price : </td>

		<td><input type="text" name="monPrice" id="monPrice" size="8" />

		<input type="checkbox" name="mstatus" id="mstatus" value="1" />

</td>

	</tr>

	<tr>

		<td class="label">Yearly Price : </td>

		<td><input type="text" name="yearPrice" id="yearPrice" size="8" />

		<input type="checkbox" name="ystatus" id="ystatus" value="1" /></td>

	</tr>

	<tr>

		<td class="label">PayPal Button ID for monthly price: </td>

		<td><input type="text" name="monButtonID" id="monButtonID" size="20" /></td>

	</tr>

	<tr>

		<td class="label">PayPal Button ID for yearly price: </td>

		<td><input type="text" name="yearButtonID" id="yearButtonID" size="20" /></td>

	</tr>



	<tr>

		<td colspan="2" align="center"><input type="submit" name="Add" id="Add" value="Add" /></td>

	</tr>

</table>

</form>

<!--   --></td>

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