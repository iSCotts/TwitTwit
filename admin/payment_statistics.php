<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$month = date("m"); 
$year = date("Y"); 
$current_date=date("Y-m-d");
	?>
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

<td height="380" align="center" valign="top">
<!--user stats starts here
-->
<br/>
<table width="200" border="1">
<tr><td><b>Package Name</b></td><td><b>No.of users</b></td></tr>
<?php
$query3= " SELECT p.`packageName`,COUNT(us.`UserName`) as usercount FROM  `ta_user_subscriptions` us  LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` GROUP BY us.`PackageID`";
db_connect();
$resTemp3 	= mysql_query($query3) or die(mysql_error());
db_close();
for($i=0;$i<mysql_num_rows($resTemp3);$i++)
{
	$temp3 = mysql_fetch_array($resTemp3);
    $packagename=$temp3['packageName'];
	$usercount=$temp3['usercount'];
?>
<tr>
<td><?php echo  $packagename; ?></td><td><?php echo  $usercount; ?></td></tr>
<?php
}
?>
</table>
<!--user stats ends here
-->
<br/>
<!--Payments received till date starts here
-->
<table cellpadding="2" cellspacing="5">
<tr>
<td colspan="7" align="center"><b>Payments received till date</b></td>
<?php
$sqlWhere = '';
$query	= " SELECT sd.`sd_id`,  sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`next_payment_date` "
		. " ,p.`packageName` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " WHERE us.`UserName` !='' and  sd.`payment_status`!='pending' "
		. " GROUP BY   sd.`sd_id`  "
		. " ORDER BY sd.`date_record` DESC ";
db_connect();
$resTemp 	= mysql_query($query) or die(mysql_error());
db_close();
$mc_fee_total =0;
$mc_gross_total =0;
?>
</tr>
 
