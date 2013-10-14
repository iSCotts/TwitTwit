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
 $ErrorMessage = "Template Inserted Successfully";
 if($GetErrorCode == 2)
 $ErrorMessage = "Template Updated Successfully";
 
// delete area 
/*if(isset($_REQUEST["id"]) && ($_REQUEST["id"]!= ""))
{
$sql = "DELETE   FROM ta_email_template WHERE t_id ='$_REQUEST[id]'";
$sqlfiledel = "SELECT * FROM ta_email_template ";
$GetTemplist1 = runQuery($sqlfiledel);
if (file_exists("../mailtempl/".$GetTemplist1[0]["t_file"]))
{
unlink("../mailtempl/".$GetTemplist1[0]["t_file"]);
}
if(executeQuery($sql) == 1){
$ErrorMessage = "Deleted Successfully";
}
else{
$ErrorMessage = "Some problem while Deleting ";
}
}*/

// delete area 
?>
<td height="380" align="center" valign="top">
<table  align="center" cellpadding="2" cellspacing="2"  width="100%" border="1">
<tr><td colspan="9" align="right"><a href="add_templates.php">Add Email Templates</a></td></tr>
<tr><td colspan="9" align="center"><?php print $ErrorMessage ?></td></tr>
<tr>
<td><strong>SL.No</strong></td>
<td><strong>Template</strong></td>
<td><strong>Status</strong></td>
<td><strong>View</strong></td>
<td><strong>Edit</strong></td>
<td><strong>Download</strong></td>
</tr>
<?php
$sql = "SELECT * FROM ta_email_template ";
$GetTemplist = runQuery($sql);
$i=1;
for($k=0;$k<count($GetTemplist);$k++){
?>
<tr>
<td><?php print $i ?></td>
<td><?php print $GetTemplist[$k]["t_name"] ?></td>
<td><?php print $GetTemplist[$k]["status"] ?></td>
<td><a href="javascript: jQuery.facebox({ajax:'viewtemplates.php?id=<?php print $GetTemplist[$k]["t_id"] ?>'});"><img src="images/view.gif" border="0" height="15"></a></td>
<td><a href="edit_templates.php?id=<?php print $GetTemplist[$k]["t_id"] ?>"><img src="images/update.png" border="0" height="15"></a></td>
<td><a href="download.php?filename=<?php echo $GetTemplist[$k]["t_file"] ?>"><?php echo $GetTemplist[$k]["t_file"] ?></a></td>
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