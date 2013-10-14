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
if(isset($_REQUEST["PackageID"]) && ($_REQUEST["PackageID"]!= ""))
{
$sql = "DELETE   FROM ta_packages WHERE PackageID ='$_REQUEST[PackageID]'";
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


<!-- -->
<table  align="center" cellpadding="2" cellspacing="2" border="0">

<tr><td colspan="9" align="right"><a href="add_package.php">Add Package</a></td></tr>

<tr><td colspan="9" align="center"><?php print $ErrorMessage ?></td></tr>



<tr>
<td>SL.No</td>
<td>PackageName</td>
<td>PackageDesc</td>
<td>Price</td>
<td>Limit</td>
<td>TrialDays</td>
<td>View</td>
<td>Edit</td>
<td>Delete</td>

</tr>

<?php

$sql = "SELECT * FROM ta_packages ";
$GetPAckageList = runQuery($sql);
$i=1;
for($k=0;$k<count($GetPAckageList);$k++){
 
?>
<tr>
<td><?php print $i ?></td>
<td><?php print $GetPAckageList[$k]["PackageName"] ?></td>
<td><?php print $GetPAckageList[$k]["PackageDesc"] ?></td>
<td><?php print $GetPAckageList[$k]["Price"] ?></td>
<td><?php print $GetPAckageList[$k]["Limit"] ?></td>
<td><?php print $GetPAckageList[$k]["TrialDays"] ?></td>
 
<td><a href="javascript: jQuery.facebox({ajax:'viewpackages.php?PackageID=<?php print $GetPAckageList[$k]["PackageID"] ?>'});"><img src="images/view.gif" border="0" height="15"></a></td>

<!--<td><img src="images/view.gif" border="0" height="15"></td>-->
<td><a href="editpackages.php?PackageID=<?php print $GetPAckageList[$k]["PackageID"] ?>"><img src="images/update.png" border="0" height="15"></a></td>
<td><a href="?PackageID=<?php print $GetPAckageList[$k]["PackageID"] ?>"><img src="images/delete.gif" border="0" height="15"></a></td>
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
?>
 
 
 <?php
 }
 else
 {
 header("Location:index.php?act=3");
		exit;
 }
 
 ?>