<?php
for($i=0;$i<mysql_num_rows($resTemp);$i++)
{
	$temp = mysql_fetch_array($resTemp);
	$payment_date=$temp['payment_date'];
	$mc_fee_total+=$temp['mc_fee'];
	$mc_gross_total+=$temp['mc_gross'];
}
?>
</table>
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
<!--Payments received till date ends here
-->
<!--Payments of this month ends here
-->
<table>
<tr>
<td align="center"><b>Payments this month</b></td>
<br/>
<?php
$query2	= " SELECT sd.`sd_id`,  sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`next_payment_date` "
		. " ,p.`packageName` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " WHERE us.`UserName` !=''  and  sd.`payment_status`!='pending' and DATE_FORMAT(sd.`date_record`, '%m') ='$month'"
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
<!--Payments of this month ends here
-->
<!--Payment due starts here
--><table>
<tr>
<td align="center"><b>Payment due this month</b></td>
<br/>
<?php
 $query2	= " SELECT sd.`sd_id`,  sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`next_payment_date` "
		. " ,p.`packageName`,p.`monPrice`"
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` "
		. " WHERE us.`UserName` !='' and us.`cancel`='N' and (DATE_FORMAT(us.`next_payment_date`, '%m') ='$month' and  DATE_FORMAT(us.`next_payment_date`, '%Y') ='$year'   and us.`next_payment_date`>'$current_date' )  or (DATE_FORMAT(sd.`date_record`, '%m') ='$month'  and sd.`date_record`>'$current_date')"
		. " GROUP BY sd.`sd_id` "
		. " ORDER BY sd.`date_record` DESC ";
db_connect();
$resTemp 	= mysql_query($query2) or die(mysql_error());
db_close();
//$mc_fee_total =0;
$mc_gross_total =0;
$totnew=0;
?>
</tr>
<?php
for($i=0;$i<mysql_num_rows($resTemp);$i++)
{
	$temp = mysql_fetch_array($resTemp);
	$re=explode('/',$temp['monPrice']);
	$res=explode('$',$re[0]);
	$totnew+=$res[1];
	//$mc_fee_total+=$temp['mc_fee'];
	$mc_gross_total+=$temp['mc_gross'];
}
?>
</table>
<table width="200" border="1">
  <tr>
    <td>Total($)</td>
    <td><?php echo $mc_gross_total; ?> </td>
  </tr>
</table>
<!--Payment due ends here
-->
<form name="pay_stat" id="pay_stat" action="payment_statistics.php" 	method="post">

<table width="438" border="0">
  <tr>
   <td class="label" width="45%">Select Month </td>
		<td width="55%"><div class="inner_boxes">
		<?php  if(isset($_REQUEST['month'])) $month=$_REQUEST['month']; ?>
		 <select name="month" id="month">
		<option value='01' <?php if ($_REQUEST['month']=='01' || $month=='01') echo "selected"; ?>>January</option>
		<option value='02' <?php if ($_REQUEST['month']=='02' || $month=='02') echo "selected"; ?>>February</option>
		<option value='03' <?php if ($_REQUEST['month']=='03' || $month=='03') echo "selected"; ?>>March</option>
		<option value='04' <?php if ($_REQUEST['month']=='04' || $month=='04') echo "selected"; ?>>April</option>
		<option value='05' <?php if ($_REQUEST['month']=='05' || $month=='05') echo "selected"; ?>>May</option>
		<option value='06' <?php if ($_REQUEST['month']=='06' || $month=='06') echo "selected"; ?>>June</option>
		<option value='07' <?php if ($_REQUEST['month']=='07' || $month=='07') echo "selected"; ?>>July</option>
		<option value='08' <?php if ($_REQUEST['month']=='08' || $month=='08') echo "selected"; ?>>August</option>
		<option value='09' <?php if ($_REQUEST['month']=='09' || $month=='09') echo "selected"; ?>>September</option>
		<option value='10' <?php if ($_REQUEST['month']=='10' || $month=='10') echo "selected"; ?>>October</option>
		<option value='11' <?php if ($_REQUEST['month']=='11' || $month=='11') echo "selected"; ?>>November</option>
		<option value='12' <?php if ($_REQUEST['month']=='12' || $month=='12') echo "selected"; ?>>December</option>
		</select>
	  	<?php  if(isset($_REQUEST['year'])) $year=$_REQUEST['year']; ?>
		 <select name="year" id="year">
		<option value='2010' <?php if ($_REQUEST['year']=='2010' || $year=='2010') echo "selected"; ?>>2010</option>
		<option value='2011' <?php if ($_REQUEST['year']=='2011' || $year=='2011') echo "selected"; ?>>2011</option>
		<option value='2012' <?php if ($_REQUEST['year']=='2012' || $year=='2012') echo "selected"; ?>>2012</option>
		<option value='2013' <?php if ($_REQUEST['year']=='2013' || $year=='2013') echo "selected"; ?>>2013</option>
		<option value='2014' <?php if ($_REQUEST['year']=='2014' || $year=='2014') echo "selected"; ?>>2014</option>
		<option value='2015' <?php if ($_REQUEST['year']=='2015' || $year=='2015') echo "selected"; ?>>2015</option>
		<option value='2016' <?php if ($_REQUEST['year']=='2016' || $year=='2016') echo "selected"; ?>>2016</option>
		<option value='2017' <?php if ($_REQUEST['year']=='2017' || $year=='2017') echo "selected"; ?>>2017</option>
		<option value='2018' <?php if ($_REQUEST['year']=='2018' || $year=='2018') echo "selected"; ?>>2018</option>
		<option value='2019' <?php if ($_REQUEST['year']=='2019' || $year=='2019') echo "selected"; ?>>2019</option>
		<option value='2020' <?php if ($_REQUEST['year']=='2020' || $year=='2020') echo "selected"; ?>>2020</option>
		</select>
	  </div></td>
	  </tr>
	  <tr><td colspan="2" align="center"> <input type="submit" name="View" id="View" value="View"  /></td></tr>
	  </table>
	  </form>
	  <?php
     if(isset($_REQUEST['View'])){
	 $query3	="SELECT sd.`sd_id`,  sd.`payment_status`, sd.`date_record`, sd.`mc_fee`, sd.`mc_gross`,us.`UserName` ,us.`next_payment_date`,p.`packageName`  FROM `ta_subscription_details` sd  LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID`  LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID`  WHERE us.`UserName` !='' and (DATE_FORMAT(sd.`date_record`, '%m') ='$month') and (DATE_FORMAT(sd.`date_record`, '%Y') ='$year')    ORDER BY sd.`date_record` DESC";
	db_connect();
	$resTemp3 	= mysql_query($query3) or die(mysql_error());
	db_close();
	$mc_fee_total =0;
    $mc_gross_total =0;
	  ?>
  <table  border="1">
   <tr>
   <td colspan="10" align="center" style="font-size:16px;">Payment history</td></tr>
   <tr>
   <td>Username</td>
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
for($i=0;$i<mysql_num_rows($resTemp3);$i++)
{
	$temp = mysql_fetch_array($resTemp3);
	$mc_fee_total+=$temp['mc_fee'];
	$mc_gross_total+=$temp['mc_gross'];
?>
  <tr>
   <td><?php echo $temp['UserName'];?> </td>
    <td><?php echo $temp['date_record'];?> </td>
    <td><?php echo $temp['packageName'];?> </td>
    <td><?php echo $temp['mc_fee'];?> </td>
    <td><?php  if($temp['txn_type']=="subscr_cancel") echo $temp['amount3']; else echo $temp['mc_gross'];?> </td>
    <td><?php echo $temp['date_record'];?> </td>
    <td><?php echo $temp['payment_status'];?> </td>
	 <td><?php echo $temp['txn_id'];?> </td>
	 <td><?php echo $temp['txn_type'];?> </td>
    <td><?php echo $temp['next_payment_date'];?> </td>
   </tr>
	<?php
	}
	
	?>
</table>
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
<?php }
?>
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