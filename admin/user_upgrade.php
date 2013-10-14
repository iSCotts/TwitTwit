<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
?>
<script type="text/javascript">
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
	 // Internet Explorer
	 try {
	  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	  catch (e)
	  { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	}
	return xmlHttp;
}
function changeuserpackage()
{
 var packageid = document.getElementById('packageid').value;
 var username = document.getElementById('user').value;
 // call ajax 
 xmlHttp=GetXmlHttpObject();
 if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
   var url="change_userpkg.php";
   url=url+"?packageid="+packageid+"&username="+username+"";
   xmlHttp.onreadystatechange=stateChangedreloaded;
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);	
}
function stateChangedreloaded()
{
	if(xmlHttp.readyState==4)
	{
	document.getElementById('result').innerHTML=xmlHttp.responseText;
	}
}
</script>
<?php
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
?>
<td height="280" align="center" valign="top">
<!--my work area -->
<?php
db_connect();
//$resTemp 	= mysql_query($query) or die(mysql_error());
$query	= " SELECT `UserName` FROM `ta_users` ORDER BY UserName asc ";
$resTemp1 	= mysql_query($query) or die(mysql_error());
db_close();
if($_REQUEST['user'] != '')
{
	db_connect();
	//$resTemp 	= mysql_query($query) or die(mysql_error());
	$query2	= "SELECT *  FROM `ta_users` sa LEFT JOIN `ta_user_subscriptions` us ON sa.`UserName` = us.`UserName`  LEFT JOIN `ta_packages` p ON us.`PackageID` = p.`packageID` where  sa.`UserName` = '$_REQUEST[user]'  ORDER BY sa.`UserName` DESC";
	$resTemp2 	= mysql_query($query2) or die(mysql_error());
	db_close();
}
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
<br/><br/>
<form name="frm1" method="POST" action="user_upgrade.php" >
<table  border="0">
  <tr>
    <td>User : </td>
    <td>
	<select name="user" id="user" >
		<option selected="selected" value="">Select User</option>
		<?php
		for($i=0;$i<mysql_num_rows($resTemp1);$i++)
		{
			$temp = mysql_fetch_array($resTemp1);
		?>
		<option <?php if($_REQUEST['user'] === $temp['UserName']) {?> selected="selected" <?php }?> value="<?php echo $temp['UserName'];?>"><?php 		echo $temp['UserName'];?></option>
		<?php
		}
		?>
	</select>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><input type="submit" value="Search"  /></td>
  </tr>
</table>
</form>
<br/>
<table width="60%" border="1">
  <tr>
<?php
	if($_REQUEST['user'] != '')
	{
?>
 
<?php

for($i=0;$i<mysql_num_rows($resTemp2);$i++)
{
	$temp = mysql_fetch_array($resTemp2);
	$userpkg=$temp['packageName'];
	?>
    <td align="center" colspan="2"><b><?php echo $temp['UserName'];?></b> has subscribed to <b><?php  echo $temp['packageName'];?></b> </td>
    </tr>
    <tr>
    <td>
     Change user package : 
     </td>
	 <td>
	 <?php
	 $query3	= " SELECT `packageName`,`packageID` FROM `ta_packages` where packageName!='$userpkg'";
     $resTemp3 	= mysql_query($query3) or die(mysql_error());
	    ?>
		 <select name="packageid" id="packageid">
		 <?php
		 for($i=0;$i<mysql_num_rows($resTemp3);$i++)
		 {
			  $temp3 = mysql_fetch_array($resTemp3);
			 ?>
			 <option value="<?php echo  $temp3['packageID'];  ?>"><?php echo  $temp3['packageName'];  ?></option>
			 <?php
		 }
		 ?>
		 </select>
		 <input type="button" value="Change"  onclick="changeuserpackage()" />
	  </td>
	  <tr>
	  <td colspan="2" align="center">
	  <div id="result"></div>
	  </td>
	  </tr>
   </tr>
<?php
}
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