<?php 
session_start();
include_once "../config/configoriginal.php";
include_once "../classes/dbClient.php";
include_once "../common/sqlFunctions.php";
if(isset($_SESSION["username"]) && ($_SESSION["username"] != "")){
	$username=$_SESSION["username"];
	$gid=$_REQUEST['id'];
$sql = "SELECT * FROM `ta_group` where groupOwner='$username' order by groupName asc ";
$Getgrouplist = runQuery($sql);	
}
else{
	Header("Location:../index");
}
if(isset($_REQUEST['deleteid']))
{
$deleteid=$_REQUEST['deleteid'];
$sqlsel = "SELECT * FROM `ta_group` where groupOwner='$username' and groupID='$deleteid'";
$Getgrouplist = runQuery($sqlsel);	
if($Getgrouplist[0]['groupImage']!="")
{
if(file_exists("origimg/".$Getgrouplist[0]['groupImage']))
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
}
$sqldel = "delete  FROM `ta_group` where groupOwner='$username' and groupID='$deleteid'";
$Getdeletelist = runQuery($sqldel);
$sql = "SELECT * FROM `ta_group` where groupOwner='$username' order by groupName asc ";
$Getgrouplist = runQuery($sql);	
//header("Location:index?act=5");		
}

// how many rows to show per page
 $rowsPerPage1 = 3;

 // by default we show first page
 $pageNum = 1;

 // if $_GET['page'] defined, use it as page number
 if(isset($_GET['page']))
 {
 $pageNum =$_GET['page'];
 }

 // counting the offset
$offset1 = ($pageNum - 1) * $rowsPerPage1;
  
 // how many rows we have in database
 $getNumRows=count($Getgrouplist);
// $getNumRows=@mysql_num_rows($getRec);
 $Limit="LIMIT $offset1, $rowsPerPage1";
 $sqlSelQueryLimit=$sql.$Limit;
 $Getgrouplist=runQuery($sqlSelQueryLimit);	
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
					<div><h1>My Groups</h1></div>
					<!-- Groups List box Start -->
					<div class="forms02">A list of all the groups that <b><?php echo $username; ?></b> is the owner of.</div>
					<div class="forms02">
					<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
					
						<div class="forms01">
							<div id="txtResult1">
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
									<div class="group_userdis"><a href="javascript: jQuery.facebox({ajax:'deletepopup.php?deleteid=<?php echo $Getgrouplist[$y]["groupID"]; ?>&groupname=<?php echo $Getgrouplist[$y]["groupName"];?>'});" class='basic'><img src="../images/close.png"/></a></div>
									<div class="group_userdis"><a href="editgrouplisting?egid=<?php echo $Getgrouplist[$y]["groupID"]; ?>" title="Edit The Group"><img src="../images/edit.png" /></a></div>
									<div class="clear"></div>
								</div>
								<!-- Group 01 End -->
								<?php }
										}
										else{
											echo "No Groups Found";
										}
										?>
							<?php
							// how many pages we have when using paging?
							 $maxPage = ceil($getNumRows/$rowsPerPage1);
							 // print the link to access each page
							// $self = $_SERVER['PHP_SELF'];
							$self="mygroups";
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
							 $nav .="<a href=\"javascript:htmlData1('mygrouptoppaging.php','un=$username','p=$page')\">$page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev ="<a href=\"javascript:htmlData1('mygrouptoppaging.php','un=$username','p=$page')\"> Prev</a>";
						
						
							 }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next = "<a href=\"javascript:htmlData1('mygrouptoppaging.php','un=$username','p=$page')\">Next</a>";
							
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
				
						<!-- Groups List box Start -->
						<br></br>
					<div class="forms02">A list of all the groups that <b><?php echo $username; ?></b> is a member of.</div>
					<div class="forms02">
					<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
						
							<div class="forms01">
							<div id="txtResult2">
									<?php
							$sqlmember = "SELECT distinct ta_group.groupID as groupID,ta_group.groupName as groupName,ta_group.groupImage as groupImage FROM `ta_group`,`ta_group_members` where ta_group_members.memberName='$username' and ta_group_members.groupID=ta_group.groupID order by groupName asc ";
							$memberlist = runQuery($sqlmember);	
							// how many rows to show per page
							 $rowsPerPage2 = 4;
							
							 // by default we show first page
							 $pageNum = 1;
							
							 // if $_GET['page'] defined, use it as page number
							 if(isset($_GET['page']))
							 {
							 $pageNum =$_GET['page'];
							 }
							
							 // counting the offset
							$offset2 = ($pageNum - 1) * $rowsPerPage2;
							  
							 // how many rows we have in database
							 $getNumRows=count($memberlist);
							// $getNumRows=@mysql_num_rows($getRec);
							 $Limit=" LIMIT $offset2, $rowsPerPage2";
							 $sqlSelmemberLimit=$sqlmember.$Limit;
							 $memberlist=runQuery($sqlSelmemberLimit);
							if(count($memberlist)>=1)
							{
							for($a=0;$a<count($memberlist);$a++){
							?>
												<!-- Group 01 Start -->
								<div class="group_userbox">
								    <div class="group_userthump"><a href="grouphome?id=<?php echo $memberlist[$a]['groupID'] ?>"><?php if($memberlist[$a]['groupImage']==""){?><img src="../images/user_photo.jpg" /><?php } else if (file_exists("thumbimg/".$memberlist[$a]['groupImage'])){?><img src="thumbimg/<?php echo $memberlist[$a]['groupImage']?>"><?php } else {?><img src="origimg/<?php echo $memberlist[$a]['groupImage']?>" border="0" /><?php }?></a></div>								
									<div class="group_username"><a href="grouphome?id=<?php echo $memberlist[$a]['groupID'] ?>"><?php echo $memberlist[$a]["groupName"];?></a></div>
									<div class="group_userdis">
									<?php 
									$groupid=$memberlist[$a]["groupID"];
									$membercountqry = "SELECT count(*) as count FROM `ta_group_members` WHERE groupID='$groupid'";
									$membercountre = runQuery($membercountqry);	
									?>
									<?php 
      							  echo $membercountre[0][count];
       							  if($membercountre[0][count]==1) {echo " Member";} else {echo " Members";} ?></div>
							    	<div class="clear"></div>
								</div>
								<!-- Group 01 End -->
								<?php }
										}
										else{
											echo "No Groups Found";
										}
										
										// how many pages we have when using paging?
							 $maxPage = ceil($getNumRows/$rowsPerPage2);
							 // print the link to access each page
							// $self2 = $_SERVER['PHP_SELF'];
							 $self2="mygroups";
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
							 $nav .="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$username','p=$page')\">$page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev ="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$username','p=$page')\">Prev</a>";
														
							 }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next ="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$username','p=$page')\">Next</a>";
							
							
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