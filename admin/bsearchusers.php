<?php ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
?>
<script type="text/javascript">
var xmlHttp;
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function  confirmactiveuser(uid,uk,stat)
{

	 if (confirm("Are you sure you want to Activate the user?")) {
		   // document.location = "Managecampaign.php?d="+cid+"";

			// call ajax
				 xmlHttp=GetXmlHttpObject();
				if (xmlHttp==null)
				  {
				  alert ("Browser does not support HTTP Request");
				  return;
				  }
				var url="banusers.php";
				url=url+"?Do=Save&d="+uid+"&uk="+uk+"&status="+stat+"";
				xmlHttp.onreadystatechange=stateChangedconfirmbanuser;
				xmlHttp.open("POST",url,true);
				xmlHttp.send(null);	   
	  }
}
function  confirmbanuser(uid,uk,ban)
{

	 if (confirm("Are you sure you want to ban the user?")) {
		   // document.location = "Managecampaign.php?d="+cid+"";

			// call ajax
				 xmlHttp=GetXmlHttpObject();
				if (xmlHttp==null)
				  {
				  alert ("Browser does not support HTTP Request");
				  return;
				  }
				var url="banusers.php";
				url=url+"?Do=Save&d="+uid+"&uk="+uk+"&status="+ban+"";
				xmlHttp.onreadystatechange=stateChangedconfirmbanuser;
				xmlHttp.open("POST",url,true);
				xmlHttp.send(null);	   
	  }
}
function stateChangedconfirmbanuser()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	//window.location =xmlHttp.responseText;
	window.location.reload();
	 }
}
function confirmDelete(uid) {
	  if (confirm("Are you sure you want to delete")) {
	   // document.location = "Managecampaign.php?d="+cid+"";

		// call ajax
			 xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Browser does not support HTTP Request");
			  return;
			  }
			var url="deleteusers.php";
			url=url+"?Do=Save&d="+uid+"";
			//			document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  ="Adding the account";
			xmlHttp.onreadystatechange=stateChangedconfirmDelete;
			xmlHttp.open("POST",url,true);
			xmlHttp.send(null);
	   
	  }
	}

function stateChangedconfirmDelete()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	window.location.reload();
		}
}
</script>
<script type="text/javascript">
function ShowUsersrecords()
{
	 var userkey = document.getElementById("name1").value;
	window.location="bsearchusers.php?uk="+userkey+"";
	}
</script>
<script type="text/javascript" src="search.js"></script>
<script type='text/javascript' src='autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="autocomplete.css" />
<script type='text/javascript' src='searchFollow.js'></script>
<td height="380" align="center" valign="top">

<table  align="center" cellpadding="2" cellspacing="2" width="100%" border="1">

 

 
<tr align="center"><td colspan="7"><strong>Search Users</strong></td></tr>

<tr  align="center"><td colspan="7">Users<input type="text" name="name1" id="name1"   onkeyup="ShowUsersList(this.value);"></input>
<div id="usersListDiv"></div><input type="button" name="Go" value="Go" onclick="ShowUsersrecords();"></input></td></tr>

 
 <?php 
 if(isset($_REQUEST["uk"]) && $_REQUEST["uk"]!= "" )
 { 	
 	//get all user related with these keyword 
 	 			// how many rows to show per page
				$rowsPerPage = 10;
				
				// by default we show first page
				$pageNum = 1;
				
				// if $_GET['page'] defined, use it as page number
				if(isset($_GET['page']))
				{
					$pageNum =$_GET['page'];								
				}
		$offset = ($pageNum - 1) * $rowsPerPage;
    	$sqlSelect="SELECT * FROM ta_users WHERE UserName LIKE '$_REQUEST[uk]%'";
		$getRec = runQuery($sqlSelect);
		$getNumRows=count($getRec);
		$Limit="LIMIT $offset, $rowsPerPage";
		$sqlSelQueryLimit=$sqlSelect.$Limit;
		$result=runQuery($sqlSelQueryLimit); 
		$userListCount=count($result);
 ?>
<tr>
<td><strong>Sl No</strong></td>
<td><strong>User Name</strong></td>
<td><strong>Email</strong></td>
<td><strong>Status</strong></td>
 <td><strong>View</strong></td>
<td><strong>Delete</strong></td>
<td><strong>Ban/Activate User</strong></td>
</tr>
<?php 
 if($userListCount==0){
	echo "<tr><td colspan=7>NO USERS</td></tr>";
}else{
for($i=0;$i<$userListCount;$i++){
	?>
	<tr>
<td> <?php echo $i+1; ?></td>
<td> <?php echo $result[$i]['UserName']; ?></td>
<td> <?php echo $result[$i]['Email']; ?></td>
<td><?php if($result[$i]['ACStatus']=="P") echo "Active";  if($result[$i]['ACStatus']=="B") echo "Banned";   ?></td>
<td><a  href="javascript: jQuery.facebox({ajax:'viewcampaignusinguserid.php?id=<?php echo $result[$i]['UserID'] ?>'});" >View</a></td>
<td> <a   onclick="javascript:confirmDelete('<?php  echo $result[$i]['UserID']; ?>')">Delete</a></td>
<td><?php if($result[$i]['ACStatus']=='P'){?> <a  onclick="javascript:confirmbanuser('<?php    echo $result[$i]['UserID']; ?>','<?php  echo $_REQUEST["uk"]; ?>','<?php  echo "B" ?>')">Ban User</a><?php } if($result[$i]['ACStatus']=='B') {?><a onclick="javascript:confirmactiveuser('<?php    echo $result[$i]['UserID']; ?>','<?php  echo $_REQUEST["uk"]; ?>','<?php  echo "P" ?>')">Activate</a><?php  } ?></td>
</tr>
	<?php 
} 
						// how many pages we have when using paging?
						$maxPage = ceil($getNumRows/$rowsPerPage);
						
						// print the link to access each page
						$self = $_SERVER['PHP_SELF'];
						$nav  = '';
						
						for($page =$pageNum;$page<=$pageNum+3;$page++)
						{
						if($page<=$maxPage)
						{
						if ($page == $pageNum)
						{
						$nav .= " $page "; // no need to create a link to current page
						}
						else
						{
						$nav .= " <a href=\"$self?page=$page&uk=$_REQUEST[uk]\">$page</a> ";
						} 
						}
						}
						// creating previous and next link
						// plus the link to go straight to
						// the first and last page
						
						if ($pageNum > 1)
						{
						$page  = $pageNum - 1;
						$prev  = " <a href=\"$self?page=$page&uk=$_REQUEST[uk]\">[Prev]</a>";
						
						$first = " <a href=\"$self?page=1&uk=$_REQUEST[uk]\">[First Page]</a>";
						} 
						else
						{
						$prev  = '&nbsp;'; // we're on page one, don't print previous link
						$first = '&nbsp;'; // nor the first page link
						}
						
						if ($pageNum < $maxPage)
						{
						$page = $pageNum + 1;
						$next = " <a href=\"$self?page=$page&uk=$_REQUEST[uk]\">[Next]</a>";
						
						$last = " <a href=\"$self?page=$maxPage&uk=$_REQUEST[uk]\">[Last Page]</a>";
						} 
						else
						{
						$next = '&nbsp;'; // we're on the last page, don't print next link
						$last = '&nbsp;'; // nor the last page link
						}
			
						// print the navigation link
						echo "<tr><td colspan=7><b>". $first . $prev . $nav . $next . $last."</b></td></tr>";
}
 }
?>
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
 