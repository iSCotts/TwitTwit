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
<style>
/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
 float: left;
 width:23px;
 height:20px;
 padding: 0;
 margin:0 0 0 3px;
 display: block;
 text-indent: -2000px;
 overflow: hidden;
 background: url(images/calender.jpg) no-repeat;
 float:left;
}

a.dp-choose-date.dp-disabled {
 background-position: 0 -20px;
 cursor: default;
}

/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
 width: 100px;
 float: left;
 padding:2px 0 0 2px;
 height:17px;
 background-color:#fff;
 font-size:12px;
 font-family:Verdana, Arial, Helvetica, sans-serif;
 float:left;
}
.affiliate_txtbx{
padding:0 0 0 15px;
width:60px;
float:left;
text-align:left;
}
</style>
<script type="text/javascript" src="datepicker/js/datepicker.js"></script>
<script type="text/javascript" src="datepicker/js/eye.js"></script>
<script type="text/javascript" src="datepicker/js/utils.js"></script>
<script type="text/javascript" language="javascript">
 $(function()
{
	$('.date-pick').datePicker(
					{
						startDate:  (new Date('01/01/1996')).asString(),
						endDate: (new Date()).asString()
										}
				);
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
</script>
<form name="aff_frm" method="POST" action="viewaffiliatesales.php" >
							<input type="hidden" name="startdate" id="startdate" value="<?php echo $_REQUEST['start-date'];?>"  />
							<input type="hidden" name="enddate" id="enddate" value="<?php echo $_REQUEST['end-date'];?>"  />
<table  border="0">
  <tr>
    <td>User</td>
    <td>
	<?php
	db_connect();
	$query	= " SELECT `UserID` FROM `ta_affiliate_request` ORDER BY UserID ASC ";
	$resTemp2 	= mysql_query($query) or die(mysql_error());
	db_close();
	?>
	<select name="user"  >
		<option selected="selected" value="">Select User</option>
		<?php
		for($i=0;$i<mysql_num_rows($resTemp2);$i++)
		{
			$temp = mysql_fetch_array($resTemp2);
		?>
		<option <?php if($_REQUEST['user'] === $temp['UserID']) {?> selected="selected" <?php }?> value="<?php echo $temp['UserID'];?>"><?php echo $temp['UserID'];?></option>
		<?php
		}
		?>
	</select>
	</td>
  </tr>
  <tr>
    <td>Start Date</td>
    <td>
   <input  readonly  name="start-date" id="start-date"  class="date-pick" value="<?php echo $_REQUEST['start-date'];?>"/>
	</td>
  </tr>
    <tr>
    <td>End Date</td>
    <td>
    <input   readonly name="end-date" id="end-date" class="date-pick" value="<?php echo $_REQUEST['end-date'];?>"/>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Search"  /></td>
  </tr>
</table>
</form>
<br/>
<table width="100%" border="1">
  <tr>
<?php
    $sqlWhere = '';
	$mc_gross_total =0;
	if(($_REQUEST['startdate'] != '')&&($_REQUEST['enddate'] != ''))
	{
			$start_date = date('Y-m-d',strtotime($_REQUEST['startdate']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['enddate']));
			
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
	        db_connect();
			$getaffiliatedetails = "SELECT sd.`sd_id` , sd.`payment_status` , sd.`date_record` , sd.`mc_fee` , sd.`mc_gross` , us.`Email`, us.`UserName` , ".		"us.`next_payment_date` , p.`packageName`"
			."FROM `ta_subscription_details` sd LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID`"
			."LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID`"
			."LEFT JOIN `ta_affiliate_request` af ON af.`affiliateid` = us.`affiliateid`"
			."WHERE af.`UserID` = '".$_REQUEST['user'] ."' $sqlWhere  GROUP BY us.`SubsID` "
		    . " ORDER BY sd.`date_record` DESC ";
		    $getaffiliatedetailsresult  = mysql_query($getaffiliatedetails);
			db_close();
	if($_REQUEST['user'] == '')
	{
?>
    <td width="20%">User Name</td>
<?php
	}
?>
    <td width="20%">Email</td>
    <td width="20%">Package Name</td>
    <td width="20%">Amount</td>
    <td width="20%">Date</td>
   </tr>
<?php
if(mysql_num_rows($getaffiliatedetailsresult)>0)
{
 			 for($r=0;$r<mysql_num_rows($getaffiliatedetailsresult);$r++)
			 {
			 $temp = mysql_fetch_array($resTemp);
			 $mc_gross_total+=$temp['mc_gross'];
?>
  <tr>
<?php
	if($_REQUEST['user'] == '')
	{
?>
    <td><?php echo $temp['UserID'];?></td>
<?php
	}
?>
    <td><?php echo $temp['Email'];?> </td>
    <td><?php echo $temp['packageName'];?></td>
    <td><?php echo $temp['mc_gross'];?></td>
    <td><?php echo  date('d-m-Y',strtotime($temp['date_record']));?></td>
     </tr>
<?php
}
}
else{
?>
 <tr><td colspan="5" align="center">No sales records </td></tr>
<?php
}
?>
</table>
<br/>
<table width="200" border="1">
  <tr>
    <td>Total Sales ($)</td>
    <td><?php echo $mc_gross_total;?> </td>
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