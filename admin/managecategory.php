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
$ErrorMessage = "Category Inserted Successfully";
 if($GetErrorCode == 2)
$ErrorMessage = "Category Updated Successfully";
// delete area 
if(isset($_REQUEST["id"]) && ($_REQUEST["id"]!= ""))
{
	$sql = "DELETE   FROM ta_category WHERE id ='$_REQUEST[id]'";
	if(executeQuery($sql) == 1){
		$ErrorMessage = "Deleted Successfully";
		$deletecategorytweets = "DELETE   FROM ta_category_tweet_messages WHERE categoryid ='$_REQUEST[id]'";
		executeQuery($deletecategorytweets);
		$deletecategorytweetsstatus = "DELETE   FROM ta_category_tweet_messages_status WHERE CategoryId ='$_REQUEST[id]'";
		executeQuery($deletecategorytweetsstatus);
	}
	else{
		$ErrorMessage = "Some problem while Deleting ";
	}
}
// delete area ends
?>
<td height="380" align="center" valign="top">
<table  align="center" cellpadding="2" cellspacing="2"  width="100%" border="1">
<tr><td colspan="5" align="right"><a href="add_category.php">Add Category Name</a></td></tr>
<tr><td colspan="5" align="center"><?php print $ErrorMessage ?></td></tr>
<tr>
<td><strong>SL.No</strong></td>
<td><strong>Category Name</strong></td>
<td><strong>Messages</strong></td>
<td><strong>Edit</strong></td>
<td><strong>Delete</strong></td>
</tr>
<?php
$sql = "SELECT * FROM ta_category ";
$GetPAckageList = runQuery($sql);
$i=1;
for($k=0;$k<count($GetPAckageList);$k++){
?>
<tr>
<td><?php print $i ?></td>
<td><?php print $GetPAckageList[$k]["CategoryName"] ?></td>
<td><a href="managemessages.php?id=<?php print $GetPAckageList[$k]["id"] ?>">Messages</td>
<td><a href="editcategory.php?id=<?php print $GetPAckageList[$k]["id"] ?>"><img src="images/update.png" border="0" height="15"></a></td>
<td><a href="?id=<?php print $GetPAckageList[$k]["id"] ?>"><img src="images/delete.gif" border="0" height="15"></a></td>
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