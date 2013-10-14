<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$phpdate		    		= date("Y-m-d");
if(isset($_REQUEST['uk']))
{
  $sqlext=" and us.`UserName` LIKE '$_REQUEST[uk]%'";
}
else{
	 $sqlext="";
}
?>

<td height="380" align="center" valign="top">
<!--my work area -->
<?php
$query	= "SELECT * FROM `ta_users` u LEFT JOIN `ta_user_subscriptions` us ON u.`UserName` = us.`UserName` WHERE `PackageID` = '0'".$sqlext." ORDER BY u.UserName ASC";
db_connect();
$resTemp 	= mysql_query($query) or die(mysql_error());
db_close();
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
<table width="519"  border="0">
  <tr>
   <td width="156"><a href="free_subscriptions.php">Free subscriptions</a></td>
    <td width="151"><a href="active_subscriptions.php">Active subscriptions</a></td>
    <td width="92"><a href="cancellations.php">Cancellations</a></td>
	<td width="102"><a href="refunds.php">Refunds</a></td>
  </tr>
</table>
<br/>
<table width="40%" border="1">
<tr><td colspan="2">
<a href="free_subscriptions.php?uk=a">A </a> 
<a href="free_subscriptions.php?uk=b">B </a> 
<a href="free_subscriptions.php?uk=c">C </a> 
<a href="free_subscriptions.php?uk=d">D </a> 
<a href="free_subscriptions.php?uk=e">E </a> 
<a href="free_subscriptions.php?uk=f">F </a> 
<a href="free_subscriptions.php?uk=g">G </a> 
<a href="free_subscriptions.php?uk=h">H  </a> 
<a href="free_subscriptions.php?uk=i">I </a> 
<a href="free_subscriptions.php?uk=j">J </a> 
<a href="free_subscriptions.php?uk=k">K </a> 
<a href="free_subscriptions.php?uk=l">L </a> 
<a href="free_subscriptions.php?uk=m">M </a> 
<a href="free_subscriptions.php?uk=n">N </a> 
<a href="free_subscriptions.php?uk=o">O </a> 
<a href="free_subscriptions.php?uk=p">P </a> 
<a href="free_subscriptions.php?uk=q">Q </a> 
<a href="free_subscriptions.php?uk=r">R </a> 
<a href="free_subscriptions.php?uk=s">S </a> 
<a href="free_subscriptions.php?uk=t">T  </a> 
<a href="free_subscriptions.php?uk=u">U  </a> 
<a href="free_subscriptions.php?uk=v">V  </a> 
<a href="free_subscriptions.php?uk=w">W </a> 
<a href="free_subscriptions.php?uk=x">X </a> 
<a href="free_subscriptions.php?uk=y">Y </a> 
<a href="free_subscriptions.php?uk=z">Z </a> </td></tr>
<tr>
<?php
	if($_REQUEST['user'] == '')
	{
?>
    <td width="52%"><b>User Name</b></td>
<?php
	}
?>
    <td width="48%"><b>Status</b></td>
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
    <td><?php echo $temp['UserName'];?></td>
<?php
	}
?>
	 <td><?php  if($temp['status']=='Y')  echo "Active"; else echo "Inactive"; ?> </td>
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