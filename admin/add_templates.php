<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){

// Insert Package area 
if(isset($_REQUEST["Add"]) && $_REQUEST["Add"] == "Add"){

$templname = addslashes($_REQUEST["templname"]);
$templfile = addslashes($_FILES["templfile"]["name"]);
$status = addslashes($_REQUEST["status"]);
if($_FILES["templfile"]["type"]<>"text/plain")
{
$ErrorMessage = "Please upload a text file ";
}
else{
 if (file_exists("../mailtempl/" . $_FILES["templfile"]["name"]))
      {
      echo $_FILES["templfile"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["templfile"]["tmp_name"],
      "../mailtempl/" . $_FILES["templfile"]["name"]);
      echo "Type: " . $_FILES["templfile"]["type"] . "<br />";
      } 
//$dateforreport =   date("Y-m-d");
//$time = date("H:i:s");

//$DT = $dateforreport.' '.$time;

// Checking Username Already Exits 
$sql = "SELECT count(*) FROM  ta_email_template WHERE  t_name ='$templname'";
$templcount = runQuery($sql);
// print_r($usernamecount);
 //print $usernamecount[0][0];
//exit;

// Checking Username Already Exits 

if($templcount[0][0] == 0){

$sql = "INSERT INTO  `ta_email_template` (`t_name` ,`t_file` ,`status`)VALUES ('$templname', '$templfile', '$status')";

if(executeQuery($sql) == 1){
header("Location:manage_templates.php?act=1");
exit;
}
else{
$ErrorMessage = "Some problem while inserting ";
}
}
else
{
$ErrorMessage = "Template name already exists";
}

}
}
// Insert Package area 
?>

<td height="380" align="center" valign="top">

<script type="text/javascript">
    $(document).ready(function() {
      $("#addtemplates").validate({
        rules: {
    	  templname: "required",// simple rule, converted to {required:true}
    	  templfile:"required",// simple rule, converted to {required:true}
    	  status:"required",// simple rule, converted to {required:true}
           },
         });
    });
  </script>
<form name="addtemplates" id="addtemplates"  action="add_templates.php" method="post" enctype="multipart/form-data">
<table cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" align="center">Add Templates</td>
</tr>
<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
</tr>
<tr>
<td>Template Name</td>
<td><input type="text" name="templname" id="templname"></td>
</tr>
<tr>
<td valign="top">Template File</td>
<td><input type="file" name="templfile" id="templfile"  ></td>
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
		exit;
 }
 
 ?>