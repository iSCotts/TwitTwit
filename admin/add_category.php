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

		$categoryname = addslashes($_REQUEST["categoryname"]);

		//check category name already exists
		$categorynamealreadyexits = "SELECT count(*) FROM ta_category WHERE CategoryName='$categoryname'";
		$categorynamealreadyexitsresult  = runQuery($categorynamealreadyexits);
		
		if($categorynamealreadyexitsresult[0][0] == 0){
			
		
			
		
		
		$dateforreport =   date("Y-m-d");
		$time = date("H:i:s");

		$DT = $dateforreport.' '.$time;

		$sql = "
INSERT INTO `ta_category` (
 
`CategoryName`
)
VALUES (
  '$categoryname'
)";
		if(executeQuery($sql) == 1){
			header("Location:managecategory.php?act=1");
			exit;
		}
		else{
			$ErrorMessage = "Some problem while Inserting ";
		}

		
		}
		
		else
		{
			$ErrorMessage = "category name already exists";
		}
	}
	// Insert Package area




	?>

<td height="380" align="center" valign="top"><script
	type="text/javascript">

jQuery.validator.addMethod(
		  "selectNone",
		  function(value, element) {
		    if (element.value == "none")
		    { 
		      return false;
		    }
		    else return true;
		  },
		  "Please select an option."
		);



    $(document).ready(function() {
      $("#addcategory").validate({
        rules: {
    	  categoryname: "required",// simple rule, converted to {required:true}
         
		  subscription: {
	        selectNone: true
	      },
          email: {// compound rule
          	required: true,
         	 email: true
        },
        },
        
      });
    });
  </script>





<form name="addcategory" id="addcategory" action="add_category.php"
	method="post">
<table cellpadding="2" cellspacing="2" border="0">



	<tr>
		<td colspan="2" align="center">Add Category</td>

	</tr>




	<tr>
		<td colspan="2" align="center"><?php print $ErrorMessage ?></td>

	</tr>



	<tr>
		<td>categoryname</td>
		<td><input type="text" name="categoryname" id="categoryname"></td>
	</tr>

 



	<tr>

		<td colspan="2" align="center"><input type="submit" name="Add"
			id="Add" value="Add"></td>
	</tr>



</table>
</form>
<!--   --></td>
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