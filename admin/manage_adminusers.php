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
$ErrorMessage = "Admin User Inserted Successfully";
 if($GetErrorCode == 2)
$ErrorMessage = "Admin User Updated Successfully";
if(isset($_REQUEST["id"]) && ($_REQUEST["id"]!= ""))
{
$sql = "DELETE   FROM ta_admin_users WHERE id ='$_REQUEST[id]'";
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

<table  align="center" cellpadding="2" cellspacing="2" width="100%" border="1">

<tr><td colspan="9" align="right"><a href="add_adminusers.php">Add AdminUser</a></td></tr>

<tr><td colspan="9" align="center"><?php print $ErrorMessage ?></td></tr>
<tr>
<td><strong>SL.No</strong></td>
<td><strong>Username</strong></td>
<td><strong>Password</strong></td>
<td><strong>Status</strong></td>
<td><strong>Edit</strong></td>
<td><strong>Delete</strong></td>
</tr>
<?php
$sql = "SELECT * FROM ta_admin_users ";
$GetAdminUserlist = runQuery($sql);
$i=1;
for($k=0;$k<count($GetAdminUserlist);$k++){
?>
<tr>
<td><?php print $i ?></td>
<td><?php print $GetAdminUserlist[$k]["username"] ?></td>
<td><?php print $GetAdminUserlist[$k]["password"] ?></td>
<td><?php print $GetAdminUserlist[$k]["status"] ?></td>
<td><a href="editadminusers.php?id=<?php print $GetAdminUserlist[$k]["id"] ?>"><img src="images/update.png" border="0" height="15"></a></td>
<td><a href="?id=<?php print $GetAdminUserlist[$k]["id"] ?>"><img src="images/delete.gif" border="0" height="15"></a></td>
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