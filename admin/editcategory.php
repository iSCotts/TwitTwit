<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){

	$id = $_REQUEST["id"];
	

$sql = "SELECT * FROM ta_category WHERE id ='$id'";
$GetPAckageList = runQuery($sql);
 
// Update Package area 
if(isset($_REQUEST["Update"]) && $_REQUEST["Update"] == "Update"){

$categoryname = addslashes($_REQUEST["categoryname"]);
 

//check category name already exists
		$categorynamealreadyexits = "SELECT count(*) FROM ta_category WHERE CategoryName='$categoryname' and  id!='$id' ";
		$categorynamealreadyexitsresult  = runQuery($categorynamealreadyexits);
		
		if($categorynamealreadyexitsresult[0][0] == 0){
		
		
		 
			
			
			
$time = date("H:i:s");
$id = $_REQUEST["id"];
 

$DT = $dateforreport.' '.$time;

$sql = "UPDATE `ta_category` SET `CategoryName` = '$categoryname' WHERE `id` ='$id'";


if(executeQuery($sql) == 1){
header("Location:managecategory.php?act=2");
exit;
}
else{
$ErrorMessage = "Some problem while Updating ";
}

		}
		
		else
		{
	$ErrorMessage = "Category name already exists";
		}

}
// Update Package area 



?>

<td height="380" align="center" valign="top">


<script type="text/javascript">
    $(document).ready(function() {
      $("#addcategory").validate({
        rules: {
    	  categoryname: "required",// simple rule, converted to {required:true}
          
          email: {// compound rule
          required: true,
          email: true
        },
        },
        
      });
    });
  </script>
<!--   -->
<form name="addcategory"  id="addcategory" action="editcategory.php" method="post">
<table cellpadding="2" cellspacing="2" border="0">



<tr>
<td colspan="2" align="center">Edit  Category</td>
 
</tr>


<input type="hidden" name="id" id="id"  value="<?php print $GetPAckageList[0]["id"] ?>">

<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
 
</tr>



<tr>
<td>Category Name</td>
<td><input type="text" name="categoryname" id="categoryname" value="<?php print $GetPAckageList[0]["CategoryName"] ?>"></td>
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