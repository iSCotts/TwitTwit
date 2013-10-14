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
	$_SESSION['pageurl']= $_SERVER['REQUEST_URI'];
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
$ErrorMessage = "You have joined in this group";
}
if(isset($_REQUEST["act"]) && ($_REQUEST["act"]==6)){
$ErrorMessage = "You are already exists in this group";
}
if(isset($_REQUEST["act"]) && ($_REQUEST["act"]==7)){
$ErrorMessage = "You have left from this group";
}
/*if(isset($_REQUEST['searchtext']))
{
$searchtxt=$_REQUEST['searchtext'];
$sql = "SELECT * FROM `ta_group` where groupName like '%$searchtxt%'";
$Getgrouplist = runQuery($sql);	
}*/
   
?>
<?php  include "../includes/header.php"; ?>	
<!--<script type="text/javascript" src="../js/jquery1.js"></script>
-->	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_group">
				<!-- Middle Contents Start -->
				
				<!-- Middle Left Start -->
				<div class="middle_groupleft">
				<div style="color:#c19700;padding-left:185px; "><b><?php echo $ErrorMessage; ?></b></div>
					<div><h1>Twitacc Group</h1></div>
					<?php  if($Getgrouplist[0]["groupOwner"]!=""){?>
					<div class="middle_groupuser">
					<div class="middle_grouphomeimg"><?php if($Getgrouplist[0]['groupImage']==""){?><img src="<?php echo IMG_PATH."user_photo.jpg";?>"  width="60"  height="60" /><?php } else if (file_exists("mediumimg/".$Getgrouplist[0]['groupImage'])){?><img src="mediumimg/<?php echo $Getgrouplist[0]['groupImage']?>"><?php } else {?><img src="origimg/<?php echo $Getgrouplist[0]['groupImage']?>" border="0" /><?php }?></div>
					
						<div class="middle_grouphomeh"><?php echo stripslashes($Getgrouplist[0]["groupName"]);?></div>
						<div class="middle_grouphomelink">
							<div>
							<?php
						    if($Getgrouplist[0]["groupOwner"]!=$username)
						    {
							$membersql="SELECT * FROM `ta_group_members` where groupID='$gid' and  memberName='$username'";
							$Getmemberlist = runQuery($membersql);
							if(count($Getmemberlist)>=1)
							{	
							?>
								<a href="groupmember?leaveid=<?php echo $Getmemberlist[0]["memberID"]; ?>&id=<?php echo $Getmemberlist[0]["groupID"]; ?>" title="Leave The Group">Leave</a> |
								<?php 
								}else{
								?> 
								<a href="groupmember?groupid=<?php echo $Getgrouplist[0]["groupID"]; ?>" title="Join The Group">Join</a> |
								<?php }
								}?>
								<a href="promotegroup.php" title="Promote The Group">Promote</a>
								<?php if($Getgrouplist[0]["groupOwner"]==$username){?> | <a href="javascript:jQuery.facebox({ajax:'deletepopup.php?deleteid=<?php echo $Getgrouplist[0]["groupID"]; ?>&groupname=<?php echo $Getgrouplist[0]["groupName"];?>'});" title="Delete The Group">Delete</a> | <a href="editgrouplisting?egid=<?php echo $Getgrouplist[0]["groupID"]; ?>" title="Edit The Group">Edit</a><?php } ?>
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
						<p><?php echo stripslashes($Getgrouplist[0]["groupDescription"]); ?></p>
						<p>
							<br />Owner : <strong><?php echo $Getgrouplist[0]["groupOwner"];?></strong><br />
							Created on : <strong><?php 
					        $getdate=explode("-",$Getgrouplist[0]["groupCreatedate"]);
					        $year=$getdate[0];
					        $day=$getdate[2];
					        $month=date("F",mktime(0,0,0,$getdate[1],2));
					        echo $month." ". $day.", ".$year;
							//echo date("d-m-Y", strtotime($Getgrouplist[0]["groupCreatedate"]));?></strong>
						</p>
					</div>
					
					<!-- latest members List box Start -->
					<div class="forms02">
						<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
							<div class="forms01"><h5>Latest members</h5></div>
							<div class="group_userlatest">
							<?php
						$sqlmember = "SELECT ta_group_member_profile.profileImage as profileImage,ta_group_members.memberID as memberID,ta_group_member_profile.memberName as memberName FROM `ta_group_members`,`ta_group_member_profile` where ta_group_members.memberName=ta_group_member_profile.memberName and ta_group_members.groupID='$groupid' ORDER BY memberID DESC  limit 5";
						$latestmemberlist = runQuery($sqlmember);	
						?>
							<ul>
							<?php 
								if(count($latestmemberlist)>=1)
								{
								for($a=0;$a<count($latestmemberlist);$a++){
									?>
							
									<li>
										<div class="group_homethump"><a href="userhome?membid=<?php echo $latestmemberlist[$a]["memberID"] ?>"><img src="<?php print $latestmemberlist[$a]["profileImage"]?>" alt="" /></a></div>
										<div class="group_homename"><a href="userhome?membid=<?php echo $latestmemberlist[$a]["memberID"] ?>"><?php print $latestmemberlist[$a]["memberName"] ?></a></div>
									</li>
								<?php }
									}
									else{
											echo "No Members Found";
										}
									?>
								</ul>
								<div class="clear"></div>
							</div>
						</div>
						<div class="group_userbxbtm"><div class="clear"></div></div>
					</div>
					<!-- Latest Members List box End -->
					<?php 
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
			
			/*$friends = array ();
			if ($getIDs[0]['type'] == 'no') {
				$friend = $connection->get('http://twitter.com/statuses/friends.json');
			}
			elseif ($getIDs[0]['type'] == 'yes') {
				$friend = $summize->friends();
				}
			$friendcount = count($friend);
			for ($i = 0; $i < $friendcount; $i++) {
				array_push($friends, $friend[$i]->screen_name);
				}
				*/
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
					?>
					<!-- All Members List box Start -->
					<div class="forms02">
						<div class="group_userbxtop"><div class="clear"></div></div>
						<div class="group_userbxmid">
							<div class="forms01"><h5>Members</h5></div>
							<div id="txtResult">
					<?php $sqlmemberlist = "SELECT ta_group_member_profile.profileImage as profileImage,ta_group_members.memberID as memberID,ta_group_member_profile.memberName as memberName FROM `ta_group_members`,`ta_group_member_profile`  where ta_group_members.memberName=ta_group_member_profile.memberName and ta_group_members.groupID='$groupid' order by ta_group_member_profile.memberName asc";
					$Getmemberlist = runQuery($sqlmemberlist);
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
											
											<!-- <a href="#"><img src="../images/add_user.png" alt="Follow This User" title="Follow This User" /></a>
												<a href="#"><img src="../images/remove-user.png" alt="Unfollow This User" title="Unfollow This User" /></a>
											-->
							<?php
							//check whether the user is the member of the group
							if($username!=$Getmemberlist[$b]["memberName"]) 
							{
							//start block or unblock user
							$blkeduser="select * from ta_block_user where blockedby='$username' and blockeduser='{$Getmemberlist[$b]['memberName']}'";
						    $Getblockedlist = runQuery($blkeduser);
						     	if(count($Getblockedlist)==0)
							{
								if (in_array($Getmemberlist[$b]["memberName"], $friends)) {
								$val = "onclick=\"groupfollowstatus('remove','{$getIDs[0]['Username']}','follow{$Getmemberlist[$b]['memberName']}','{$Getmemberlist[$b]['memberName']}');\"";
								$followstatus = "<a {$val} title=\"Click to Unfollow {$Getmemberlist[$b]['memberName']}\"><img src=\"../images/remove-user.png\" alt=\"\" /></a>";
						     	} else {
								$val = "onclick=\"groupfollowstatus('follow','{$getIDs[0]['Username']}','follow{$Getmemberlist[$b]['memberName']}','{$Getmemberlist[$b]['memberName']}');\"";
								$followstatus = "<a {$val} title=\"Click to Follow {$Getmemberlist[$b]['memberName']}\"><img src=\"../images/add_user.png\" alt=\"\" /></a>";
							    }
							}
							else{
								$followstatus="";
							}
						  	if(isset($Getblockedlist[0]["blockedby"])){
								
							$bresl="<a onclick=\"groupblockuser('unblock','follow','{$getIDs[0]['Username']}','block{$Getmemberlist[$b]['memberName']}','follow{$Getmemberlist[$b]['memberName']}','{$Getmemberlist[$b]['memberName']}','$gid');\"  title=\"Click to unblock {$Getmemberlist[$b]['memberName']}\">unblock</a>";
							 }else{
							$bresl="<a onclick=\"groupblockuser('block','remove','{$getIDs[0]['Username']}','block{$Getmemberlist[$b]['memberName']}','follow{$Getmemberlist[$b]['memberName']}','{$Getmemberlist[$b]['memberName']}','$gid');\"  title=\"Click to block {$Getmemberlist[$b]['memberName']}\"><img src=\"../images/pause-user.png\" alt=\"\" /></a>";
							 }
						 //end block or unblock user 
							 ?>
						<div class="middle_userthumplink"><span id="<?php  echo follow.$Getmemberlist[$b]["memberName"]; ?>"><?php echo $followstatus; ?></span><span id="<?php  echo block.$Getmemberlist[$b]["memberName"]; ?>"><?php echo $bresl; ?></span></div>
						<?php }
						else{?>
								<div class="middle_userthumplink"><a href="#"></a>
												<a href="#"></a></div>
						<?php }
						?>
						
											<div class="clear"></div>
										</div>
									</li>
									<!-- Member area box 01 Start -->
							<?php 	
							 }
							}
							else{
											echo "No Groups Found";
										}
							?>
								</ul>
								<div class="clear"></div>
							</div>
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
							 $nav .= "<span class='current'>$page</span> "; // no need to create a link to current page
							 }
							 else
							 {
							 $nav .= "<a href=\"javascript:htmlData('grouphomepaging.php','gid=$gid','p=$page')\"> $page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev = " <a href=\"javascript:htmlData('grouphomepaging.php','gid=$gid','p=$page')\">Prev</a>";
							
							 $first = "<a href=\"javascript:htmlData('grouphomepaging.php','gid=$gid','p=1')\">[First Page]</a>";
							 }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next = " <a href=\"javascript:htmlData('grouphomepaging.php','gid=$gid','p=$page')\">Next</a>";
							
							 $last = " <a href=\"javascript:htmlData('grouphomepaging.php','gid=$gid','p=$maxPage')\">[Last Page]</a>";
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
						<div class="group_userbxbtm"><div class="clear"></div></div>
					</div>
					<!-- All Members List box End -->
					<?php } 
					else{
					?>
				<div class="middle_groupuser">
										
							<div class="middle_grouphomelink">
							<div>
							</div>
								
							<div class="middle_grouphomemember">
                       Sorry, This group does not exists!
							</div>
						</div>
						<div class="clear"></div>
					</div>
					
				
			
						<?php } ?>
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
