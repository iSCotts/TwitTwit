<?php 
include "../includes/header.php";
$_SESSION["SCampaignId"]  = "";
$_SESSION["selectedarray"]  = "";
$user=$_SESSION["username"];
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
	$campaignDetails = getCampaignDetails($_SESSION["username"]);
	$campaignCount = count($campaignDetails);
?>
<script type="text/javascript">
var xmlHttp;

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function ShowEditCampaignPage(CampaignID)
{
	 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url="editcampaign_assign.php";
	url=url+"?Do=Save&CampaignID="+CampaignID+"";
	xmlHttp.onreadystatechange=stateChangedShowEditCampaignPage;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);
}
function stateChangedShowEditCampaignPage()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	window.location = "campaign";
	}
}
//tweet post
function updateCounter() {
	var maxlength=139;
	var field=document.getElementById('tweetstxt');
	var totalLength = field.value.length;
	document.getElementById('counter').innerHTML = maxlength-totalLength;
}

/*function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}
*/

function confirmDelete(cid) {
	  if (confirm("Are you sure you want to delete")) {
	   // document.location = "Managecampaign.php?d="+cid+"";
		// call ajax
			 xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			  {
			  alert ("Browser does not support HTTP Request");
			  return;
			  }
			var url="deletecampaign.php";
			url=url+"?Do=Save&d="+cid+"";
			xmlHttp.onreadystatechange=stateChangedconfirmDelete;
			xmlHttp.open("POST",url,true);
			xmlHttp.send(null);
	  }
	}

function stateChangedconfirmDelete()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	window.location = "home";
	}
}
</script>
<script type='text/javascript' src='../js/jquery_pop.js'></script>
<script type='text/javascript' src='../js/jquery.simplemodal_pop.js'></script>
<?php
 if($_SESSION["mailid"]=="no")
{
?>
<script type="text/javascript">
 jQuery(function ($) {
$('#basic-modal-content').modal();
 return false;
});
	</script>
 <?php
}
?>
<link href="<?php echo CSS_PATH.'basic_ie_pop.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH.'basic_pop.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'ddaccordion.js' ?>"></script>
<link href="<?php echo CSS_PATH.'home.css' ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo FACEBX_PATH.'facebox.js' ?>" type="text/javascript"></script>
<script	src="<?php echo SRCH_PATH.'searchFollow.js' ?>" type="text/javascript"></script>
<link href="<?php echo FACEBX_PATH.'facebox.css' ?>" media="screen" rel="stylesheet" type="text/css" />
<!--Tweet Area Start-->
<div id="basic-modal-content">
	<iframe id="xyz123" src="http://twitjix.com/user/emailpopup.php?username=<?php echo $user; ?>" frameborder="0"  width="100%" height="400px">
				 </iframe>	
		</div>	
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="inner_middle_cont">
				<!-- Middle Contents Start -->
				<!-- Tweet Posting Area Start -->
				<div class="home_tweetsleft_inner">
					<div class="innermid_top"></div>
					<div class="innermid_mid_campaign">
						<!-- Tweets Left Start -->
						<div class="home_tweetsleft">
							<div><h2 style="padding:10px 0 0 0;">Post Tweets</h2></div>
							<div class="home_tweetsleftnumber" id="counter">140</div>
							<div>
							<textarea class="home_tweetslefttxtarea" cols="" rows="" name="tweetstxt" id="tweetstxt"  onkeypress="updateCounter()" onkeyup="updateCounter()"></textarea>
							</div>
														<input type="hidden" value="0" id="theValue" name="theValue" />
							<div>
							<input type="button" value="Post"  name="submit" class="inner_txtbtn_01" onclick="submitTweets();"/></div>
							<!-- <div id="result"></div> -->
							<div class="home_tweetscont">
								<h4 style="padding:0 0 10px 0;">Most Recent Tweets</h4>
								<div id="tweetresult"><?php fetchtweets($user);?></div>
								
								</div>
						</div>
						<!-- Tweets Left End -->
						
						<!-- Tweets Right Start -->
						<div class="home_tweetsright">
						
							<!-- Switch User Start -->
							<div style="padding:0 0 10px 0;">
							<?php 
							$getrefDetails = "SELECT RefID,UserID FROM  ta_users WHERE ACStatus='P' and UserName='$user'";
							$geterfResults  = runQuery($getrefDetails);
							$UserID=$geterfResults[0]['UserID'];
							$refid=$geterfResults[0]['RefID'];
							$getuserDetails = "SELECT UserName FROM ta_users WHERE RefID='$refid'";
							$getuserResults  = runQuery($getuserDetails);
							?>Switch User :
							 <select name="tweetuser" id="tweetuser" class="home_tweetsrightsel" onchange="gettweets();getgroups();">
							  <?php		
					  		if(count($getuserResults) >=1 )
					  		{	
							for($y=0;$y<count($getuserResults);$y++){
							?>
							<option value="<?php echo $getuserResults[$y]['UserName'];?>" <?php if ($_REQUEST['user']==$getuserResults[$y]['UserName']) echo "selected";  else  if ($user==$getuserResults[$y]['UserName']) echo "selected";?>><?php echo $getuserResults[$y]['UserName'];?></option>
							<?php }
							}?>
							</select>
								</div>
							<!-- Switch User End -->
						
							<!-- My_Groups Area Start -->
							<div><h4>My Groups</h4></div>
								<div class="home_tweetsright_rbx">
								<div class="home_tweetsright_rtop"><div class="clear"></div></div>
								<div class="home_tweetsright_rmid">
									<div class="middle_group_rmid01" id="middle_group_rmid01">
										<?php fetchmygroups($user);?>		
									</div>
								</div>
								<div class="home_tweetsright_rbtm"><div class="clear"></div></div>
							</div>
							<!-- My_Groups Area End -->
						
						
							<!-- Popular_Groups Area Start -->
							<div><h4>Popular Groups</h4></div>
							<?php 
						$populargrp="SELECT groupID, count( groupID ) AS membercount FROM `ta_group_members` GROUP BY groupID order by membercount desc LIMIT 3";
						$Getpolgroup =runQuery($populargrp);
						?>
							<div class="home_tweetsright_rbx">
								<div class="home_tweetsright_rtop"><div class="clear"></div></div>
								<div class="home_tweetsright_rmid">
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
											<div class="thump_small"><a href="<?php echo GRP_PATH."grouphome?id=".$Getpolgroup2[$r]['groupID'] ?>"><?php if($Getpolgroup2[$r]['groupImage']==""){?><img src="<?php echo IMG_PATH."user_photo.jpg";?>" alt="" /><?php } else if (file_exists(GRP_PATH."thumbimg/".$Getpolgroup2[$r]['groupImage'])){?><img src="<?php echo GRP_PATH."thumbimg/".$Getpolgroup2[$r]['groupImage']?>"><?php } else {?><img src="<?php echo GRP_PATH."/origimg/".$Getpolgroup2[$r]['groupImage']?>" border="0" /><?php }?></a></div>
											<div class="thump_smallname"><a href="<?php echo GRP_PATH."grouphome?id=".$Getpolgroup2[$r]['groupID'] ?>"><?php echo $Getpolgroup2[$r]['groupName']?></a></div><div class="clear"></div>
										</div>
										<!-- Group 01 End -->
																
								<?php }
									}
									}
							else{
									echo "No Groups Found";
										}
								?>
									</div>
								</div>
								<div class="home_tweetsright_rbtm"><div class="clear"></div></div>
							</div>
							<!-- Popular_Groups Area End -->
						</div>
						<!-- Tweets Right End -->
						<div class="clear"></div>
					</div>
					<div class="innermid_btm"></div>
				</div>	
				<!-- Tweet Posting Area End -->

				
			
				<!-- Middle Contents End -->
			</div>
		</div>
		<div class="bx_btm"><div class="clear"></div></div>
	</div>
