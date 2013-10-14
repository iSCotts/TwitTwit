<?php
					include_once "../config/configoriginal.php";
					include_once "../classes/dbClient.php";
					include_once "../common/sqlFunctions.php";
					$membername=$_REQUEST['un'];
					$sqlmember = "SELECT distinct ta_group.groupID as groupID,ta_group.groupName as groupName,ta_group.groupImage as groupImage FROM `ta_group`,`ta_group_members` where ta_group_members.memberName='$membername' and ta_group_members.groupID=ta_group.groupID";
					$memberlist = runQuery($sqlmember);	
					// how many rows to show per page
					 $rowsPerPage = 6;
					
					 // by default we show first page
					// $pageNum = 1;
					
					 // if $_GET['page'] defined, use it as page number
					  if(isset($_GET['p']))
					 {
					 $pageNum =$_GET['p'];
					 }
					
					 // counting the offset
					$offset = ($pageNum - 1) * $rowsPerPage;
					  // how many rows we have in database
					 $getNumRows=count($memberlist);
					 $Limit=" LIMIT $offset, $rowsPerPage";
					 $sqlSelQueryLimit=$sqlmember.$Limit;
					 $Getmemberlist=runQuery($sqlSelQueryLimit);	
					 ?> 
							<?php
							
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