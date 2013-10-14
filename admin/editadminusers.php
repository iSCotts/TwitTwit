<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$id = $_REQUEST["id"];
$sql = "SELECT * FROM ta_admin_users WHERE id ='$id'";
$getadminuserdetails = runQuery($sql);
 // Update Package area 
if(isset($_REQUEST["Update"]) && $_REQUEST["Update"] == "Update"){
$username = addslashes($_REQUEST["username"]);
$password = addslashes($_REQUEST["password"]);
$status = addslashes($_REQUEST["status"]);
 // Checking Username Already Exits 
$sql = "SELECT count(*) FROM  ta_admin_users WHERE  username ='$username' and `id`!='$id' ";
$usernamecount = runQuery($sql);
// Checking Username Already Exits 
//$DT = $dateforreport.' '.$time;
if($usernamecount[0][0] == 0){
$sql = "UPDATE `ta_admin_users` SET `username` = '$username',`password` = '$password',`status` = '$status' WHERE `id` ='$id'";
if(executeQuery($sql) == 1){
header("Location:manage_adminusers.php?act=2");
}
else{
$ErrorMessage = "Some problem while Updating ";
}
}
else
{
$ErrorMessage = "Username Already Exists";
}
}
?>
<td height="380" align="center" valign="top">

<script type="text/javascript">
    $(document).ready(function() {
      $("#editadminuser").validate({
        rules: {
    	  username: "required",// simple rule, converted to {required:true}
          password:"required",// simple rule, converted to {required:true}
		  status:"required",// simple rule, converted to {required:true}
          email: {// compound rule
          required: true,
          email: true
        },
        },
        
      });
    });
  </script>
<form name="editadminuser"  id="editadminuser" action="editadminusers.php" method="post">
<table cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" align="center">Edit  Admin User</td>
 </tr>
<input type="hidden" name="id" id="id"  value="<?php print $getadminuserdetails[0]["id"] ?>">
<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
 </tr>
<tr>
<td>Username</td>
<td><input type="text" name="username" id="username" value="<?php print $getadminuserdetails[0]["username"] ?>"></td>
</tr>
<tr>
<td valign="top">Password</td>
<td><input type="password" name="password" id="password"  value="<?php print $getadminuserdetails[0]["password"] ?>"> </td>
</tr>
<tr>
<td>Status</td>
<td> 
<select name="status" id="status">
<option value="Active"  <?php if($getadminuserdetails[0]["status"] == 'Active') print "Selected"; ?>>Active</option>
<option value="DeActive"  <?php if($getadminuserdetails[0]["status"] == 'DeActive') print "Selected"; ?>>DeActive</option>
 </select>
</td>
</tr>
 <tr>
 <td colspan="2"   align="center"><input type="submit" name="Update" id="Update" value="Update"></td>
</tr>
</table>
</form>
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