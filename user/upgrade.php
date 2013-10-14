<?php 
ob_start();
session_start();
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
include_once "../common/dbconfig.php";
include_once "../common/sqlFunctions.php";
include "../includes/header.php";
$sql = "SELECT * FROM ta_packages where  packageID!=0 limit 5";
$getPackageList = runQuery($sql);

?>
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_cont">
				<!-- Middle Contents Start -->
				<?php
				$query="select * from `ta_packages`p LEFT JOIN `ta_user_subscriptions` us ON us.`PackageID` = p.`packageID` where `UserName`='".$_SESSION['username']."'";
				$getuserpkgdetails = runQuery($query);	
				for($i=0;$i<count($getuserpkgdetails);$i++){
				$currentpackage=$getuserpkgdetails[$i]['PackageID'];
				$currentpackagename=$getuserpkgdetails[$i]['packageName'];
				}
				$sql="select * from `ta_packages` where PackageID!='$currentpackage'";
				$getPackageList = runQuery($sql);	
						 ?>
		<div><h2>Your Current Package</h2></div>
					<div><h3><?php echo $currentpackagename; ?></h3></div>
					<div>
				<h1>Upgrade Your Package</h1></div>
				
				<div class="middlecont_01">
				<!-- Features Start -->
					<div class="packages_dis">
						<div class="packages_topfeatures">Features</div>
						<div class="packages_topfeatures01">Twitter Accounts</div>
						<div class="packages_topfeatures01">Keywords</div>
						<div class="packages_topfeatures01">RSS Feeds</div>
						<div class="packages_topfeatures01">Auto Tweet Features</div>
						<div class="packages_topfeatures01">Campaign Statistics</div>
						<div class="packages_topfeatures01">URL Tracking</div>
						<div class="packages_topfeatures01">Number of follows</div>
						<div class="packages_topfeatures02">Monthly</div>
						<div class="packages_topfeatures02">Yearly</div>
						<div class="packages_btmfeatures"></div>
						<div class="clear"></div>
					</div>
					<!-- Features End -->
					<?php 
					if(count($getPackageList)>=1)
								{
					for($a=0;$a<count($getPackageList);$a++){
						?>
					<!-- Features Offer Start -->
						<div class="packages_dis01">
						<div class="packages_topdis"><?php  echo $getPackageList[$a]['packageName']; ?></div>
						<div class="packages_topdis01"><?php  echo $getPackageList[$a]['twitterAcc']; ?></div>
						<div class="packages_topdis01"><?php  echo $getPackageList[$a]['keywordLimit']; ?></div>
						<div class="packages_topdis01"><?php  echo $getPackageList[$a]['rssFeeds']; ?></div>
						<div class="packages_topdis02"><?php if($getPackageList[$a]['autoTweet']==1){ ?><img src="../images/tick.gif" alt="" /><?php } else {?><img src="../images/x-package.png" alt="" /><?php } ?></div>
						<div class="packages_topdis02"><?php if($getPackageList[$a]['campStatistics']==1){ ?><img src="../images/tick.gif" alt="" /><?php } else {?><img src="../images/x-package.png" alt="" /><?php } ?></div>
						<div class="packages_topdis02"><?php if($getPackageList[$a]['urlTrack']==1){ ?><img src="../images/tick.gif" alt="" /><?php } else {?><img src="../images/x-package.png" alt="" /><?php } ?></div>
						<div class="packages_topdis01"><?php  echo $getPackageList[$a]['followLimit']; ?></div>
						<div class="packages_topdis03">
						<div class="packages_topdis03am"><?php if($getPackageList[$a]['mstatus']==1) { echo $getPackageList[$a]['monPrice']; }?></div>
						<div><?php if($getPackageList[$a]['mstatus']==1) {?><a href="javascript: jQuery.facebox({ajax:'../signup/upgradeuser.php?pack=<?php print $getPackageList[$a]['packageID'];?>&price=<?php print $getPackageList[$a]['monPrice'];?>&buttonid=<?php print $getPackageList[$a]['monButtonID'];?>'});"><img src="../images/signup_btn01.jpg" alt="" /></a><?php } ?></div>
						</div>
						<div class="packages_topdis03">
							<div class="packages_topdis03am"><?php if($getPackageList[$a]['ystatus']==1) {  echo $getPackageList[$a]['yearPrice']; }?></div>
							<div><?php if($getPackageList[$a]['ystatus']==1) {?><a href="javascript: jQuery.facebox({ajax:'../signup/upgradeuser.php?pack=<?php print $getPackageList[$a]['packageID'];?>&price=<?php print $getPackageList[$a]['yearPrice'];?>&buttonid=<?php print $getPackageList[$a]['yearButtonID'];?>'});"><img src="../images/signup_btn01.jpg" alt="" /></a><?php } ?></div>
						</div>
						<div class="packages_btmdis"></div>
						<div class="clear"></div>
					</div>
					<!-- Features Offer End -->
					<?php }
									}
									?>
				
						<div class="clear"></div>
					</div>
				
				
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
	  <?php 
include "../includes/footer.php";
}
else
{
	header("Location:../index.php");	
}
?>