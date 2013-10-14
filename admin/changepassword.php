<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){


// Insert Package area 
if(isset($_REQUEST["Update"]) && $_REQUEST["Update"] == "Update"){

$oldpassword = addslashes($_REQUEST["oldpassword"]);
$newpassword = addslashes($_REQUEST["newpassword"]);
 
 
//$dateforreport =   date("Y-m-d");
//$time = date("H:i:s");

//$DT = $dateforreport.' '.$time;

// Checking oldpassword Already Exits 
$sql = "SELECT count(*) FROM  ta_admin_users WHERE  password ='$oldpassword'";
 $usernamecount = runQuery($sql);
// print_r($usernamecount);
 //print $usernamecount[0][0];
//exit;

// Checking Username Already Exits 

if($usernamecount[0][0] >0){

$sql = "UPDATE  `ta_admin_users` SET `password` = '$newpassword' WHERE  `username` ='$_SESSION[uname]'";

if(executeQuery($sql) == 1){
header("Location:index.php?act=4");
}
else{
$ErrorMessage = "Some problem while updating New Password ";
}
}
else
{
$ErrorMessage = "Old Password Not Matches, try Again ";
}



}
// Insert Package area 




?>

<td height="380" align="center" valign="top">


<script type="text/javascript">
    $(document).ready(function() {
      $("#changepassword").validate({
        rules: {
    	  oldpassword: "required",// simple rule, converted to {required:true}
          newpassword:"required",// simple rule, converted to {required:true}
          email: {// compound rule
          required: true,
          email: true
        },
        },
        
      });
    });
  </script>

<!--   -->
<form name="changepassword"  id="changepassword" action="changepassword.php" method="post">
<table cellpadding="2" cellspacing="2" border="0">



<tr>
<td colspan="2" align="center">Change Password</td>
 
</tr>




<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
 
</tr>



<tr>
<td>Old Password</td>
<td><input type="text" name="oldpassword" id="oldpassword"></td>
</tr>


<tr>
<td valign="top">New Password</td>
<td><input type="password" name="newpassword" id="newpassword"  ></td>
</tr>


 


 
 
  


 
 <tr>
 
<td colspan="2"   align="center"><input type="submit" name="Update" id="Update" value="Update"></td>
</tr>



</table>
</form>
<!--   -->



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
		exit;
 }
 
 ?>