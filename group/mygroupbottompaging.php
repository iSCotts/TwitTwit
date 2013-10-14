<?php
					include_once "../config/configoriginal.php";
					include_once "../classes/dbClient.php";
					include_once "../common/sqlFunctions.php";
					$un=$_REQUEST['un'];
							$sqlmember = "SELECT distinct ta_group.ta_groupID as groupID,ta_group.groupName as groupName,ta_group.groupImage as groupImage FROM `ta_group`,`ta_group_members` where ta_group_members.memberName='$un' and ta_group_members.groupID=ta_group.groupID order by groupName asc ";
							$memberlist = runQuery($sqlmember);	
							// how many rows to show per page
							 $rowsPerPage2 = 4;
							
							 // by default we show first page
							// $pageNum = 1;
							
							 // if $_GET['page'] defined, use it as page number
							   if(isset($_GET['p']))
							 {
							 $pageNum =$_GET['p'];
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
							 $nav .="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$un','p=$page')\">$page</a> ";
							 }
							 }
							 }
							 // creating previous and next link
							 // plus the link to go straight to
							 // the first and last page
							
							if ($pageNum > 1)
							 {
							 $page = $pageNum - 1;
							 $prev ="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$un','p=$page')\">Prev</a> ";
							
							 $first ="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$un','p=1')\">[First Page]</a> ";
							  }
							 else
							 {
							 $prev = '&nbsp;'; // we're on page one, don't print previous link
							 $first = '&nbsp;'; // nor the first page link
							 }
							
							 if ($pageNum < $maxPage)
							 {
							 $page = $pageNum + 1;
							 $next ="<a href=\"javascript:htmlData2('mygroupbottompaging.php','un=$un','p=$page')\">Next</a> ";
																				
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