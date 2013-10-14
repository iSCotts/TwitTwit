<?php
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
$mailID = $_REQUEST["mailID"];

$sql = "SELECT * FROM ta_sent_mails WHERE mid ='$mailID'";
$getmailList = runQuery($sql);


?>

<!--   -->
 
<table cellpadding="5" cellspacing="5" border="0"  width="100%">


 
<tr>
<td colspan="5" align="center"><strong>View Mail</strong></td>
 
</tr>


 

<tr>
<td>From</td>
<td><?php print $getmailList[0]["frommail"] ?></td>
</tr>


<tr>
<td valign="top">To</td>
<td><?php print $getmailList[0]["tomail"] ?></td>
</tr>


<tr>
<td>Subject</td>
<td><?php print $getmailList[0]["subject"] ?></td>
</tr>


<tr>
<td>Date</td>
<td><?php print date("d-m-Y",strtotime($getmailList[0]["sentdate"])) ?></td>
</tr>

<tr>
<td colspan="5"><?php print $getmailList[0]["content"] ?></td>
</tr>

</table>