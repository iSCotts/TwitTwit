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

  </script>
  
<td height="380" align="center" valign="top">
<form name="addapi" id="addapi" action="yearlyapistats.php" 	method="post">
<table cellpadding="2" cellspacing="5" border="0">
	<tr>
		<td class="label">Year</td><td>
		<select name="yearselect" id="yearselect">
		<?php for($yr=2010;$yr<2021;$yr++)
		{?>
		<option value="<?php echo $yr ?>" <?php if($_REQUEST['yearselect']==$yr) echo "selected"; ?>><?php echo $yr ?></option>
		<?php }?>
		</select></td>
	</tr>
	<tr>
		<td class="label">API Method</td>
		<?php 
		$sql = "SELECT distinct apitype FROM ta_api_statistics";
		$getapiList = runQuery($sql);
		?><td colspan="3">
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
		<td colspan="4" align="center"><input type="submit" name="Add" id="Add" value="Show Stats"  /><!-- onclick="Getapistat(document.addapi.startdate.value,document.addapi.apimethod.value)"/>--></td>
	</tr>
	<tr><td colspan="4" align="center"><?php if(isset($_REQUEST['Add'])){
		?>
		<img src="yearlyapiimage.php?month=<?php echo $_REQUEST['month'];?>&yearselect=<?php echo $_REQUEST['yearselect'];?>&apimethod=<?php echo $_REQUEST['apimethod'];?>"/>	
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