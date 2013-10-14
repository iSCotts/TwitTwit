<?php
session_start();
if(isset($_REQUEST["q"]) && ($_REQUEST["q"] != " "))
{
	session_destroy();
	session_start();
    $_SESSION["affiliateid"] = $_REQUEST["q"];	
}
if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
{
	header("Location:user/home.php");	
}
include_once 'classes/dbClient.php';
include_once "config/config.php";
include_once "common/meta_main.php";
include_once "common/meta_sub.php";
include_once "common/EpiCurl.php";
include_once "common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $metadata_selected['title'] ; ?></title>
	<meta name="description" content="<?php echo $metadata_selected['meta_description'] ; ?>" />
	<meta name="keywords" content="<?php echo $metadata_selected['meta_keywords'] ; ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="<?php echo CSS_PATH.'main.css' ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo FACEBX_PATH.'facebox.css' ?>" media="screen" rel="stylesheet" type="text/css" />
	<!--<link href="facebox/faceplant.css" media="screen" rel="stylesheet" type="text/css" />-->
    <script type="text/javascript" src="js/flowplayer-3.2.4.min.js"></script>
	<script src="<?php echo JS_PATH.'DD_belatedPNG_0.0.7a-min.js' ?>" type="text/javascript"></script>
	<script type="text/javascript">
	   DD_belatedPNG.fix('img, div, li');
	</script>
	
	<script src="<?php echo JS_PATH.'jquery.js' ?>" type="text/javascript"></script>
	<script src="<?php echo FACEBX_PATH.'facebox.js' ?>" type="text/javascript"></script>
	<script src="<?php echo JS_PATH.'jquery.validate.js' ?>" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loading_image : 'facebox/loading.gif',
			close_image   : 'facebox/closelabel.gif'
		  }) 
		})
	 </script>
</head>

