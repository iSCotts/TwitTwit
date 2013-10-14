<?php
include "../includes/header.php";
$_SESSION["SCampaignId"]  = "";
$_SESSION["selectedarray"]  = "";
$user=$_SESSION["username"];
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") 
{
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
	window.location = "Managecampaign";
	}
}

function ShowEditCampaignPage(CampaignID)
{
	// call ajax
	 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url="editcampaign_assign.php";
	url=url+"?Do=Save&CampaignID="+CampaignID+"";
//	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  ="Adding the account";
	xmlHttp.onreadystatechange=stateChangedShowEditCampaignPage;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);
	//window.location = "campaign.php?c="+CampaignID+"&m=a";
	//document.getElementById('CampaignID').value = CampaignID;
}
function stateChangedShowEditCampaignPage()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	window.location = "campaign";
	}
}
</script>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.jmin.s' ?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'ddaccordion.js' ?>"></script>
<script src="<?php echo FACEBX_PATH.'facebox.js' ?>" type="text/javascript"></script>
<link href="<?php echo FACEBX_PATH.'facebox.css' ?>" media="screen" rel="stylesheet" type="text/css" />

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

								<div class="slider_head"><span style="cursor: pointer;" onclick="ShowEditCampaignPage('<?php echo $campaignDetails[$i]['CampaignID'];?>');"><?php echo $campaignDetails[$i]['CampaignName'];?></span>
								
								</div>
								
								<div class="submenuheader">&nbsp;</div>
								
								<div class="campaign_slide01_edit03">
	
<img src="<?php echo IMG_PATH."edit01.jpg";?>" alt="Edit"  onclick="ShowEditCampaignPage('<?php echo $campaignDetails[$i]['CampaignID'];?>');" title="Edit Campaign"/>
	 								
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
		echo "Scheduled";
	}
}
?>
</div>
								
								<div class="clear"></div>
							</div>


						    <div class="submenu">
								<div class="accordion_child">
								<!-- Content Start -->
								<?php 
									$campID=$campaignDetails[$i]['CampaignID'];
									$getrefDetails = "SELECT UserID FROM  ta_users WHERE UserName='$user'";
									$geterfResults  = runQuery($getrefDetails);
									$UserID=$geterfResults[0]['UserID'];
									userreports($UserID,$campID);
									?>
								<!-- Content End -->
							    </div>
						    </div>
						    <!-- Accordian 01 Content End -->
<?php }?>
	      <div style="padding:15px 0 0 10px;"><a href="campaign"><img src="<?php echo IMG_PATH."add_c.png";?>" alt="Add a New Campaign" /></a></div>
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


