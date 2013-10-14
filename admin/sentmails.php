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
 $ErrorMessage = "Mail sent successfully";
// delete area 
if(isset($_REQUEST["mailID"]) && ($_REQUEST["mailID"]!= ""))
{
$sql = "DELETE   FROM ta_sent_mails WHERE mid ='$_REQUEST[mailID]'";
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
<tr><td colspan="8" align="right"><a href="add_singlemail.php">Send Mail</a></td></tr>
<tr><td colspan="8" align="center"><?php print $ErrorMessage ?></td></tr>
<?php

$sql = "SELECT * FROM ta_sent_mails ";
$getmailList = runQuery($sql);
$i=1;
if(count($getmailList)>0)
{
	?>
<tr>
<td width="125" ><strong>From</strong></td>
<td width="125" ><strong>To</strong></td>
<td width="125" ><strong>Subject</strong></td>
<td width="125" ><strong>Date</strong></td>
<td width="100" ><strong>View</strong></td>
<td width="100" ><strong>Delete</strong></td>

</tr>
<?php 
for($k=0;$k<count($getmailList);$k++){
 
?>
<tr>
<td><?php print $getmailList[$k]["frommail"] ?></td>
<td><?php print $getmailList[$k]["tomail"] ?></td>
<td><?php print $getmailList[$k]["subject"] ?></td>
<td><?php print date("d-m-Y",strtotime($getmailList[$k]["sentdate"])) ?></td>

<td><a href="javascript: jQuery.facebox({ajax:'viewmails.php?mailID=<?php print $getmailList[$k]["mid"] ?>'});"><img src="images/view.gif" border="0" height="15"></a></td>
<td><a href="?mailID=<?php print $getmailList[$k]["mid"] ?>"><img src="images/delete.gif" border="0" height="15"></a></td>
</tr>
<?php
$i++;
 }
}
else{
	?>
<tr><td colspan="5">No data exists</td></tr>	
	
	<?php 
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