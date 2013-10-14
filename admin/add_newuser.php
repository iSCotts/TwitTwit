<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
?>
<?php
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
?>
<td height="280" align="center" valign="top">
<!--my work area -->
<?php
db_connect();
$phpdate	= date( 'Y-m-d H:i:s' );
//$resTemp 	= mysql_query($query) or die(mysql_error());
$query	= " SELECT `UserName` FROM `ta_users` ORDER BY UserName asc ";
$resTemp1 	= mysql_query($query) or die(mysql_error());
db_close();
if(isset($_REQUEST["submit"]))
{
	if(!empty($_REQUEST['username']))
	{
		db_connect();
		$username=$_REQUEST['username'];
		$packageid=$_REQUEST['packageid'];
		//$resTemp 	= mysql_query($query) or die(mysql_error());
		$query2	= "SELECT *  FROM `ta_users` Where `UserName` = '$username' ";
		$resTemp2 	= mysql_query($query2) or die(mysql_error());
		db_close();
		if(mysql_num_rows($resTemp2)>0)
		{
			$msg="username already exists";
		}
		else
		{
			$sql = "select MAX(`RefID`) as count  FROM `ta_users`";
			$resTemp3= mysql_query($sql);
			$temp3 = mysql_fetch_array($resTemp3);
			$refid=$temp3['count']+1;
			$sql = "INSERT INTO `ta_users` (`UserName`,`RefID`,`DT`) VALUES ('$username','$refid','$phpdate')";
			 mysql_query($sql);
			// $userid=mysql_insert_id();
			 $sql2 = "INSERT INTO `ta_user_subscriptions` (`UserName`,`PackageID`,`status`) VALUES ('$username','$packageid','Y')";
			 mysql_query($sql2);
			 $subid=mysql_insert_id();
			 $sql3 = "INSERT INTO `ta_subscription_details` (`subs_id`) VALUES ('$subid')";
			 mysql_query($sql3);
			 $msg="User inserted successfully";
		}
	}
	else
	{
	 		$msg="Please enter a twitter user name";
	}
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
<form name="frm1" method="POST" action="add_newuser.php" >
<table  border="0">
<tr>
    <td colspan="2" align="center"><?php echo $msg; ?></td>
</tr>
  <tr>
    <td>Twitter User Name: </td>
    <td>
	<input type="text" name="username" id="username" value="<?php echo $_REQUEST['username']; ?>" />
	</td>
  </tr>
   <tr>
    <td>Select Package: </td>
    <td>
   <?php
	 $query3	= " SELECT `packageName`,`packageID` FROM `ta_packages`";
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
		 &nbsp;</td>
		 </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center"><input type="submit" value="Submit"  name="submit" /></td>
  </tr>
</table>
</form>


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