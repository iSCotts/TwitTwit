<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){

?>

<td height="380" align="center">
<!--my work area -->
<?php
/*
* Created on 2010-05-26
* By Dinson
*/
$sqlWhere = '';
if($_REQUEST['user'] != '')
{
	$sqlWhere.= " AND us.`UserName` = '$_REQUEST[user]' ";
}
if($_REQUEST['date_range'] != '')
{
	$dTemp  = explode(' -to- ',$_REQUEST['date_range']);
	if(count($dTemp) == 2)
	{
		$start_date = date('Y-m-d',strtotime($dTemp[0]));
		$end_date = date('Y-m-d',strtotime($dTemp[1]));
		if($start_date == $end_date)
		{
			$sqlWhere.= "  AND sd.`date_record` = '$start_date' ";
		}
		else
		{
			$sqlWhere.= "  AND sd.`date_record` >= '$start_date' ";
			$sqlWhere.= "  AND sd.`date_record` <= '$end_date' ";
		}
	}
}
$query	= " SELECT sd.`sd_id`,  sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`next_payment_date` "
		. " ,p.`packageName` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " WHERE us.`UserName` !='' $sqlWhere "
		. " GROUP BY  sd.`sd_id` "
		. " ORDER BY sd.`date_record` DESC ";
db_connect();
$resTemp 	= mysql_query($query) or die(mysql_error());
$query	= " SELECT `UserName` FROM `ta_user_subscriptions` ORDER BY UserName ASC ";
$resTemp2 	= mysql_query($query) or die(mysql_error());
db_close();
$mc_fee_total =0;
$mc_gross_total =0;
?>
<link rel="stylesheet" href="datepicker/css/datepicker.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="datepicker/css/layout.css" />
<style >
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { 
	margin:0;
	padding:0;
}
table {
	border-collapse:collapse;
	border-spacing:0;
}
fieldset,img { 
	border:0;
}
</style>
<script language="javascript" type="text/javascript">
function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=600');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<script type="text/javascript" src="datepicker/js/eye.js"></script>
<script type="text/javascript" src="datepicker/js/utils.js"></script>
<script type="text/javascript" language="javascript">
(function($){
	var initLayout = function() {
		
		
		var now3 = new Date();
		//now3.addDays(-4);
		var now4 = new Date()
		$('#widgetCalendar').DatePicker({
			flat: true,
			format: 'd B, Y',
			date: [new Date(now3), new Date(now4)],
			calendars: 3,
			mode: 'range',
			starts: 1,
			onChange: function(formated) {
				$('#widgetField span').get(0).innerHTML = formated.join(' -to- ');
				if(document.getElementById('date_range'))
				{
					document.getElementById('date_range').value = formated.join(' -to- ');
				}
			}
		});
		var state = false;
		$('#widgetField>a').bind('click', function(){
		
			$('#widgetCalendar').stop().animate({height: state ? 0 : $('#widgetCalendar div.datepicker').get(0).offsetHeight}, 500);
			state = !state;
			return false;
		});
		$('#widgetCalendar div.datepicker').css('position', 'absolute');
	};
		
	EYE.register(initLayout, 'init');
})(jQuery)
function dkClearDateRange()
{
	$('#widgetField span').get(0).innerHTML = '';
	if(document.getElementById('date_range'))
	{
		document.getElementById('date_range').value = '';
	}
	return false;
}
</script>
<form name="frm1" method="POST" action="payment_history.php" >
<input type="hidden" name="date_range" id="date_range" value="<?php echo $_REQUEST['date_range'];?>"  />
<table  border="0">
  <tr>
    <td>User</td>
    <td>
	<select name="user"  >
		<option selected="selected" value="">Select User</option>
		<?php
		for($i=0;$i<mysql_num_rows($resTemp2);$i++)
		{
			$temp = mysql_fetch_array($resTemp2);
		?>
		<option <?php if($_REQUEST['user'] === $temp['UserName']) {?> selected="selected" <?php }?> value="<?php echo $temp['UserName'];?>"><?php echo $temp['UserName'];?></option>
		<?php
		}
		?>
	</select>
	</td>
  </tr>
  <tr>
    <td>Date Range</td>
    <td>
	<br/>
	<div id="widget">
		<div id="widgetField">
			<span><?php echo $_REQUEST['date_range'];?></span>
			<a href="#">Select date range</a>
		</div>
		<div id="widgetCalendar">
		</div>
	</div>
	<a href="#" onclick="return dkClearDateRange()" style="margin-left:260px;">clear</a>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Search"  /></td>
  </tr>
</table>
</form>
<table  border="0">
  <tr>
    <td width="167"><a href="active_subscriptions.php">Active subscriptions</a></td>
    <td width="122"><a href="cancellations.php">Cancellations</a></td>
	<td width="81"><a href="refunds.php">Refunds</a></td>
  </tr>
</table>
<br/>
<table width="100%" border="1">
  <tr>
<?php
	if($_REQUEST['user'] == '')
	{
?>
    <td width="24%">User Name</td>
<?php
	}
?>
    <td width="20%">Package Name</td>
    <td width="15%">MC Fee $</td>
    <td width="15%">MC Gross $</td>
    <td width="15%">Payment Start Date</td>
    <td width="15%">Payment Status</td>
    <td width="17%">Next Payment Due Date </td>
  </tr>
<?php
for($i=0;$i<mysql_num_rows($resTemp);$i++)
{
	$temp = mysql_fetch_array($resTemp);
	$mc_fee_total+=$temp['mc_fee'];
	$mc_gross_total+=$temp['mc_gross'];
?>
  <tr>
<?php
	if($_REQUEST['user'] == '')
	{
?>
    <td><?php echo $temp['UserName'];?><a href="#" onclick="return popitup('<?php echo 'view_more_payment.php?user='.$temp['UserName'] ?>')" >View More</a></td>
<?php
	}
?>
    <td><?php echo $temp['packageName'];?> </td>
    <td><?php echo $temp['mc_fee'];?> </td>
    <td><?php echo $temp['mc_gross'];?> </td>
    <td><?php echo $temp['payment_starts'];?> </td>
    <td><?php echo $temp['payment_status'];?> </td>
    <td><?php echo $temp['next_payment_date'];?> </td>
  </tr>
<?php
}
?>
</table>
<br/>
<table width="200" border="1">
  <tr>
    <td>MC Gross Total($)</td>
    <td><?php echo $mc_gross_total;?> </td>
  </tr>
  <tr>
    <td>MC Fee Total($)</td>
    <td><?php echo $mc_fee_total;?> </td>
  </tr>
  <tr>
    <td>Total($)</td>
    <td><?php echo $mc_gross_total - $mc_fee_total;?> </td>
  </tr>
</table>

<!--my work area -->
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