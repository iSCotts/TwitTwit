<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
?>
<td height="380" align="center" valign="top">
<table  align="center" cellpadding="2" cellspacing="2"  width="100%" border="1">
<tr><td colspan="5" align="center"><?php print $ErrorMessage ?></td></tr>
<tr>
<td><strong>SL.No</strong></td>
<td><strong>Settings</strong></td>
<td><strong>Value</strong></td>
<td><strong>Edit</strong></td>
</tr>
<?php
$sql = "SELECT * FROM ta_common_settings ";
$GetsettingsList = runQuery($sql);
$i=1;
for($k=0;$k<count($GetsettingsList);$k++){
?>
<tr>
<td><?php print $i ?></td>
<td><?php print $GetsettingsList[$k]["disp_name"] ?></td>
<td><?php print $GetsettingsList[$k]["value"] ?></td>
<td><a href="editsettings.php?id=<?php print $GetsettingsList[$k]["cs_id"] ?>"><img src="images/update.png" border="0" height="15"></a></td>
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