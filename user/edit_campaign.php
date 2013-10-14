<?php
include "../includes/header.php";
if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){


// 	Get REfID using username from users Table 
	$getrefidusingusername ="SELECT * FROM ta_users WHERE UserName='$_SESSION[username]'";
	$getrefidusingusernameresult  = runQuery($getrefidusingusername);
	$refid = $getrefidusingusernameresult[0]["RefID"];
	// 	Get REfID using username from users Table 
	
	
  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
 $Message = "Your Details Already there";}
 
  if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==1)){
 $Message = "Your UserName /Password InCorrect";}
 
 ?>
 

<tr>
 
<td colspan="2">

<table cellpadding="2" cellpadding="2">
<form id="editcampaign" name="editcampaign" method="post" action="editcampaign_action">

<tr><td colspan="2" align="center"><?php print $Message ?></td></tr>


<tr><td colspan="2" align="center">Edit Campaign</td></tr>
<?php 
$GetUsersbyrefid ="SELECT * FROM ta_users WHERE 	RefID='$refid'";
$GetUsersbyrefidResult  = runQuery($GetUsersbyrefid);
  

?>
  <tr>
  <td>Select Accounts :</td>
  <td><select name="accs"  id="accs" onchange="GetUserId(this.value);">
  <option value="0">Select</option>
  <?php 
  for($p=0;$p<count($GetUsersbyrefidResult);$p++)
  {
  	
 ?>
  <option value="<?php  print $GetUsersbyrefidResult[$p]["UserName"]."-".$p?>"><?php  print $GetUsersbyrefidResult[$p]["UserName"]?></option>
  <?php 
  }
  ?>
  </select></td>
  </tr>
  
   <?php 
  for($p=0;$p<count($GetUsersbyrefidResult);$p++)
  {
  	
 ?>
 
  <tr><td colspan="2" align="center"><div id="ShowselectedUsers<?php print $p;?>"></div></td></tr>
   <input type="hidden" value="0" id="theValue"  name="theValue"/>
   
   <?php 
  }
  ?>
  
 <tr><td colspan="2" align="left"><a href="managefeed">Manage Feed</a></td></tr>
 
 <tr><td colspan="2" align="center"><input type="submit" name="Add" value="UpdateCampaign" ></td></tr>
 
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