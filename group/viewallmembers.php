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
	unlink("origimg/".$Getgrouplist[0]['groupImage']);
	unlink("mediumimg/".$Getgrouplist[0]['groupImage']);
	unlink("thumbimg/".$Getgrouplist[0]['groupImage']);
}
$sql = "delete  FROM `ta_group` where groupOwner='$username' and groupID='$deleteid'";
$Getdeletelist = runQuery($sql);
header("Location:index?act=5");		
}
?>      
<?php include "../includes/header.php"; ?>	
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_group">
				<!-- Middle Contents Start -->
				
				<!-- Middle Left Start -->
				<div class="middle_groupleft">
					<div><h1>Twitacc Group</h1></div>
					
					<div class="middle_groupuser">
						<div class="middle_grouphomeimg"><?php if($Getgrouplist[0]['groupImage']==""){?><img src="../images/user_photo.jpg" width="60"  height="60" /><?php } else{?><img src="mediumimg/<?php echo $Getgrouplist[0]['groupImage']?>" /><?php }?></div>
						<div class="middle_grouphomeh"><?php echo $Getgrouplist[0]["groupName"];?></div>
						<div class="middle_grouphomelink">
							<div>
							<?php
							$membersql="SELECT * FROM `ta_group_members` where groupID='$gid' and  memberName='$username'";
							$Getmemberlist = runQuery($membersql);
							if(count($Getmemberlist)>=1)
							{	
							?>
								<a href="groupmember?leaveid=<?php echo $Getmemberlist[0]["memberID"]; ?>&id=<?php echo $Getmemberlist[0]["groupID"]; ?>" title="Leave The Group">Leave</a> |
								<?php 
								}else{
								?> 
								<a href="groupmember?groupid=<?php echo $Getgrouplist[0]["groupID"]; ?>" title="Leave The Group">Join</a> |
								<?php }?>
								<a href="#" title="Promote The Group">Promote</a>
								<?php if($Getgrouplist[0]["groupOwner"]==$username){?> | <a href="grouphome?deleteid=<?php echo $Getgrouplist[0]["groupID"]; ?>" title="Delete The Group">Delete</a><?php } ?>
								</div>
							<div class="middle_grouphomemember">
							<?php 
							$groupid=$Getgrouplist[0]["groupID"];
							$membercountqry = "SELECT count(*) as count FROM `ta_group_members` WHERE groupID='$groupid'";
							$membercountre = runQuery($membercountqry);	
							echo $membercountre[0][count];
					        if($membercountre[0][count]==1) {echo " Member";} else {echo " Members";} ?></div>
						</div>
						<div class="clear"></div>
					</div>
					
					<div class="forms02">
						<p><?php print $Getgrouplist[0]["groupDescription"] ?></p>
						<p>
							<br />Owner : <strong><?php echo $Getgrouplist[0]["groupOwner"];?></strong><br />
							Created on : <strong><?php echo date("d-m-Y", strtotime($Getgrouplist[0]["groupCreatedate"]));?></strong>
						</p>
					</div>
								
					<!-- All Members List box Start -->
					<div class="forms02">
						<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
							<div class="forms01"><h5>Members</h5></div>
							<?php
					$sqlmemberlist = "SELECT ta_group_member_profile.profileImage as profileImage,ta_group_members.memberID as memberID,ta_group_member_profile.memberName as memberName FROM `ta_group_members`,`ta_group_member_profile`  where ta_group_members.memberName=ta_group_member_profile.memberName and ta_group_members.groupID='$groupid' order by ta_group_member_profile.memberName asc";
					$Getmemberlist = runQuery($sqlmemberlist);
					// how many rows to show per page
					 $rowsPerPage = 12;
					
					 // by default we show first page
					 $pageNum = 1;
					
					 // if $_GET['page'] defined, use it as page number
					 if(isset($_GET['page']))
					 {
					 $pageNum =$_GET['page'];
					 }
					
					 // counting the offset
					$offset = ($pageNum - 1) * $rowsPerPage;
					  // how many rows we have in database
					 $getNumRows=count($Getmemberlist);
					 $Limit=" LIMIT $offset, $rowsPerPage";
					 $sqlSelQueryLimit=$sqlmemberlist.$Limit;
					 $Getmemberlist=runQuery($sqlSelQueryLimit);	
					 ?> 
							<div class="group_userallmembers">
								<ul>
							<?php 
							if(count($Getmemberlist)>=1)
							{
							for($b=0;$b<count($Getmemberlist);$b++){
									?>
									<!-- Member area box 01 Start -->
									<li>
										<div class="allmembers">
											<div class="group_userthump01"><a href="userhome?membid=<?php echo $Getmemberlist[$b]["memberID"] ?>"><img src="<?php print $Getmemberlist[$b]["profileImage"]?>" alt="" /></a></div>
											<div class="group_userthumpname"><a href="userhome?membid=<?php echo $Getmemberlist[$b]["memberID"] ?>"><?php print $Getmemberlist[$b]["memberName"] ?></a></div>
											<div class="middle_userthumplink">
												<a href="#"><img src="../images/add_user.png" alt="Follow This User" title="Follow This User" /></a>
												<a href="#"><img src="../images/remove-user.png" alt="Unfollow This User" title="Unfollow This User" /></a>
											</div>
											<div class="clear"></div>
										</div>
									</li>
									<!-- Member area box 01 Start -->
							<?php 	
							 }
							}?>

								</ul>
								<div class="clear"></div>
							</div>
							<div class="paging">
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
							 $nav .= " $page "; // no need to create a link to current page
							 }
							 else
							 {
							 $nav .= " <a href=\"$self?page=$page\">$page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev = " <a href=\"$self?page=$page\">Prev</a>";
							
							 $first = " <a href=\"$self?page=1\">[First Page]</a>";
							 }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next = " <a href=\"$self?page=$page\">Next</a>";
							
							 $last = " <a href=\"$self?page=$maxPage\">[Last Page]</a>";
							 }
							 else
							 {
							 $next = '&nbsp;'; // we're on the last page, don't print next link
							 $last = '&nbsp;'; // nor the last page link
							 }
							
							 // print the navigation link
							 
							 ?>
								<?php echo  $prev . $nav . $next ; ?>
							</div>
						</div>
						<div class="group_userbxbtm"><div class="clear"></div></div>
					</div>
					<!-- All Members List box End -->
				</div>
				<!-- Middle Left Start -->
				<?php include("leftlink.php");?>			
				<div class="clear"></div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
	
	<?php include "../includes/footer.php"; ?>	
