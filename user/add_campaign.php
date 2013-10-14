<?php ob_start();
session_start();
if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){
include "../includes/header.php";

if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
$Message = "Your Details Already there";}

if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==1)){
$Message = "Your UserName /Password InCorrect";}
			?>

<!-- jQuery -->

<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->

<!-- required plugins -->
<script
	type="text/javascript" src="<?php echo JS_PATH.'date.js' ?>"></script>
<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.min.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.datePicker.js' ?>"></script>
<!-- datePicker required styles -->
<link 	rel="stylesheet" type="text/css" media="screen"  href="<?php echo CSS_PATH.'datePicker.css' ?>">
<style>
/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(<?php echo IMG_PATH."iconDatePicker.gif" ?>) no-repeat;
}

a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}

/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}
</style>


<script type="text/javascript">

$(function()
		{
			$('.date-pick').datePicker()
			$('#start-date').bind(
				'dpClosed',
				function(e, selectedDates)
				{
					var d = selectedDates[0];
					if (d) {
						d = new Date(d);
						$('#end-date').dpSetStartDate(d.addDays(1).asString());
					}
				}
			);
			$('#end-date').bind(
				'dpClosed',
				function(e, selectedDates)
				{
					var d = selectedDates[0];
					if (d) {
						d = new Date(d);
						$('#start-date').dpSetEndDate(d.addDays(-1).asString());
					}
				}
			);
		});





$(document).ready(function() {
    $("#addcampaign").validate({

    	 
    	
      rules: {
    	campaignname: "required",// simple rule, converted to {required:true}
    	campaignnamedesc: "required"// simple rule, converted to {required:true}
	  },

	  messages:{
		  campaignname:{
		  required:"Please enter campaignname"
	  },
	  campaignnamedesc:{
		  required:"Please enter campaignnamedesc"
	  }

	  }
	  
      
    });
  });

 

  </script>


<tr>

	<td colspan="2">
<form id="addcampaign" name="addcampaign" method="post"
			action="add_campaignaction">



	<table cellpadding="2" cellpadding="2">
		<!-- <form id="addcampaign" name="addcampaign" method="post" action="add_campaignaction" onSubmit="return AddCampaignValidation();"> -->
		

		<tr>
			<td colspan="2" align="center"><?php print $Message ?></td>
		</tr>


		<tr>
			<td colspan="2" align="center">Add Campaign</td>
		</tr>

		<tr>
			<td><label for="campaignname">Campaign Name(*)</label></td>
			<td><input type="text" name="campaignname" id="campaignname"></td>
		</tr>
		<tr>
			<td valign="top">Campaign Description(*)</td>


			<td><textarea name="campaignnamedesc" cols="40" rows="10"
				id="campaignnamedesc"></textarea></td>


		</tr>

		<tr>
			<td>Start Date</td>
			<td><input type="text" name="start-date" id="start-date" size="7"
				class="date-pick"> <!-- <img src="../images/iconDatePicker.gif"
			onclick="displayDatePicker('startdate', false, 'ymd', '-');"
			border="0"></img>  --></td>
		</tr>


		<tr>
			<td>End Date</td>
			<td><input type="text" name="end-date" id="end-date" size="7" class="date-pick">

			<!-- <img src="../images/iconDatePicker.gif"
			onclick="displayDatePicker('enddate', false, 'ymd', '-');"
			border="0"></img>  --></td>
		</tr>


		<tr>
			<td colspan="2" align="center"><input type="submit" name="Add"
				value="AddCampaign"></td>
		</tr>

		
	</table>
</form>
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