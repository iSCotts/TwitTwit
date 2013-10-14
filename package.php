<?php 
include "includes/header.php";
include_once 'classes/dbClient.php';
include_once "config/config.php";
include_once "common/EpiCurl.php";
include_once "common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
$sql = "SELECT * FROM ta_packages where  packageID=0";
$getPackageList = runQuery($sql);
?>
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_cont">
				<!-- Middle Contents Start -->
				
				<div><h1>Packages</h1></div>
				
				<div class="middlecont_01">
					<div>
						<!-- Features Start -->
						<div class="pricing_left">
							<div class="pricing_topfeatures">Features</div>
							<div class="pricing_topfeatures01">Campaigns</div>
							<div class="pricing_topfeatures01">Twitter Accounts</div>
							<div class="pricing_topfeatures01">Keywords</div>
							<div class="pricing_topfeatures01">RSS Feeds</div>
							<div class="pricing_topfeatures01">Auto Tweet Features</div>
							<div class="pricing_topfeatures01">Campaign Statistics</div>
							<div class="pricing_topfeatures01">URL Tracking</div>
							<div class="pricing_topfeatures01">Number of follows</div>
							<div class="pricing_btmfeatures"></div>
							<div class="clear"></div>
						</div>
						<!-- Features End -->
							<?php 
					if(count($getPackageList)>=1)
								{
					for($a=0;$a<count($getPackageList);$a++){
						?>
						<!-- Features Offer Start -->
						<div class="pricing_right">
							<div class="pricing_topdis"><?php  echo $getPackageList[$a]['packageName']; ?></div>
							<div class="pricing_topdis01"><?php  echo $getPackageList[$a]['campaignLimit']; ?></div>
							<div class="pricing_topdis01"><?php  echo $getPackageList[$a]['twitterAcc']; ?></div>
							<div class="pricing_topdis01"><?php  echo $getPackageList[$a]['keywordLimit']; ?></div>
							<div class="pricing_topdis01"><?php  echo $getPackageList[$a]['rssFeeds']; ?></div>
							<div class="pricing_topdis01"><?php if($getPackageList[$a]['autoTweet']==1){ ?><img src="images/tick.gif" alt="" /><?php } else {?><img src="images/x-package.png" alt="" /><?php } ?></div>
							<div class="pricing_topdis01"><?php if($getPackageList[$a]['campStatistics']==1){ ?><img src="images/tick.gif" alt="" /><?php } else {?><img src="images/x-package.png" alt="" /><?php } ?></div>
							<div class="pricing_topdis01"><?php if($getPackageList[$a]['urlTrack']==1){ ?><img src="images/tick.gif" alt="" /><?php } else {?><img src="images/x-package.png" alt="" /><?php } ?></div>
							<div class="pricing_topdis01"><?php  echo $getPackageList[$a]['followLimit']; ?></div>
							<div class="pricing_btmfeatures"></div>
							<div class="clear"></div>
						</div>
						<!-- Features Offer End -->
						<?php }
									}
									?>
						<div class="clear"></div>
					</div>
					
					<div class="loginwith_twitt">
						<a href="<?php print $twitterObj->getAuthenticateUrl(); ?>"><img src="<?php echo FACEBX_PATH.'sign_in_twitter.gif' ?>" alt="Sign in with Twitter" /></a><!--<a href="#"><img src="images/sign_in_twitter.gif" alt=""></a>-->
					</div>
					
					<div class="clear"></div>
				</div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
<?php 
include "includes/footer.php";?>	
