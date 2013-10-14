<?php
ob_start();
session_start();
 
 $refuser123 = $_SESSION["username"];
 

if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){

include "../includes/header.php";
 //-------------------
	    $sqlsubs = "SELECT *  FROM ta_users WHERE UserName ='$refuser123'";
	  
	  $GetSubscriberscount = runQuery($sqlsubs);
	  	  $refuser = $GetSubscriberscount[0]["RefID"];
		  
	 //-------------------
	   
// Delete user 
//if(isset($_REQUEST["uid"]) && ($_REQUEST["uid"] !="")){
if(isset($_REQUEST["delete"]) && ($_REQUEST["delete"] =="delete")){

$sql = "DELETE  FROM ta_users WHERE UserID='$_REQUEST[uid]'"; 
$GetAdminUserlist = runQuery($sql);
if($GetAdminUserlist  ==1){
$Message = "Problem while deleting ";}
else{
$Message = "User Deleted Succuessfully";}
}
// Delete user 
 
 if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==1)){
 $Message = "Your UserName /Password InCorrect";}
 
 if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==2)){
 $Message = "Your Details Added Succuessfully";}
 
  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
 $Message = "Your Details Already there";}
   if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==5)){
 $Message = "Your Details Updated Succuessfully";}
  
?>
 

<tr>
 
<td colspan="2">

<table cellpadding="2" cellpadding="2">


<tr><td colspan="2" align="right"><?php print $Message ?></td></tr>


<tr><td colspan="2" align="right"><a href="add_account">Add Account</a></td></tr>

<tr><td>Sl No</td>
<td>Username</td>
<td>password</td>
<td>Edit</td>
<td>Delete</td>
<td>C</td>
</tr>


<?php

  //  $sql = "SELECT * FROM ta_users WHERE RefID ='$refuser' AND UserName!='$refuser123' ";
  
   $sql = "SELECT * FROM ta_users WHERE RefID ='$refuser' ";
 
$GetAdminUserlist = runQuery($sql);
$i=1;
for($k=0;$k<count($GetAdminUserlist);$k++){
 
?>

<tr><td><?php print $i ?></td>
<td><?php print $GetAdminUserlist[$k]["UserName"] ?></td>
<td><?php print $GetAdminUserlist[$k]["Password"] ?></td>

 <form action="edit_account" method="post" name="edit">
<input type="hidden" name="uid" value="<?php print $GetAdminUserlist[$k]["UserID"] ?>">

<td> <input type="submit" name="edit" value="edit">
  </td>


<!--<td><?php if($GetAdminUserlist[$k]["UserName"] == $refuser123) { }else{ ?>
<a href="edit_account.php?uid=<?php print $GetAdminUserlist[$k]["UserID"] ?>">Edit</a><? }?></td>-->
</form>




<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" name="delete">
<input type="hidden" name="uid" value="<?php print $GetAdminUserlist[$k]["UserID"] ?>">
<td><?php if($GetAdminUserlist[$k]["UserName"] == $refuser123) { }else{ ?>  <input type="submit" name="delete" value="delete"><? }?></td>
</form>
<!--<td><?php if($GetAdminUserlist[$k]["UserName"] == $refuser123) { }else{ ?> <a href="?uid=<?php print $GetAdminUserlist[$k]["UserID"] ?>">Delete</a><? }?></td>-->



<td><?php print $fc =  GetFollowersCount($GetAdminUserlist[$k]["UserName"]); ?></td>
</tr>
<?php
$i++;
 }
 
?>

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
