<?php
include "../includes/header.php";
if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){

  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
 $Message = "Your Details Already there";}
 
  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==1)){
 $Message = "Your UserName /Password InCorrect";}

  
  // Get User Details By userid 
  if(isset($_REQUEST["uid"]) && ($_REQUEST["uid"] !="")){
  
  $sql = "SELECT * FROM ta_users WHERE  	UserID ='$_REQUEST[uid]'";
  $GetAdminUserlist = runQuery($sql);
  
  }
  // Get User Details By userid 
  
  
  


?>
 

<tr>
 
<td colspan="2">

<table cellpadding="2" cellpadding="2">
<form id="basiclogin" name="basiclogin"  method="post" action="edit_action" onSubmit="return Accountvalidation();">


<tr><td colspan="2" align="center"> <?php print $Message ?></td></tr>


<tr><td colspan="2" align="center">Edit Account</td></tr>

 <!-- <tr><td>Username</td><td><input type="text" name="username1" value="<?php print $GetAdminUserlist[0]["UserName"] ?>"></td></tr> -->
 <tr><td>Username</td><td bgcolor="gray"> <?php print $GetAdminUserlist[0]["UserName"] ?></td></tr>
 <tr><td>Password</td><td><input type="password" name="password1" value="<?php print $GetAdminUserlist[0]["Password"] ?>"></td></tr>
 
  <input type="hidden" name="username1" id="username1" value="<?php print $GetAdminUserlist[0]["UserName"] ?>">
 
 <input type="hidden" name="uidnew" id="uidnew" value="<?php print $GetAdminUserlist[0]["UserID"] ?>">
 <input type="hidden" name="RefID" id="RefID" value="<?php print $GetAdminUserlist[0]["RefID"] ?>">
 
 
 <tr><td colspan="2" align="center"><input type="submit" name="Update" value="Update"></td></tr>
 
 </form>
</table>

</td>

</tr>


 
<?php
include "../includes/footer.php";
}
else
{
	
	Header("Location:../index.php");
	
	
}
?>