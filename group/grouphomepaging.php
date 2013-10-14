<?php
					include_once "../config/configoriginal.php";
					include_once "../classes/dbClient.php";
					include_once "../common/sqlFunctions.php";
					$groupid=$_REQUEST['gid'];
					$sqlmemberlist = "SELECT ta_group_member_profile.profileImage as profileImage,ta_group_members.memberID as memberID,ta_group_member_profile.memberName as memberName FROM `ta_group_members`,`ta_group_member_profile`  where ta_group_members.memberName=ta_group_member_profile.memberName and ta_group_members.groupID='$groupid' order by ta_group_member_profile.memberName asc";
					$Getmemberlist = runQuery($sqlmemberlist);
					// how many rows to show per page
					 $rowsPerPage = 9;
					
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
							 $nav .= " <span class='current'>$page</span> "; // no need to create a link to current page
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