<?php
ob_start();
session_start();
include "common/dbconfig.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$user=$_REQUEST['user'];
?>
<html>
<head>
<title>Twitacc Admin Panel</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { 
	margin:0;
	padding:0;
}
table {
	border-collapse:collapse;
	border-spacing:0;
}
td{
font-size:12px;
font-family:Arial, Helvetica, sans-serif;
color:#000000;
}
fieldset,img { 
	border:0;
}
</style>
</head>
<body>
<table border="0" cellpadding="2"  cellspacing="2" width="100%">
<td height="380" align="center"  valign="top">
<!--my work area -->
<?php
$query	= " SELECT sd.`sd_id`,  sd.`payment_status`, sd.`payment_starts`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross`,sd.`txn_id`,sd.`txn_type` "
		. " ,us.`UserName`,us.`amount3`,us.`next_payment_date` "
		. " ,p.`packageName` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " WHERE us.`UserName`='$user'"
		. " GROUP BY  sd.`sd_id` "
		. " ORDER BY sd.`sd_id` ASC ";
db_connect();
$resTemp 	= mysql_query($query) or die(mysql_error());
$query	= " SELECT `UserName` FROM `ta_user_subscriptions` ORDER BY UserName ASC ";
$resTemp2 	= mysql_query($query) or die(mysql_error());
db_close();
$mc_fee_total =0;
$mc_gross_total =0;
?>

<table width="100%" border="1"  cellpadding="2"  cellspacing="2">
  <tr><td colspan="9" align="center" style="font:Arial, Helvetica, sans-serif; font-size:16px;">Payment history of <?php echo  $user; ?> </td></tr>
  <tr>
    <td>Date</td>
    <td>Package Name</td>
    <td>MC Fee $</td>
    <td>MC Gross $</td>
    <td>Payment Start Date</td>
    <td>Payment Status</td>
	<td>Transaction Id</td>
	<td>Transaction Type</td>
    <td>Next Payment Due Date </td>
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
    <td><?php echo $temp['UserName'];?> </td>
<?php
	}
?>
    <td><?php echo $temp['date_record'];?> </td>
    <td><?php echo $temp['packageName'];?> </td>
    <td><?php echo $temp['mc_fee'];?> </td>
    <td><?php  if($temp['txn_type']=="subscr_cancel") echo $temp['amount3']; else echo $temp['mc_gross'];?> </td>
    <td><?php echo $temp['payment_starts'];?> </td>
    <td><?php echo $temp['payment_status'];?> </td>
	 <td><?php echo $temp['txn_id'];?> </td>
	 <td><?php echo $temp['txn_type'];?> </td>
    <td><?php echo $temp['next_payment_date'];?> </td>
  </tr>
<?php
}
?>
</table>
</td></table>
</body>
</html>
 <?php
 }
 else
 {
 header("Location:index.php?act=3");
		exit;
 }
 
 ?>