<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$id = $_REQUEST["id"];
$sql = "SELECT * FROM ta_common_settings WHERE cs_id='$id'";
$GetsettingsList = runQuery($sql);
if(isset($_REQUEST["Update"]) && $_REQUEST["Update"] == "Update"){
$disp_name = addslashes($_REQUEST["setting_name"]);
$setting_value = addslashes($_REQUEST["setting_value"]);
$query = "SELECT count(*) FROM ta_common_settings WHERE disp_name='$disp_name' and cs_id!='$id'";
$result  = runQuery($query);
if($result[0][0] == 0){
$id = $_REQUEST["id"];
$sql = "UPDATE `ta_common_settings` SET `disp_name` = '$disp_name',`value` = '$setting_value' WHERE `cs_id` ='$id'";
if(executeQuery($sql) == 1){
header("Location:managesettings.php?act=2");
}
else{
$ErrorMessage = "Some problem while updating ";
}
	}
		else
		{
	$ErrorMessage = "settings name already exists";
		}
}
?>
<td height="380" align="center" valign="top">
<script type="text/javascript">
    $(document).ready(function() {
      $("#addsetting").validate({
        rules: {
		  setting_name: "required",
    	  setting_value: "required",// simple rule, converted to {required:true}
          
          email: {// compound rule
          required: true,
          email: true
        },
        },
        
      });
    });
  </script>
<form name="addsetting"  id="addsetting" action="editsettings.php" method="post">
<table width="312" border="0" cellpadding="2" cellspacing="2">
<tr>
<td colspan="2" align="center">Edit Settings</td>
</tr>
<input type="hidden" name="id" id="id"  value="<?php echo $GetsettingsList[0]["cs_id"] ?>">
<tr>
<td colspan="2" align="center"><?php echo $ErrorMessage ?></td>
</tr>
<tr>
<td>Name</td>
<td><input type="text" name="setting_name" id="setting_name" value="<?php echo $GetsettingsList[0]["disp_name"] ?>"></td>
</tr>
<tr>
<td>Value</td>
<td><input type="text" name="setting_value" id="setting_value" value="<?php echo $GetsettingsList[0]["value"] ?>"></td>
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
?>
 <?php
 }
 else
 {
 header("Location:index.php?act=3");
 }
 ?>