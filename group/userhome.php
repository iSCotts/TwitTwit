<?php 
session_start();
include_once "../config/configoriginal.php";
include_once "../classes/dbClient.php";
include_once "../common/sqlFunctions.php";
if(isset($_SESSION["username"]) && ($_SESSION["username"] != "")){
	$username=$_SESSION["username"];
	$gid=$_REQUEST['id'];
	$memberid=$_REQUEST['membid'];
	
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
if(isset($_REQUEST["act"]) && ($_REQUEST["act"]==5)){
$ErrorMessage = "You have joined in the group";
}
if(isset($_REQUEST["act"]) && ($_REQUEST["act"]==6)){
$ErrorMessage = "You are already exists in this group";
}
if(isset($_REQUEST["act"]) && ($_REQUEST["act"]==7)){
$ErrorMessage = "The user has been removed from the group";
}
 
?>
<?php  include "../includes/header.php"; ?>	
<script type="text/javascript" src="../js/jquery1.js"></script>
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_group">
				<!-- Middle Contents Start -->
				
				<!-- Middle Left Start -->
				<div class="middle_groupleft">
					<div><h1>User Information</h1></div>
					<?php
				// get the friends details 	
					$sql = "select U.RefID,UK.*,U.UserID from ta_user_keys UK inner join ta_users U on U.UserName=UK.Username where UK.Username='{$username}'";
					//$sql = "select U.RefID,UK.*,U.UserID from ta_user_keys UK inner join ta_users U on U.UserName=UK.Username inner join ta_group_members GM on U.UserName=GM.memberName  where UK.Username='{$username}'";
					$getIDs= runQuery($sql);
					if ($getIDs[0]['type'] == 'no') {
					include ('../classes/twitteroauth.php');
					$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $getIDs[0]['key'], $getIDs[0]['secretkey']);
					}
					elseif ($getIDs[0]['type'] == 'yes') {
						include ('../classes/class.twitter.php');
						$summize = new summize($username, $getIDs[0]['secretkey']);
					}
					$sqlselect="select * from ta_group_follow_log where userfollow='$username' or  userTofollow='$username'";
					$insertcont = runQuery($sqlselect);
					$friends=array ();
					for ($i = 0; $i < count($insertcont); $i++) {
					if($insertcont[$i]['userTofollow']!="")
					{
					array_push($friends, $insertcont[$i]['userTofollow']);
					array_push($friends, $insertcont[$i]['userfollow']);
						}
					}
					//end get friends details
					$membersql="SELECT ta_group_member_profile.profileImage as profileImage,ta_group_member_profile.profileDesc as profileDesc,ta_group_member_profile.memberLocation as memberLocation,ta_group_member_profile.memberName FROM `ta_group_members`,`ta_group_member_profile` where ta_group_members.memberName=ta_group_member_profile.memberName  and ta_group_members.memberID='$memberid'";
					$Getmemberlist = runQuery($membersql);
					$membername=$Getmemberlist[0]["memberName"];
					?>
					<div class="middle_groupuser">
						<div class="middle_groupuserimg"><a href="#"><?php if($Getmemberlist[0]['profileImage']==""){?><img src="../images/user_photo.jpg" width="56px"  height="56px" /><?php } else{?><img width="56px" height="56px" src="<?php echo $Getmemberlist[0]['profileImage'];?>"  /><?php }?></a></div>
						<div class="middle_groupuserh"><?php echo $Getmemberlist[0]["memberName"];?></div>
						<?php
							//check whether the user is the member of the group
							if($username!=$Getmemberlist[0]["memberName"]) 
							{
							//start block or unblock user
							$blkeduser="select * from ta_block_user where blockedby='$username' and blockeduser='{$Getmemberlist[0]["memberName"]}'";
						    $Getblockedlist = runQuery($blkeduser);
						     	if(count($Getblockedlist)==0)
							{
								if (in_array($Getmemberlist[0]["memberName"], $friends)) {
								$val = "onclick=\"groupfollowstatus('remove','{$getIDs[0]['Username']}','follow{$Getmemberlist[0]["memberName"]}','{$Getmemberlist[0]["memberName"]}');\"";
								$followstatus = "<a {$val} title=\"Click to Unfollow {$Getmemberlist[0]["memberName"]}\"><img src=\"../images/remove-user.png\" alt=\"\" /></a>";
						     	} else {
								$val = "onclick=\"groupfollowstatus('follow','{$getIDs[0]['Username']}','follow{$Getmemberlist[0]["memberName"]}','{$Getmemberlist[0]["memberName"]}');\"";
								$followstatus = "<a {$val} title=\"Click to Follow {$Getmemberlist[0]["memberName"]}\"><img src=\"../images/add_user.png\" alt=\"\" /></a>";
							    }
							}
							else{
								$followstatus="";
							}
						  	if(isset($Getblockedlist[0]["blockedby"])){
								
							$bresl="<a onclick=\"groupblockuser('unblock','follow','{$getIDs[0]['Username']}','block{$Getmemberlist[0]["memberName"]}','follow{$Getmemberlist[0]["memberName"]}','{$Getmemberlist[0]["memberName"]}','$gid');\"  title=\"Click to unblock {$Getmemberlist[0]["memberName"]}\">unblock</a>";
							 }else{
							$bresl="<a onclick=\"groupblockuser('block','remove','{$getIDs[0]['Username']}','block{$Getmemberlist[0]["memberName"]}','follow{$Getmemberlist[0]["memberName"]}','{$Getmemberlist[0]["memberName"]}','$gid');\"  title=\"Click to block {$Getmemberlist[0]["memberName"]}\"><img src=\"../images/pause-user.png\" alt=\"\" /></a>";
							 }
						 //end block or unblock user 
							 ?>
						<div class="middle_groupuserlink">
							<!-- <a href="#"><img src="../images/add_user.png" alt="Follow This User" title="Follow This User" /></a>
							<a href="#"><img src="../images/remove-user.png" alt="Unfollow This User" title="Unfollow This User" /></a>
							<a href="#"><img src="../images/pause-user.png" alt="Block This User" title="Block This User" /></a>
							-->
							<span id="<?php  echo follow.$Getmemberlist[0]["memberName"]; ?>"><?php echo $followstatus; ?></span><span id="<?php  echo block.$Getmemberlist[0]["memberName"]; ?>"><?php echo $bresl; ?></span>
						</div>
						<?php } else{?>
						<div class="middle_groupuserlink"></div>
						<?php }?>
						<div class="clear"></div>
					</div>
					
					<div class="forms02">
					    <p><?php if($Getmemberlist[0]["memberLocation"]!=""){?>Location : <?php echo $Getmemberlist[0]["memberLocation"]; }?></p>
						<p><?php if($Getmemberlist[0]["profileDesc"]!=""){?><?php echo $Getmemberlist[0]["profileDesc"]; }?></p>
						<?php 
						$membername=$Getmemberlist[0]["memberName"];
						$selectqry="select * from ta_block_user where blockeduser='$membername'";
						$Getblockedlist = runQuery($selectqry);
						$blockedcount=count($Getblockedlist);
						?>
						<p><?php echo $blockedcount; ?> users have blocked</p>
					</div>
					
					<!-- Groups List box Start -->
					<div class="forms03">
						<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
							<div class="forms01"><h5>Groups</h5></div>
							<div class="forms02">A list of all the groups that you are a member of.</div>
						<div class="forms02">	
							<div id="txtResult">	
								<?php
								$sqlmember = "SELECT distinct ta_group.groupID as groupID,ta_group.groupName as groupName,ta_group.groupImage as groupImage FROM `ta_group`,`ta_group_members` where ta_group_members.memberName='$membername' and ta_group_members.groupID=ta_group.groupID";
								$memberlist = runQuery($sqlmember);	
								// how many rows to show per page
								 $rowsPerPage = 6;
								
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
								 $getNumRows=count($memberlist);
								 $Limit=" LIMIT $offset, $rowsPerPage";
								 $sqlSelQueryLimit=$sqlmember.$Limit;
								 $Getmemberlist=runQuery($sqlSelQueryLimit);
								if(count($Getmemberlist)>=1)
								{
								for($a=0;$a<count($Getmemberlist);$a++){
									?>
						
								<!-- Group 01 Start -->
								<div class="group_userbox">
								<div class="group_userthump"><a href="grouphome?id=<?php echo $Getmemberlist[$a]['groupID'] ?>"><?php if($Getmemberlist[$a]['groupImage']==""){?><img src="../images/user_photo.jpg" /><?php } else if (file_exists("thumbimg/".$Getmemberlist[$a]['groupImage'])){?><img src="thumbimg/<?php echo $Getmemberlist[$a]['groupImage']?>"><?php } else {?><img src="origimg/<?php echo $Getmemberlist[$a]['groupImage']?>" border="0" /><?php }?></a></div>
								<div class="group_username"><a href="grouphome?id=<?php echo $Getmemberlist[$a]['groupID'] ?>"><?php echo $Getmemberlist[$a]["groupName"] ?></a></div>
									<div class="group_userdis">
										<?php 
										$groupid=$Getmemberlist[$a]["groupID"];
										$membercountqry = "SELECT count(*) as count FROM `ta_group_members` WHERE groupID='$groupid'";
										$membercountre = runQuery($membercountqry);	
										echo $membercountre[0][count];
       									if($membercountre[0][count]==1) {echo " member";} else {echo " members";} ?>
									</div>
									<div class="clear"></div>
								</div>
								<?php }
										}
										else{
											echo "No Groups Found";
										}
											?>
								<!-- Group 01 End -->
									<div class="paging">
							<?php 
							// how many pages we have when using paging?
							 $maxPage = ceil($getNumRows/$rowsPerPage);
							 // print the link to access each page
							 //$self = $_SERVER['PHP_SELF'];
							 $self = "grouphome";
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
							 $nav .= "<a href=\"javascript:htmlData('userhomepaging.php','un=$membername','p=$page')\"> $page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev = " <a href=\"javascript:htmlData('userhomepaging.php','un=$membername','p=$page')\">Prev</a>";
							
							 $first = "<a href=\"javascript:htmlData('userhomepaging.php','un=$membername','p=1')\">[First Page]</a>";
							 }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next = " <a href=\"javascript:htmlData('userhomepaging.php','un=$membername','p=$page')\">Next</a>";
							
							 $last = " <a href=\"javascript:htmlData('userhomepaging.php','un=$membername','p=$maxPage')\">[Last Page]</a>";
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
							</div>
							</div>
						<div class="group_userbxbtm"><div class="clear"></div></div>
					</div>
					<!-- Groups List box End -->
				</div>
					  <?php include "leftlink.php"; ?>	
				<div class="clear"></div>
				<!-- Middle Contents End -->
			</div>
		</div>
		</div>
		<!-- Middle Content Area End -->
	
	<?php include "../includes/footer.php"; ?>	