<body><?php include_once("analyticstracking.php") ?>
<!-- Main Container Begin -->
<div class="main_container">

	<!-- Top Navigation Links Start -->
	<div class="top_navigation">
		<ul>
		<?php
		if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
		{?>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'home.php')) echo 'class="current"';?> href="user/home">Home</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'add_account.php')) echo 'class="current"';?> href="user/add_account">My Accounts</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'campaign.php')) echo 'class="current"';?> href="campaign">My Campaigns</a></li><li>|</li>
			<li><a href="#">My Groups</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'logout.php')) echo 'class="current"';?> href="user/logout.php">Logout</a></li>
			<?php }else{?>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo 'class="current"';?> href="index">Home</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'features.php')) echo 'class="current"';?> href="features">Features</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'pricing.php')) echo 'class="current"';?> href="pricing">Pricing</a></li><li>|</li>
			<li><a href="how_it_works">How it Works</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'affiliate_program.php')) echo 'class="current"'; ?> href="<?php echo USR_PATH.'affiliate_program' ?>" >Affiliates</a></li><li>|</li>
			<li><a href="benefits"> Benefits</a></li><li>|</li>
			<li><a href="faq"> FAQ's</a></li><li>|</li>
			<li><a href="contact">Contact</a></li>
			<?php if(isset($_SESSION["aff_username"])) {?> <li>|</li><li>  <a  href="<?php echo SITE_URL."user/logout" ?>">Logout</a></li><?php } ?>
		<?php }?>
	
		</ul>
		<div class="clear"></div>
	</div>
	<!-- Top Navigation Links End -->
	<!-- Banner Area Start -->
	<div class="banner_area">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="banner_mid">
			<div class="banner_left">
				<div><a href="index"><img src="<?php echo IMG_PATH."twitacc_logo.png";?>" alt="" /></a></div>
				<div class="caption"><img src="<?php echo IMG_PATH."caption.png";?>" alt="The Twitter Accelerator !" /></div>
				<div class="banner_cont">
					<p>Our solution provides the easiest way to create, maintain and track your Twitter account features. Using our solution is as easy as 1-2-3!</p>
				</div>
				<div class="banner_btnlinks">
					<div class="banner_btn"><a href="pricing"><img src="<?php echo IMG_PATH."signup.jpg";?>" alt="Sign Up" /></a></div>
						<div class="banner_btn01"><a href="features"><img src="<?php echo IMG_PATH."features.png";?>" alt="Features" /></a></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="banner_right">
				<!-- Sign in Area Start -->
				<div class="exclusive">
				<div style=" padding:3px 0 0 20px; float:left;">Have a Twitter account ? </div>
     <div style=" padding:0 0 0 10px; float:left;"><a href="<?php print $twitterObj->getAuthenticateUrl(); ?>"><img src="<?php echo FACEBX_PATH.'sign_in_twitter.gif' ?>" alt="Sign in with Twitter" /></a></div>
			<div class="clear"></div>
				
				</div>
				<!-- Sign in Area End -->
				
				<!-- Video Start -->
				<div class="video">
				<a href="http://twitjix.com/twittac-video.flv" style="display:block;width:356px;height:212px" id="player"></a> 
		 		<script>
					flowplayer("player", "flowplayer-3.2.2.swf");
				 </script>
				</div>
				<!-- Video End -->
			</div>
			<div class="clear"></div>
		</div>
		<div class="bx_btm"><div class="clear"></div></div>
	</div>
	<!-- Banner Area End -->
	
	<!-- Banner Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_cont">
				<!-- Middle Contents Start -->
				<div><h1>How It Works</h1></div>
				
					<div class="middlecont01_01">
					<h4>1. Create your Profile</h4>
					<p>Link your Twitter account with us and we provide easy access to it through our website. After linking up, you are free to use any of the features that we offer. Features like Campaigns, Groups, Multi Account Handling, Follow/Unfollow Tool, Keyword Tracker, Targetted Marketing Campaigns, Publish RSS Feeds, Auto Tweet, Campaign Manager, Full Automation and many more! So just one account and so many features, that’s the advantage of signing up with us!</p>
					<h4>2. Click, Click Boom..!</h4>
					<p>Oh well you don’t even need two clicks to be up and running with any of those features!  Execute your campaigns as per the schedule specified by you, you are completely in charge, yet don’t have to do much. Just configure once and execute forever. This feature not only saves your time but is also saves you the trouble of remembering everything. No more missed RSS feeds or blog updates!</p>
					<h4>3. Track your updates</h4>
					<p>Our solution will help you track updates, analyze your success, and optimize your marketing campaigns based on previous results. Our keyword searching tool helps in finding all the relevant content for you to start following. We help you track campaigns started by other people as well!</p>
											<div class="clear"></div>

				</div>
				<!-- Middle Contents End -->
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="bx_btm"><div class="clear"></div></div>
	</div>
	<!-- Banner Area End -->
	
	
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_cont">
				<!-- Middle Contents Start -->
				<div><h1>Features</h1></div>
				
				<div class="middlecont_01">
					<!-- Features Left Box Start -->
					<div class="feature_bx01">
					
						<!-- Feature 04 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_02.png";?>" alt="" /></div>
								<div class="feature_home_h01"><h2>Add Multiple Twitter Accounts</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
										Just login once and get access to all your twitter accounts. Use our unique and compact dashboard to view and control all your Twitter profiles, updates, campaigns, and activities. 
								</p>
							</div>
						</div>
						<!-- Feature 04 End -->

						<!-- Feature 02 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_04.png";?>" alt="" /></div>
								<div class="feature_home_h"><h2>Auto Tweets</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
									Automatically tweet sports updates, random cool facts, and overall keep your followers interested in you
									
								</p>
							</div>
						</div>
						<!-- Feature 02 End -->
						
						<!-- Feature 05 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_05.png";?>" alt="" /></div>
								<div class="feature_home_h01"><h2>Feed Twitter with your Blog or RSS</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
										Post content from the RSS feed of your blog or website to your Twitter account through poster campaigns. Post from any of the registered accounts. No more  manual copy/paste of updates from your website.
								</p>
							</div>
						</div>
						<!-- Feature 05 End -->
						
					</div>
					<!-- Features Left Box End -->
					
					<!-- Features Middle Box Start -->
					<div class="feature_bx02">
					
						<!-- Feature 01 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_01.png";?>" alt="" /></div>
								<div class="feature_home_h01"><h2>Manage your Campaigns</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
								Create, Manage and Track all your campaigns .Save your time by using Set It and Forget It method to manage and execute all your campaigns
								</p>
							</div>
						</div>
						<!-- Feature 01 End -->
						
						<!-- Feature 07 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_03.png";?>" alt="" /></div>
								<div class="feature_home_h"><h2>Keyword Watch</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
								Keyword Watch enables you to monitor and watch any tweets that mention the keyword you specify.
								</p>
							</div>
						</div>
						<!-- Feature 07 End -->
						
						
						<!-- Feature 06 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_08.png";?>" alt="" /></div>
								<div class="feature_home_h"><h2>Future Tweets</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
								Automatically send scheduled tweets and  RSS feed to your twitter account.		
								</p>
							</div>
						</div>
						<!-- Feature 06 End -->
						
					</div>
					<!-- Features Middle Box End -->

					<!-- Features Right Box Start -->
					<div class="feature_bx01">
					
						
						<!-- Feature 03 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_07.png";?>" alt="" /></div>
								<div class="feature_home_h"><h2>Secure Login</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
										Create one account and link it to all your Twitter profiles. Just log in once and we take care of the rest by securing your login process using OAuth and SSL. 
								</p>
							</div>
						</div>
						<!-- Feature 03 End -->
						
						<!-- Feature 08 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_06.png";?>" alt="" /></div>
								<div class="feature_home_h"><h2>Track your Links</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
										With inbuilt Short URL , Track the Traffic of your links that you get from twitter.
								</p>
							</div>
						</div>
						<!-- Feature 08 End -->
						
						<!-- Feature 09 Start -->
						<div class="feature_home01">
							<div class="feature_home_head">
								<div class="feature_home_icon"><img src="<?php echo IMG_PATH."ico_09.png";?>" alt="" /></div>
								<div class="feature_home_h"><h2>Track Your Campaigns</h2></div>
								<div class="clear"></div>
							</div>
							<div class="feature_home_cont">
								<p>
									Track and analyze the performance of your campaigns. Get detailed statistics and Review all your metrics
									<span class="clear"></span>
								</p>
							</div>
							<div class="clear"></div>
						</div>
						<!-- Feature 09 End -->
						
					</div>
					<!-- Features Right Box End -->
					<div class="clear"></div>
				</div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
	
	<!-- Footer Container Start -->
	<div class="footer">
		<div class="footer_left"><a href="#"><img src="<?php echo IMG_PATH."logo_footer.jpg";?>" alt="" /></a></div>
		<div class="footer_right">
			<?php
		if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
		{?>
			<a href="user/home">Home</a>  |
			<a href="user/request_feature">Request Feature TOS</a>  |
			<a href="privacy_policy"> Privacy Policy</a>  |
			<a href="user/logout.php">Logout</a>
			<?php }else{?>
			<a href="index">Home</a>  |
			<a href="http://www.twitter.com/twitacc_com" target="_blank">Follow us</a>  |
			<a href="privacy_policy">Privacy Policy</a>   |
			<a href="terms">Terms &amp; Conditions</a>  |
			<a href="sitemap">Site Map</a> |
			<?php
			  if(isset($_SESSION["aff_username"]))  {?><a  href="<?php echo AFF_PATH."affnonuser" ?>">  <?php }else{ ?><a  href="<?php echo USR_PATH.'affiliate_program' ?>"><?php } ?>Affiliate Program</a>
			<?php }?>
			<br />
			Copyright &copy; 2010 twitjix.com.
		</div>
		<div class="clear"></div>
	</div>
	<!-- Footer Container End -->
	
</div>
<!-- Main Container End -->
</body>
</html>
