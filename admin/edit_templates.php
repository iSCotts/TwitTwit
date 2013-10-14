<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$id = $_REQUEST["id"];
$status = addslashes($_REQUEST["status"]);
$sql = "SELECT * FROM ta_email_template WHERE t_id='$id'";
$gettempdetails = runQuery($sql);
if(isset($_REQUEST["Update"]) && $_REQUEST["Update"] == "Update")
{
	$id = $_REQUEST["id"];
	$sql = "SELECT * FROM ta_email_template WHERE t_id='$id'";
	$gettempdetails = runQuery($sql);
	$templname = addslashes($_REQUEST["templname"]);
	if(($_FILES["templfile"]["name"])<>"")
	{
	echo $_FILES["templfile"]["name"];
			if($_FILES["templfile"]["type"]<>"text/plain")
			{
				$ErrorMessage = "Please upload a text file ";
			}
			else
			{
				if (file_exists("../mailtempl/".$gettempdetails[0]["t_file"]))
				{
				   unlink("../mailtempl/".$gettempdetails[0]["t_file"]);
				}
				$templfile = addslashes($_FILES["templfile"]["name"]);
				move_uploaded_file($_FILES["templfile"]["tmp_name"],"../mailtempl/" . $_FILES["templfile"]["name"]);
				echo "Type: " . $_FILES["templfile"]["type"] . "<br />";
				echo "file uploaded";
			}
	}
	$status = addslashes($_REQUEST["status"]);
	// Checking template Already Exits 
	$sql = "SELECT count(*) FROM  ta_email_template WHERE  t_name ='$templname'";
	$usertemplcount = runQuery($sql);
	if($usertemplcount[0][0] == 0 || $usertemplcount[0][0] == 1)
	{
		$sql = "UPDATE `ta_email_template` SET `t_name` = '$templname',`status` = '$status' WHERE `t_id` ='$id'";
		if($templfile<>"")
		{
			$sql2 = "UPDATE `ta_email_template` SET `t_file` = '$templfile' WHERE `t_id` ='$id'";
			executeQuery($sql2);	
		}
		if(executeQuery($sql) == 1)
		{
			header("Location:manage_templates.php?act=2");
		}
		else
		{
			$ErrorMessage = "Some problem while Updating ";
		}
	}
	else
	{
			$ErrorMessage = "Template name already exists";
	}

}

?>

<td height="380" align="center" valign="top">

<script type="text/javascript">
    $(document).ready(function() {
      $("#edittempl").validate({
        rules: {
    	  username: "required",// simple rule, converted to {required:true}
          password:"required",// simple rule, converted to {required:true}
		  status:"required",// simple rule, converted to {required:true}
           },
        
      });
    });
  </script>

<form name="edittempl"  id="edittempl" action="edit_templates.php" method="post"  enctype="multipart/form-data">
<table cellpadding="2" cellspacing="2" border="0">



<tr>
<td colspan="2" align="center">Edit  Templates</td>
 
</tr>


<input type="hidden" name="id" id="id"  value="<?php print $gettempdetails[0]["id"] ?>">

<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
 
</tr>



<tr>
<td>Template Name</td>
<td><input type="text" name="templname" id="templname" value="<?php print $gettempdetails[0]["t_name"] ?>"></td>
<input type="hidden" name="id" id="id"  value="<?php print $gettempdetails[0]["t_id"] ?>">
</tr>


<tr>
<td valign="top">Template File</td>
<td><input type="file" name="templfile" id="templfile"> </td>
</tr>


 
<tr>
<td>Status</td>
<td> 
<select name="status" id="status">
<option value="Active"  <?php if($gettempdetails[0]["status"] == 'Active') print "Selected"; ?>>Active</option>
<option value="DeActive"  <?php if($gettempdetails[0]["status"] == 'DeActive') print "Selected"; ?>>DeActive</option>
 

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
?>
 
 
 <?php
 }
 else
 {
 header("Location:index.php?act=3");
		exit;
 }
 
 ?>