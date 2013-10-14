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
include_once "common/EpiCurl.php";
include_once "common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo SITE_TITLE ?></title>
	<link href="<?php echo CSS_PATH.'main.css' ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo FACEBX_PATH.'facebox.css' ?>" media="screen" rel="stylesheet" type="text/css" />
	<!--<link href="facebox/faceplant.css" media="screen" rel="stylesheet" type="text/css" />-->

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

<body>
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
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'package.php')) echo 'class="current"';?> href="package">Package</a></li><li>|</li>
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
					<div class="banner_btn"><a href="package"><img src="<?php echo IMG_PATH."signup.jpg";?>" alt="Sign Up" /></a></div>
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
				<div class="video"></div>
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
				<div class="middlecont01_01">
					<h4>Sorry, Twitter seems to be busy.</h4>
					<p>Please try again later.</p>
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
