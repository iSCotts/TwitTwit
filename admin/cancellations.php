<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){

?>

<td height="380" align="center"  valign="top">
<!--my work area -->
<?php
$sqlWhere = '';
$query	= " SELECT sd.`sd_id`,sd.`txn_type`,sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`amount3`,us.`next_payment_date` "
		. " ,p.`packageName` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " WHERE us.`UserName` !='' $sqlWhere  and  sd.txn_type='subscr_cancel'"
		. " GROUP BY   us.`SubsID` "
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
	newwindow=window.open(url,'name','height=600,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<table  border="0">
  <tr>
     <td width="156"><a href="free_subscriptions.php">Free subscriptions</a></td>
    <td width="151"><a href="active_subscriptions.php">Active subscriptions</a></td>
    <td width="92"><a href="cancellations.php">Cancellations</a></td>
	<td width="102"><a href="refunds.php">Refunds</a></td>
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
    <td width="15%">MC Gross $</td>
    <td width="15%">Status</td>
    <td width="17%">Cancel Date </td>
  </tr>
<?php
for($i=0;$i<mysql_num_rows($resTemp);$i++)
{
	$temp = mysql_fetch_array($resTemp);
?>
  <tr>
<?php
	if($_REQUEST['user'] == '')
	{
?>
    <td><?php echo $temp['UserName'];?>&nbsp;&nbsp;<a href="#" onclick="return popitup('<?php echo 'view_more_payment.php?user='.$temp['UserName'] ?>')" >View More</a>  </td>
<?php
	}
?>
    <td><?php echo $temp['packageName'];?> </td>
    <td><?php echo $temp['amount3'];?> </td>
    <td><?php  if($temp['txn_type']=="subscr_cancel")  echo "Cancelled";?> </td>
    <td><?php echo $temp['date_record'];?> </td>
  </tr>
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
?>
 
 
 <?php
 }
 else
 {
 header("Location:index.php?act=3");
		exit;
 }
 
 ?>