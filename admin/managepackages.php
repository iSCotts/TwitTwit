<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){



$GetErrorCode = $_REQUEST["act"];
 if($GetErrorCode == 1)
 $ErrorMessage = "Package Inserted Successfully";
  if($GetErrorCode == 2)
 $ErrorMessage = "Package Updated Successfully";
 
 
 
// delete area 
if(isset($_REQUEST["packageID"]) && ($_REQUEST["packageID"]!= ""))
{
$sql = "DELETE   FROM ta_packages WHERE packageID ='$_REQUEST[packageID]'";
if(executeQuery($sql) == 1){
$ErrorMessage = "Deleted Successfully";
}
else{
$ErrorMessage = "Some problem while Deleting ";
}
}


// delete area 

?>

<td height="380" align="center" valign="top">
<table  align="center" cellpadding="2" cellspacing="2"  width="100%" border="1">
<tr><td colspan="8" align="right"><a href="add_package.php">Add Package</a></td></tr>
<tr><td colspan="8" align="center"><?php print $ErrorMessage ?></td></tr>
<tr>
<td width="100" ><strong>Package Name</strong></td>
<td width="100" ><strong>Campaigns</strong></td>
<td width="100" ><strong>Twitter Accounts</strong></td>
<td width="100" ><strong>Keywords</strong></td>
<td width="100" ><strong>Feeds</strong></td>
<td width="100" ><strong>View</strong></td>
<td width="100" ><strong>Edit</strong></td>
<td width="100" ><strong>Delete</strong></td>
</tr>
<?php
$sql = "SELECT * FROM ta_packages  order by packageID asc";
$getPackageList = runQuery($sql);
$i=1;
for($k=0;$k<count($getPackageList);$k++){
 ?>
<tr>
<td><?php print $getPackageList[$k]["packageName"] ?></td>
<td><?php print $getPackageList[$k]["packageDesc"] ?></td>
<td><?php print $getPackageList[$k]["twitterAcc"] ?></td>
<td><?php print $getPackageList[$k]["keywordLimit"] ?></td>
<td><?php print $getPackageList[$k]["rssFeeds"] ?></td>
 
<td><a href="viewpackages.php?packageID=<?php print $getPackageList[$k]["packageID"] ?>"><img src="images/view.gif" border="0" height="15"></a></td>
<td>
<?php
if($getPackageList[$k]["packageID"]!=0)
{
?>
<a href="editpackages.php?packageID=<?php print $getPackageList[$k]["packageID"] ?>"><img src="images/update.png" border="0" height="15"></a>
<?php
}
?>
</td>
<td>
<?php
if($getPackageList[$k]["packageID"]!=0)
{
?>
<a href="?packageID=<?php print $getPackageList[$k]["packageID"] ?>"><img src="images/delete.gif" border="0" height="15"></a></td>
<?php
}
?>
</tr>
<?php
$i++;
 }
 ?>
</table>
</td>
</tr>
<?php
include "includes/footer.php";
 }
 else
 {
 header("Location:index.php?act=3");
 }
  ?>