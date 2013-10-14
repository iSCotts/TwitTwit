<?php
					include_once "../config/configoriginal.php";
					include_once "../classes/dbClient.php";
					include_once "../common/sqlFunctions.php";
					if(isset($_REQUEST['searchtext']))
							{
								$searchtxt=$_REQUEST['searchtext'];
								$sqlsearch = "SELECT * FROM `ta_group` where groupName like '%$searchtxt%'";
								$Getgrouplist = runQuery($sqlsearch);	
							}
							 
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
							  
							// $sqlSelect="select * from tbl_product ";
							 //$getRec=@mysql_query($sqlSelect,$db);
							
							 // how many rows we have in database
							 $getNumRows=count($Getgrouplist);
							// $getNumRows=@mysql_num_rows($getRec);
							 $Limit=" LIMIT $offset, $rowsPerPage";
							 $sqlSelQueryLimit=$sqlsearch.$Limit;
							 $Getgrouplist=runQuery($sqlSelQueryLimit);	
							 //$result=@mysql_query($sqlSelQueryLimit,$db);
							 //echo $sqlSelQueryLimit;
							 ?> 
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
									<div class="group_userdis"><?php if($Getgrouplist[$y]["groupOwner"]==$username){?><a href="searchlisting?deleteid=<?php echo $Getgrouplist[$y]["groupID"]; ?>&searchtext=<?php echo $searchtext;?>" title="Delete The Group"><img src="../images/close.png"/></a><?php }?></div>
									<div class="group_userdis"><?php if($Getgrouplist[$y]["groupOwner"]==$username){?><a href="editgrouplisting?egid=<?php echo $Getgrouplist[$y]["groupID"]; ?>" title="Edit The Group"><img src="../images/edit.png" /></a><?php }?></div>
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
							 $nav .="<a href=\"javascript:htmlDatasrch('searchpaging.php','searchtext=$searchtxt','p=$page')\"> $page</a> ";
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