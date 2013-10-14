<!-- Middle Right Start -->
<form name="searchform" action="searchlisting" method="post">
				<div class="middle_groupright">
					
					<!-- Search Area Start -->
					<div><h5>Search a Group</h5></div>
					<div class="middle_group_rbx">
						<div class="middle_group_rtop"><div class="clear"></div></div>
						<div class="middle_group_rmid">
								<div class="middle_group_rmid01">
								<div class="float"><input type="text" value="<?php echo $_REQUEST['searchtext']; ?>" name="searchtext" class="search_txt"></input>
								</div>
								<div class="float"><input type="submit" value="Search" class="search_btn"></div>
								<div class="clear"></div>
							</div>
							</div>
						<div class="middle_group_rbtm"><div class="clear"></div></div>
					</div>
					<!-- Search Area End -->
					
					<div style="padding:0 0 10px 0;"><a href="index"><img src="../images/create_group.png" alt="" /></a></div>
					
					<!-- Popular_Groups Area Start -->
					<div><h5>Popular Groups</h5></div>
					<?php 
					$populargrp="SELECT groupID, count( groupID ) AS membercount FROM `ta_group_members` GROUP BY groupID order by membercount desc LIMIT 0,5";
					$Getpolgroup =runQuery($populargrp);
					?>
					<div class="middle_group_rbx">
						<div class="middle_group_rtop"><div class="clear"></div></div>
						<div class="middle_group_rmid">
							<div class="middle_group_rmid01">
												<?php 
							if(count($Getpolgroup)>=1)
							{
							for($p=0;$p<count($Getpolgroup);$p++){
							$membercount=$Getpolgroup[$p]['membercount'];	
							$selgroupid=$Getpolgroup[$p]['groupID'];
							$populargrp2="SELECT groupID,groupName,groupImage FROM `ta_group` where groupID='$selgroupid'";
							$Getpolgroup2 =runQuery($populargrp2);
							for($r=0;$r<count($Getpolgroup2);$r++){
									?>
								<!-- Group 01 Start -->
								<div class="group_membersmall">
									<div class="thump_small"><a href="grouphome?id=<?php echo $Getpolgroup2[$r]['groupID'] ?>"><?php if($Getpolgroup2[$r]['groupImage']==""){?><img src="../images/user_photo.jpg" alt="" /><?php } else if (file_exists("thumbimg/".$Getpolgroup2[$r]['groupImage'])){?><img src="thumbimg/<?php echo $Getpolgroup2[$r]['groupImage']?>"><?php } else {?><img src="origimg/<?php echo $Getpolgroup2[$r]['groupImage']?>" border="0" /><?php }?></a></div>
									<div class="thump_smallname"><a href="grouphome?id=<?php echo $Getpolgroup2[$r]['groupID'] ?>"><?php echo $Getpolgroup2[$r]['groupName']?></a><br><span><i><?php echo "(".$membercount." "."Members".")"; ?></i></span></div><div class="clear"></div>
								</div>
								<!-- Group 01 End -->
								<?php }
									}
									}
									?>
								</div>
						</div>
						<div class="middle_group_rbtm"><div class="clear"></div></div>
					</div>
					<!-- Popular_Groups Area End -->
					
					<!-- Latest_Groups Area Start -->
					<div><h5>Latest Groups</h5></div>
					<?php 
					$groupsql = "SELECT * FROM `ta_group` ORDER BY groupID DESC  limit 5";
					$Getlatestgroup =runQuery($groupsql);	
					?>
					<div class="middle_group_rbx">
						<div class="middle_group_rtop"><div class="clear"></div></div>
						<div class="middle_group_rmid">
							<div class="middle_group_rmid01">
							<?php 
							if(count($Getlatestgroup)>=1)
							{
							for($y=0;$y<count($Getlatestgroup);$y++){
							$grpid=$Getlatestgroup[$y]['groupID'];
							$grpcountqry="SELECT groupID,count( groupID ) as membercount FROM `ta_group_members` where groupID='$grpid'";
							$Getgrpcount =runQuery($grpcountqry);
							$membercount2=$Getgrpcount[0]['membercount'];
							// if($membercountre[0][count]==1) {echo " Member";} else {echo " Members";}
							?>
								<!-- Group 01 Start -->
								<div class="group_membersmall">
									<div class="thump_small"><a href="grouphome?id=<?php echo $Getlatestgroup[$y]['groupID'] ?>"><?php if($Getlatestgroup[$y]['groupImage']==""){?><img src="../images/user_photo.jpg" alt="" /><?php } else if (file_exists("thumbimg/".$Getlatestgroup[$y]['groupImage'])){?><img src="thumbimg/<?php echo $Getlatestgroup[$y]['groupImage']?>"><?php } else {?><img src="origimg/<?php echo $Getlatestgroup[$y]['groupImage']?>" border="0" /><?php }?></a></div>
									<div class="thump_smallname"><a href="grouphome?id=<?php echo $Getlatestgroup[$y]['groupID'] ?>"><?php echo $Getlatestgroup[$y]['groupName']?></a><br><span><i><?php echo "(".$membercount2." "."Members".")"; ?></i></span></div><div class="clear"></div>
								</div>
								<!-- Group 01 End -->
								<?php }
									}
									?>
					    	</div>
						</div>
						<div class="middle_group_rbtm"><div class="clear"></div></div>
					</div>
					<!-- Latest_Groups Area End -->

				</div>
				<!-- Middle Right End -->
				</form> 