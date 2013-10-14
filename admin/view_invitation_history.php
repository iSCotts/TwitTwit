<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
if(isset($_REQUEST["delete_id"]) && ($_REQUEST["delete_id"]!= ""))
{
db_connect();
$sql = "DELETE   FROM ta_invitation_history WHERE ih_id ='$_REQUEST[delete_id]'";
mysql_query($sql);
$ErrorMessage = "Deleted Successfully";
db_close();
}
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
<form name="aff_frm" method="POST" action="view_invitation_history.php" >
<input type="hidden" name="startdate" id="startdate" value="<?php echo $_REQUEST['start_date'];?>"  />
<input type="hidden" name="enddate" id="enddate" value="<?php echo $_REQUEST['end_date'];?>"  />
<table  border="0">
  <tr><td colspan="9" align="center"><?php print $ErrorMessage ?></td></tr>
  <tr>
    <td>User Name </td>
    <td>
	<?php
	db_connect();
	$query	= " SELECT distinct `ih_username` FROM `ta_invitation_history` ORDER BY 	`ih_username`  ASC ";
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
		<option <?php if($_REQUEST['user'] === $temp['ih_username']) {?> selected="selected" <?php }?> value="<?php echo $temp['ih_username'];?>"><?php echo $temp['ih_username'];?></option>
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
	if(($_REQUEST['startdate'] != '')&&($_REQUEST['enddate'] != ''))
	{
			$start_date = date('Y-m-d',strtotime($_REQUEST['start_date']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));
			
			if($start_date == $end_date)
			{
				$sqlWhere= "  WHERE `ih_date` = '$start_date' ";
			}
			else
			{
				$sqlWhere= "  WHERE `ih_date` >='$start_date' ";
				$sqlWhere.= "  AND `ih_date` <='$end_date'  ORDER BY `ih_username`  ASC  ";
							}
	}
	if($_REQUEST['user'] != "")
	{
				$sqlWhere= "  WHERE  `ih_username` ='".$_REQUEST['user']."'";
	}
    db_connect();
    $getinvitationdetails = "SELECT * FROM  `ta_invitation_history`".$sqlWhere;
	$getinvitationresult  = mysql_query($getinvitationdetails);
	$rowcount=mysql_num_rows($getinvitationresult);
	db_close();
	if($_REQUEST['user']!="")
	{
?>
   <table width="100%" border="1">
   <tr>
 	<td width="20%" align="center"><strong>User Name</strong></td>
   	<td width="20%" align="center"><strong>No. of mails sent</strong></td>
	</tr><tr>
	 <td align="center"><?php echo $_REQUEST['user'];?></td>
	 <td align="center"><?php echo $rowcount;?></td>
	 </tr>
	 </table>
	  <br/>
<?php } ?>
	 <table width="100%" border="1">
	 <tr>
	<?php
	 if($_REQUEST['startdate']!="")
	{?>
	<td width="20%" align="center"><strong>User Name</strong></td>
	<?php } ?>
    <td width="20%" align="center"><strong>Email</strong></td>
    <td width="20%" align="center"><strong>Date</strong></td>
	<td width="20%" align="center"><strong>Delete</strong></td>
    </tr>   
<?php
if($rowcount>0)
{
 			 for($r=0;$r<$rowcount;$r++)
			 {
			 $temp = mysql_fetch_array($getinvitationresult);
		?>
		<tr>
			<?php
	 if($_REQUEST['startdate']!="")
	{?>
	<td  align="center"><?php echo $temp['ih_username'];?></td>
	<?php } ?>
    <td align="center"><?php echo $temp['ih_email'];?></td>
    <td align="center"><?php echo  date('d-m-Y',strtotime($temp['ih_date']));?></td>
	<td align="center"><a href="?delete_id=<?php echo $temp['ih_id'] ?>"><img src="images/delete.gif" border="0" height="15"></a></td>
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
<!--my work area -->
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