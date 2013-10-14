<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$month = date("n"); 
	?>
<script type="text/javascript">

  </script>
  
<td height="380" align="center" valign="top">
<form name="addapi" id="addapi" action="monthlyapistats.php" 	method="post">
<table cellpadding="2" cellspacing="5" border="0">
	<tr>
		<td class="label" width="25%">Month </td>
		<td width="25%"><div class="inner_boxes">
		 <select name="month" id="month">
		<option value='1' <?php if ($_REQUEST['month']==1 || $month==1) echo "selected"; ?>>January</option>
		<option value='2' <?php if ($_REQUEST['month']==2 || $month==2) echo "selected"; ?>>February</option>
		<option value='3' <?php if ($_REQUEST['month']==3 || $month==3) echo "selected"; ?>>March</option>
		<option value='4' <?php if ($_REQUEST['month']==4 || $month==4) echo "selected"; ?>>April</option>
		<option value='5' <?php if ($_REQUEST['month']==5 || $month==5) echo "selected"; ?>>May</option>
		<option value='6' <?php if ($_REQUEST['month']==6 || $month==6) echo "selected"; ?>>June</option>
		<option value='7' <?php if ($_REQUEST['month']==7 || $month==7) echo "selected"; ?>>July</option>
		<option value='8' <?php if ($_REQUEST['month']==8 || $month==8) echo "selected"; ?>>August</option>
		<option value='9' <?php if ($_REQUEST['month']==9 || $month==9) echo "selected"; ?>>September</option>
		<option value='10' <?php if ($_REQUEST['month']==10 || $month==10) echo "selected"; ?>>October</option>
		<option value='11' <?php if ($_REQUEST['month']==11 || $month==11) echo "selected"; ?>>November</option>
		<option value='12' <?php if ($_REQUEST['month']==12 || $month==12) echo "selected"; ?>>December</option>
		</select>
		</div></td><td class="label" width="10%">Year</td><td width="40%">
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
		<img src="monthlyapiimage.php?month=<?php echo $_REQUEST['month'];?>&yearselect=<?php echo $_REQUEST['yearselect'];?>&apimethod=<?php echo $_REQUEST['apimethod'];?>"/>	
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