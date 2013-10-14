<?php

ob_start();

session_start();

include  "../classes/dbClient.php";

include '../common/sqlFunctions.php';

include "includes/header.php";

include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){

$packageID = $_REQUEST["packageID"];

$sql = "SELECT * FROM ta_packages WHERE packageID ='$packageID'";

$getPackageList = runQuery($sql);

?>



<td height="380" align="center" valign="top">

<table width="32%" height="380" border="1" cellpadding="5" cellspacing="5">

<tr>

<td colspan="2" align="center">Package View</td>

 </tr>

<tr>

<td >Package Name</td>

<td width="47%"><?php print $getPackageList[0]["packageName"] ?></td>

</tr>

<tr>

<td valign="top">Package Desc</td>

<td><?php echo $getPackageList[0]["packageDesc"] ?></td>

</tr>

 <tr>

<td>Free Trail</td>

<td><?php if($getPackageList[0]["free_trial"]  == 'Y'){ ?><img src="images/tick.jpeg" border="0" height="15" /> <?php } ?></td>

</tr>

<tr>

<td>Campaign Limit</td>

<td><?php echo $getPackageList[0]["campaignLimit"] ?></td>

</tr>

<tr>

<td>Keyword Limit</td>

<td><?php echo $getPackageList[0]["keywordLimit"] ?></td>

</tr>

<tr>

<td>RSS Feeds</td>

<td><?php echo $getPackageList[0]["rssFeeds"] ?></td>

</tr>

<tr>

<td>Twitter Accounts</td>

<td><?php echo $getPackageList[0]["twitterAcc"] ?></td>

</tr>

 <tr>

<td>Auto Tweet</td>

<td><?php if($getPackageList[0]["autoTweet"]==1){ ?><img src="images/tick.jpeg" border="0" height="15" /> <?php } ?></td>

</tr>

<tr>

<td>Follow Limit</td>

<td><?php echo $getPackageList[0]["followLimit"] ?></td>

</tr>

<tr>

<td>URL Tracking</td>

<td><?php if($getPackageList[0]["urlTrack"]==1){ ?> <img src="images/tick.jpeg" border="0" height="15" /> <?php } ?></td>

</tr>

<tr>

<td>Campaign Statistics</td>

<td><?php if($getPackageList[0]["campStatistics"]==1){ ?> <img src="images/tick.jpeg" border="0" height="15" /> <?php } ?></td>

</tr>

<tr>

<td>Monthly Price</td>

<td><?php echo $getPackageList[0]["monPrice"] ?></td>

</tr>

<tr>

<td>Yearly Price</td>

<td><?php echo $getPackageList[0]["yearPrice"] ?></td>

</tr>

<tr>

<td>Monthly ButtonID</td>

<td><?php echo $getPackageList[0]["monButtonID"] ?></td>

</tr>

<tr>

<td >Yearly ButtonID</td>

<td><?php echo $getPackageList[0]["yearButtonID"] ?></td>

</tr>

</table>

</td>

<?php

include "includes/footer.php";

 }

 else

 {

 header("Location:index.php?act=3");

 }

  ?>