<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
if(isset($_REQUEST["Add"]) && $_REQUEST["Add"] == "Add"){
$username = addslashes($_REQUEST["username"]);
$password = addslashes($_REQUEST["password"]);
$status = addslashes($_REQUEST["status"]);
// Checking Username Already Exits 
$sql = "SELECT count(*) FROM  ta_admin_users WHERE  username ='$username'";
 $usernamecount = runQuery($sql);
// Checking Username Already Exits 
if($usernamecount[0][0] == 0){

$sql = "INSERT INTO  `ta_admin_users` (`username` ,`password` ,`status` ,`type`)VALUES ('$username', '$password', '$status', '')";

if(executeQuery($sql) == 1){
header("Location:manage_adminusers.php?act=1");
}
else{
$ErrorMessage = "Some problem while Inserting ";
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
      $("#addadminuser").validate({
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
<form name="addadminuser" id="addadminuser"  action="add_adminusers.php" method="post">
<table cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" align="center">Add Admin User</td>
 </tr>
<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
 </tr>
<tr>
<td>Username</td>
<td><input type="text" name="username" id="username"></td>
</tr>
<tr>
<td valign="top">Password</td>
<td><input type="password" name="password" id="password"  ></td>
</tr>
 <tr>
<td>Status</td>
<td> 
<select name="status" id="status">
<option value="Active" >Active</option>
<option value="DeActive" >DeActive</option>
 </select>
</td>
</tr>
 <tr>
 <td colspan="2"   align="center"><input type="submit" name="Add" id="Add" value="Add"></td>
</tr>
</table>
</form>
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
 }
  ?>