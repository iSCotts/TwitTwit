<?php
session_start();
include ('../classes/dbClient.php');
include "../common/sqlFunctions.php"; 
$user=$_SESSION["username"];
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
	$campaignDetails = getCampaignDetails($_SESSION["username"]);
	$campaignCount = count($campaignDetails);
?>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'ddaccordion.js' ?>"></script>
<link href="<?php echo CSS_PATH.'home.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH.'main.css' ?>" rel="stylesheet" type="text/css" />
<script	src="<?php echo SRCH_PATH.'searchFollow.js' ?>" type="text/javascript"></script>
<!--Graph Area Start-->
	<div class="middle_main">
		<div class="bx_mid">
			<div class="inner_middle_cont">
				<br />
				<!-- Middle Contents Start -->
				<div class="innermain_head">
					<div class="innermain_head01" style="width:500px;"><h1>How popular are you on Twitter?</h1></div>
					<div class="clear"></div>
				</div>
				<div class="middlecont_01_inner">
					<div class="innermid_top"></div>
					<div class="innermid_mid_campaign">
					<?php 
					$month = date("n"); 
					$year= date("Y");
					$user=$_SESSION["username"];
					?>switch month
					 <select name="month" id="month" class="inner_option_medium01" onchange="showgraph('<?php echo $month ?>','<?php echo $year ?>','<?php echo $user ?>');">
						<option value='1' <?php if ($_REQUEST['month']==1 || $month==1) echo "selected"; ?>>January</option>
						<option value='2' <?php if ($_REQUEST['month']==2 || $month==2) echo "selected"; ?>>February</option>
						<option value='3' <?php if ($_REQUEST['month']==3 || $month==3) echo "selected"; ?>>March</option>
						<option value='4' <?php if ($_REQUEST['month']==4 || $month==4) echo "selected"; ?>>April</option>
						<option value='5' <?php if ($_REQUEST['month']==5 || $month==5) echo "selected"; ?>>May</option>
						<option value='6' <?php if ($_REQUEST['month']==6 || $month==6) echo "selected"; ?>>June</option>
						<option value='7' <?php if ($_REQUEST['month']==7 || $month==7) echo "selected"; ?>>July</option>
						<option value='8' <?php if ($_REQUEST['month']==8 || $month==8) echo "selected"; ?>>August</option>
						<option value='9' <?php if ($_REQUEST['month']==9 || $month==9) echo "selected"; ?>>September</option>
						<option value='10' <?php if ($_REQUEST['month']==10 || $month==10) echo "selected"; ?>>October</option>
						<option value='11' <?php if ($_REQUEST['month']==11 || $month==11) echo "selected"; ?>>November</option>
						<option value='12' <?php if ($_REQUEST['month']==12 || $month==12) echo "selected"; ?>>December</option>
						</select>
						<select name="yearselect" id="yearselect" class="inner_option_medium01" onchange="showgraph('<?php echo $month ?>','<?php echo $year ?>','<?php echo $user ?>');">
						<?php for($yr=2010;$yr<2021;$yr++)
						{?>
						<option value="<?php echo $yr ?>" <?php if($_REQUEST['yearselect']==$yr) echo "selected"; ?>><?php echo $yr ?></option>
						<?php }?>
						</select>
							<?php 
							$getrefDetails = "SELECT RefID FROM  ta_users WHERE ACStatus='P' and UserName='$user'";
							$geterfResults  = runQuery($getrefDetails);
							$refid=$geterfResults[0]['RefID'];
							$getuserDetails = "SELECT UserName FROM ta_users WHERE RefID='$refid'";
							$getuserResults  = runQuery($getuserDetails);
							?>switch user
							 <select name="user" id="user" class="inner_option_medium01" onchange="showgraph('<?php echo $month ?>','<?php echo $year ?>','<?php echo $user ?>');">
							  <?php		
					  		if(count($getuserResults) >=1 )
					  		{	
							for($y=0;$y<count($getuserResults);$y++){
							?>
							<option value="<?php echo $getuserResults[$y]['UserName'];?>" <?php if ($_REQUEST['user']==$getuserResults[$y]['UserName']) echo "selected";else  if ($user==$getuserResults[$y]['UserName']) echo "selected"; ?>><?php echo $getuserResults[$y]['UserName'];?></option>
							<?php }
							}?>
							</select>
							<div style="height:20px";></div>
							<div id="followgraph" style="text-align:center;height:325px;";>
							<img src="followergraph.php?month=<?php echo $month;?>&yearselect=<?php echo $year;?>&user=<?php echo $user;?>"/>
							</div>
							<p align="right"><img src="<?php echo IMG_PATH."barblue.gif";?>"/>&nbsp;&nbsp;Friends
							<img src="<?php echo IMG_PATH."barorange.gif";?>"/>&nbsp;&nbsp;Followers</p>
												</div>
					<div class="innermid_btm"></div>
					<div class="clear"></div>

					<div class="clear"></div>
				</div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
<!-- Graph Area End -->
<?php }
else {
	header("Location:../index.php");
}
?>
