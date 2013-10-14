<?php
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
$id = $_REQUEST["id"];

$sql = "SELECT * FROM ta_admin_users WHERE id ='$id'";
$getAdminuserdetails = runQuery($sql);


?>

<!--   -->
 
<table cellpadding="2" cellspacing="2" border="0">


 
<tr>
<td colspan="2" align="center">View AdminUser </td>
 
</tr>


 

<tr>
<td>Username</td>
<td><?php print $getAdminuserdetails[0]["username"] ?></td>
</tr>


<tr>
<td valign="top">Password</td>
<td><?php print $getAdminuserdetails[0]["password"] ?></td>
</tr>


<tr>
<td>Status</td>
<td><?php print $getAdminuserdetails[0]["status"] ?></td>
</tr>


 
 


</table>
 
<!--   -->


