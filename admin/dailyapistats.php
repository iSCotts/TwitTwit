<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
	?>
<script type="text/javascript">
	$(function()
			{
				$('.date-pick').datePicker(
					{
						startDate:  (new Date('01/01/1996')).asString(),
						endDate: (new Date()).asString()
										}
				);
			});
  </script>
  
<td height="380" align="center" valign="top">
<form name="addapi" id="addapi" action="dailyapistats.php" 	method="post">
<table cellpadding="2" cellspacing="5" border="0">
	<tr>
		<td class="label">Date </td>
		<td><div class="inner_boxes">
		<input    readonly  name="startdate" id="startdate" value="<?php if(isset($_REQUEST['startdate'])){ echo $_REQUEST['startdate'];} ?>" class="date-pick"/></div></td>
	</tr>
	<tr>
		<td class="label">API Method</td>
		<?php 
		$sql = "SELECT distinct apitype FROM ta_api_statistics";
		$getapiList = runQuery($sql);
		?><td>
		 <select name="apimethod" id="apimethod">
		 <option value="All">All</option>
		  <?php		
  		if(count($getapiList) >=1 )
  		{	
		for($y=0;$y<count($getapiList);$y++){
		?>
		<option value="<?php echo $getapiList[$y]['apitype'];?>" <?php if ($_REQUEST['apimethod']==$getapiList[$y]['apitype']) echo "selected"; ?>><?php echo $getapiList[$y]['apitype'];?></option>
		<?php }
		}?>
		</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="Add" id="Add" value="Show Stats"  /><!-- onclick="Getapistat(document.addapi.startdate.value,document.addapi.apimethod.value)"/>--></td>
	</tr>
	<tr><td colspan="2" align="center"><?php if(isset($_REQUEST['Add'])){
		?>
		<img src="dailyapiimage.php?datetext=<?php echo $_REQUEST['startdate'];?>&apimethod=<?php echo $_REQUEST['apimethod'];?>"/>	
		<?php 
	}?></td>
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