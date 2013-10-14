<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
?>
<td height="380" align="center" valign="top">
<!--my work area -->
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
	$('#start_date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end_date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end_date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start_date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
});
</script>
<form name="aff_frm" method="POST" action="view_user_signup.php" >
<input type="hidden" name="startdate" id="startdate" value="<?php echo $_REQUEST['start_date'];?>"  />
<input type="hidden" name="enddate" id="enddate" value="<?php echo $_REQUEST['end_date'];?>"  />
<table  border="0">
  <tr>
    <td>User Name </td>
    <td>
	<?php
	db_connect();
	$query	= " SELECT * FROM `ta_users` ORDER BY 	`UserName`  ASC ";
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
		<option <?php if($_REQUEST['user'] === $temp['UserName']) {?> selected="selected" <?php }?> value="<?php echo $temp['UserName'];?>"><?php echo $temp['UserName'];?></option>
		<?php
		}
		?>
	</select>
	</td>
  </tr>
    <tr>
     <td colspan="2" align="center">OR
 	</td>
  	</tr>
    <tr>
    <td>Start Date</td>
    <td>
   <input  readonly  name="start_date" id="start_date"  class="date-pick" value="<?php echo $_REQUEST['start_date'];?>"/>
	</td>
  	</tr>
  <tr>
    <td>End Date</td>
    <td>
    <input   readonly name="end_date" id="end_date" class="date-pick" value="<?php echo $_REQUEST['end_date'];?>"/>
	</td>
  </tr>
   <tr>
      <td colspan="2" align="center"><input type="submit" value="Search"  /></td>
  </tr>
</table>
</form>
<br/>

<?php
    $sqlWhere = '';
	if(($_REQUEST['start_date'] != '')&&($_REQUEST['start_date'] != ''))
	{
			$start_date = date('Y-m-d',strtotime($_REQUEST['start_date']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));
			
			if($start_date == $end_date)
			{
				$sqlWhere= "  AND  DATE_FORMAT(u.`DT`,'%Y-%m-%d') = '$start_date'  ";
			}
			else
			{
				$sqlWhere= "  AND  DATE_FORMAT(u.`DT`,'%Y-%m-%d')>='$start_date' ";
				$sqlWhere.= "  AND DATE_FORMAT(u.`DT`,'%Y-%m-%d') <='$end_date'  ";
							}
	}
	if($_REQUEST['user'] != "")
	{
				$sqlWhere= "  AND  u.`UserName` ='".$_REQUEST['user']."'";
	}
    db_connect();
    $getuserdetails = "SELECT u.`UserName`,u.`Email`,u.`DT`,p.`packageName`,p.`monPrice` FROM `ta_users` u LEFT JOIN `ta_user_subscriptions` us  ON u.`UserName`=us.`UserName` LEFT JOIN `ta_packages` p ON p.`packageID`=us.`packageID`  WHERE us.`PackageID`!=0 ".$sqlWhere."  ORDER BY u.`DT`  DESC";
	$getuserresult  = mysql_query($getuserdetails);
	$rowcount=mysql_num_rows($getuserresult);
	db_close();
?>
	 <table width="100%" border="1">
	 <tr>
	<td width="20%" align="center"><strong>User Name</strong></td>
	<td width="20%" align="center"><strong>Email</strong></td>
    <td width="20%" align="center"><strong>Date of signup</strong></td>
	<td width="20%" align="center"><strong>Package name</strong></td>
	<td width="20%" align="center"><strong>Amount</strong></td>
	 </tr>   
<?php
if($rowcount>0)
{
 			 for($r=0;$r<$rowcount;$r++)
			 {
			 $temp = mysql_fetch_array($getuserresult);
		?>
		<tr>
	<td  align="center"><?php echo $temp['UserName'];?></td>
	<td align="center"><?php echo $temp['Email'];?></td>
    <td align="center"><?php echo date('d-m-Y',strtotime($temp['DT']));?></td>
	<td align="center"><?php echo $temp['packageName'];?></td>
		<td align="center"><?php echo $temp['monPrice'];?></td>
    </tr>
<?php
}
}
else{
?>
 <tr><td colspan="5" align="center">No Records Found </td></tr>
<?php
}
?>
</table>
<br/>
<table>
<tr>
<td align="center"></td>
<br/>
<?php
 $query2	= " SELECT sd.`sd_id`,  sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`next_payment_date` "
		. " ,p.`packageName` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " LEFT JOIN  `ta_users` u ON u.`UserName`=us.`UserName` "
		. " WHERE us.`UserName` !=''  and  (sd.`payment_status`='Completed' or sd.`payment_status`='Refunded') ".$sqlWhere
		. " GROUP BY sd.`sd_id` "
		. " ORDER BY sd.`date_record` DESC ";
db_connect();
$resTemp 	= mysql_query($query2) or die(mysql_error());
db_close();
$mc_fee_total =0;
$mc_gross_total =0;
?>
</tr>
<?php
for($i=0;$i<mysql_num_rows($resTemp);$i++)
{
	$temp = mysql_fetch_array($resTemp);
	$mc_fee_total+=$temp['mc_fee'];
	$mc_gross_total+=$temp['mc_gross'];
}
?>
</table>
<table width="200" border="1">
  <tr>
    <td><b>Total Signup</b></td></tr>
	<tr>
    <td><?php echo $rowcount;?> </td>
  </tr>
 </table>
<table width="200" border="1">
<tr><td colspan="2"><b>Total Amount</b></td></tr>
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
</td>
</tr>
<?php
include "includes/footer.php";
 }
 else
 {
 header("Location:index.php?act=3");
 }
  ?>