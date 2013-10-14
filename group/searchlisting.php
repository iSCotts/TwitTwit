<?php 
session_start();
include_once "../config/configoriginal.php";
include_once "../classes/dbClient.php";
include_once "../common/sqlFunctions.php";
if(isset($_SESSION["username"]) && ($_SESSION["username"] != "")){
	$username=$_SESSION["username"];
	$gid=$_REQUEST['id'];
	$sql = "SELECT * FROM `ta_group` where groupID='$gid'";
	$Getgrouplist = runQuery($sql);	
/*$membersql="SELECT * FROM `groupMember` where groupID='$gid'";
$Getmemberlist = runQuery($membersql);*/	
}
else{
	Header("Location:../index");
}
if(isset($_REQUEST['deleteid']))
{
	$deleteid=$_REQUEST['deleteid'];
	$sql = "SELECT * FROM `ta_group` where groupOwner='$username' and groupID='$deleteid'";
	$Getgrouplist = runQuery($sql);	
	if($Getgrouplist[0]['groupImage']!="")
	{
		if(file_exists("origimg/".$Getgrouplist[0]['groupImage']))
		{
		unlink("origimg/".$Getgrouplist[0]['groupImage']);
		}
		if(file_exists("mediumimg/".$Getgrouplist[0]['groupImage']))
		{
		unlink("mediumimg/".$Getgrouplist[0]['groupImage']);
		}
		if(file_exists("thumbimg/".$Getgrouplist[0]['groupImage']))
		{
		unlink("thumbimg/".$Getgrouplist[0]['groupImage']);
		}
	}
	$sql = "delete  FROM `ta_group` where groupOwner='$username' and groupID='$deleteid'";
	$Getdeletelist = runQuery($sql);
	//echo $sql;
	//exit;
	//header("Location:searchlisting?searchtext=$searchtxt");		
	//header("Location:index?act=5");		
}
if(isset($_REQUEST['searchtext']))
{
	$searchtxt=$_REQUEST['searchtext'];
	$sqlsearch = "SELECT * FROM `ta_group` where groupName like '%$searchtxt%'";
	$Getgrouplist = runQuery($sqlsearch);	
}
else{
    $sqlsearch = "SELECT * FROM `ta_group` ";
	$Getgrouplist = runQuery($sqlsearch);		
}
 
// how many rows to show per page
 $rowsPerPage = 9;

 // by default we show first page
 $pageNum = 1;

 // if $_GET['page'] defined, use it as page number
 if(isset($_GET['page']))
 {
 $pageNum =$_GET['page'];
 }

 // counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
  
// $sqlSelect="select * from tbl_product ";
 //$getRec=@mysql_query($sqlSelect,$db);

 // how many rows we have in database
 $getNumRows=count($Getgrouplist);
// $getNumRows=@mysql_num_rows($getRec);
 $Limit="LIMIT $offset, $rowsPerPage";
 $sqlSelQueryLimit=$sqlsearch.$Limit;
 $Getgrouplist=runQuery($sqlSelQueryLimit);	
 //$result=@mysql_query($sqlSelQueryLimit,$db);
 //echo $sqlSelQueryLimit;
 ?> 
<?php  include "../includes/header.php"; ?>	
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_group">
				<!-- Middle Contents Start -->
				
				<!-- Middle Left Start -->
				<div class="middle_groupleft">
					<div><?php if($searchtxt!=""){?><h1>Search results for "<?php echo $searchtxt; ?>"</h1><?php } ?></div>
					<!-- Groups List box Start -->
					<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
				
							<div class="forms01">
								<div id="txtResult">
								<?php 
								if(count($Getgrouplist)>=1)
									{
									for($y=0;$y<count($Getgrouplist);$y++){
									?>
								<!-- Group 01 Start -->
								<div class="group_userbox">
									<div class="group_userthump"><a href="grouphome?id=<?php echo $Getgrouplist[$y]['groupID'] ?>"><?php if($Getgrouplist[$y]['groupImage']==""){?><img src="../images/user_photo.jpg" /><?php } else if (file_exists("thumbimg/".$Getgrouplist[$y]['groupImage'])){?><img src="thumbimg/<?php echo $Getgrouplist[$y]['groupImage']?>"><?php } else {?><img src="origimg/<?php echo $Getgrouplist[$y]['groupImage']?>" border="0" /><?php }?></a></div>
									<div class="group_username"><a href="grouphome?id=<?php echo $Getgrouplist[$y]['groupID'] ?>"><?php echo $Getgrouplist[$y]["groupName"];?></a></div>
									<div class="group_userdis">
									<?php 
									$groupid=$Getgrouplist[$y]["groupID"];
									$membercountqry = "SELECT count(*) as count FROM `ta_group_members` WHERE groupID='$groupid'";
									$membercountre = runQuery($membercountqry);	
									?>
									<?php 
      							  echo $membercountre[0][count];
       							  if($membercountre[0][count]==1) {echo " Member";} else {echo " Members";} ?>
									</div>
									<div class="group_userdis"><?php if($Getgrouplist[$y]["groupOwner"]==$username){?><a href="javascript: jQuery.facebox({ajax:'deletepopup.php?deleteid=<?php echo $Getgrouplist[$y]["groupID"]; ?>&searchtext=<?php echo $searchtext;?>'});" class='basic' title="Delete the Group"><img src="../images/close.png"/></a><?php }?></div>
									
									<div class="group_userdis"><?php if($Getgrouplist[$y]["groupOwner"]==$username){?><a href="editgrouplisting?egid=<?php echo $Getgrouplist[$y]["groupID"]; ?>" title="Edit the Group"><img src="../images/edit.png" /></a><?php }?></div>
									<div class="clear"></div>
								</div>
								<!-- Group 01 End -->
								<?php }
										}
										else{
											echo "No Results Found";
										}
										?>
										<?php
							// how many pages we have when using paging?
							 $maxPage = ceil($getNumRows/$rowsPerPage);
							 // print the link to access each page
							 $self = $_SERVER['PHP_SELF'];
							 $nav = '';
							
							 for($page =$pageNum;$page<=$pageNum+3;$page++)
							 {
							 if($page<=$maxPage)
							 {
							 if ($page == $pageNum)
							 {
							 $nav .= " <span class='current'>$page</span> "; // no need to create a link to current page
							 }
							 else
							 {
							 $nav .= "<a href=\"javascript:htmlDatasrch('searchpaging.php','searchtext=$searchtxt','p=$page')\">$page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev = "<a href=\"javascript:htmlDatasrch('searchpaging.php','searchtext=$searchtxt','p=$page')\">Prev</a>";
												
							 }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next = "<a href=\"javascript:htmlDatasrch('searchpaging.php','searchtext=$searchtxt','p=$page')\">Next</a>";
													 
							 }
							 else
							 {
							 $next = '&nbsp;'; // we're on the last page, don't print next link
							 $last = '&nbsp;'; // nor the last page link
							 }
							
							 // print the navigation link
							 
							 ?>
								<div class="paging">
							<?php echo  $prev . $nav . $next ; ?>
								</div>
							</div>
							</div>
						</div>
						<div class="group_userbxbtm"><div class="clear"></div></div>
					</div>
					<!-- Groups List box End -->
				</div>
				<!-- Middle Left Start -->
             <?php include "leftlink.php"; ?>	
				<div class="clear"></div>
				<!-- Middle Contents End -->
			</div>
		<!-- Middle Content Area End -->
	<?php include "../includes/footer.php"; ?>	