<!-- Graph Area End -->



	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="inner_middle_cont">
				<!-- Middle Contents Start -->
				<div class="innermain_head">
					<div class="innermain_head01"><h1>View Your Campaigns</h1></div>
					<!-- <div class="innermain_pause01"><a href="add_account">Add Mutiple Accounts</a></div>-->
					<div class="clear"></div>
				</div>
				<div class="middlecont_01_inner">

					<div class="innermid_top"></div>
					<div class="innermid_mid_campaign">
						<!-- Inner Page Main Content Start -->


						<!-- Accordian Area Start -->
						<div id="basic-accordian">
<?php
for($i=0;$i<$campaignCount;$i++){
	?>
							<!-- Accordian 01 Content Start -->
							<div class="campaign_slide01 campaign_slide02">
								<div class="slider_head"><span style= " cursor: pointer;" onclick="ShowEditCampaignPage('<?php echo $campaignDetails[$i]['CampaignID'];?>')"><?php echo $campaignDetails[$i]['CampaignName'];?></span>
								</div>
								
								<div class="submenuheader">&nbsp;</div>
								
								<div class="campaign_slide01_edit03">

<img src="<?php echo IMG_PATH."edit01.jpg";?>" title="Edit Campaign"  onclick="ShowEditCampaignPage('<?php echo $campaignDetails[$i]['CampaignID'];?>')"; />
								</div>
								
								<div class="campaign_slide01_edit03">
									<img src="<?php echo IMG_PATH."close.png";?>" alt="Delete"  onclick="javascript:confirmDelete('<?php echo $campaignDetails[$i]['CampaignID'];?>')"   title="Delete Campaign" />	
								</div>
								
								
<div class="campaign_slide01_edit01">
<?php 
if( $campaignDetails[$i]['Status']=='D')
{
	if($campaignDetails[$i]['EndDT'] < date('Y-m-d') && $campaignDetails[$i]['EndDT']!='0000-00-00' && $campaignDetails[$i]['EndDT']!='')
	{
		echo "Ended";
	}
	else 
	{
		echo "Pause";
	}
}
else
{
	if($campaignDetails[$i]['StartDT']=='0000-00-00' || $campaignDetails[$i]['EndDT']=='0000-00-00')
	{
		echo "Active";
	}
	else if($campaignDetails[$i]['StartDT'] <= date('Y-m-d') && $campaignDetails[$i]['EndDT'] >= date('Y-m-d'))
	{
		echo "Active";
	}
	else if($campaignDetails[$i]['EndDT'] < date('Y-m-d'))
	{
		echo "Ended";
	}
	else 
	{
		echo 'Scheduled';
	}
}
?>
</div>

								<div class="clear"></div>
							</div>


						    <div class="submenu">
								<div class="accordion_child" alt="Statistics">
								<!-- Content Start -->
							
		<?php 
		$campID=$campaignDetails[$i]['CampaignID'];
		//For category tweets
		userreports($UserID,$campID);
		?>
						
								<!-- Content End -->
							    </div>
						    </div>
						    <!-- Accordian 01 Content End -->
<?php }?>
	      <div style="padding:15px 0 0 10px;"><a href="campaign"><img src="<?php echo IMG_PATH."add_c.png";?>" title="Add a New Campaign" /></a></div>
						</div>
						<!-- Accordian Area End -->



						<!-- Inner Page Main Content End -->
					</div>
					<div class="innermid_btm"></div>
					<div class="clear"></div>

					<div class="clear"></div>
				</div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
 <?php
	include "../includes/footer.php";
	} else {
	header("Location:../index.php");
}
?>
