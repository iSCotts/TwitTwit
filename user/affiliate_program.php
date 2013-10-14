<?php 
session_start();
include "../includes/header.php";
 ?>
<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="inner_middle_cont">
			
				<!-- Middle Contents Start -->
				<div class="middlecont_01_inner">
				<div class="innermain_head">
					  <div class="innermain_head01">
						  <div class="support_head">Affiliate Program</div>
					  </div>
					  <div style="float:right;">
						  <div style="float:right"><a href="javascript: jQuery.facebox({ajax:'affiliate_login.php'});"><img src="<?php echo IMG_PATH."login.png";?>" alt="" /></a></div>
						  <div style="float:right; padding:5px 10px 0 0;"><strong>Already an affiliate ?</strong></div>
						 <div class="clear"></div>
					 </div>
					 <div class="clear"></div>
				  </div>
					<!--<div class="support_head">
						<div style="float:left;">Affiliate Program</div>
						<div style="float:right;">	<?php
					if ($_SESSION["username"] == "" && $_SESSION["password"] == "") {
					?>
						<div class="upgrade_btn">
							<div style="float:right; padding:0 0 0 0;"><a href="javascript: jQuery.facebox({ajax:'affiliate_login.php'});"><img src="<?php echo IMG_PATH."login.png";?>" alt="" /></a></div>
							<div class="clear"></div>
						</div>			
					<?php
					 } ?>	</div>
						<div class="clear"></div>
					</div>-->
					
						<div>
				
						<div class="support_align">
							twitjix.com offers you a chance to sell premium service and earn an incredible 50% commission for every sale originating from your website. All our affiliates are paid on time through their preferred payment method. At twitjix.com we understand the importance of our affiliates and we go to that extra mile to help them in all possible way. In order to keep our affiliates happy, we offer them performance based bonuses regularly. To begin with, we offer an instant bonus of $50 to all our affiliates as soon as they successfully make their 15th sale. To give you an idea of how much you could earn by promoting our products, please refer to the chart below.
						</div>
					</div>
					
					<div>
						<div style="text-align:center;"><h1>Earning potential</h1></div>
						<div class="affiliate_table">
							<div class="affiliate_tr">
								<div class="affiliate_td">2 sales/day</div>
								<div class="affiliate_td">$1500/month</div>
								<div class="clear"></div>
							</div>
							
							<div class="affiliate_tr">
								<div class="affiliate_td">5 sales/day</div>
								<div class="affiliate_td">$3750/month</div>
								<div class="clear"></div>
							</div>

							<div class="affiliate_tr">
								<div class="affiliate_td">8 sales/day</div>
								<div class="affiliate_td">$6000/month</div>
								<div class="clear"></div>
							</div>

							<div class="affiliate_tr">
								<div class="affiliate_td">10 sales/day</div>
								<div class="affiliate_td">$7500/month</div>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					
					<div>
						<div class="support_align">
							<p>The chart shown above is not inclusive of performance based bonuses.<br /></p>
 
<p><br />So what are you waiting for? <?php
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
?>				
	<a href="javascript: jQuery.facebox({ajax:'affiliate.php'});">
	<?php } else { ?>
	<a href="javascript: jQuery.facebox({ajax:'affiliatenonuser.php'});">
	<?php
	}
	?><u><strong>Sign up</strong></u></a> to our Affiliate Program now.</p>
 
<p><br />It takes less than 5 minutes to become our affiliate and start promoting our products.refer to the chart below.</p>

<strong><br /><br /><h1>Here's how:</h1><br /></strong>
<strong>Step 1:</strong> <?php
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
?>				
	<a href="javascript: jQuery.facebox({ajax:'affiliate.php'});">
	<?php } else { ?>
	<a href="javascript: jQuery.facebox({ajax:'affiliatenonuser.php'});">
	<?php
	}
	?><u><strong>Sign up</strong></u></a> to our Affiliate Program<br /><br />

<strong>Step 2:</strong> 
<a href="javascript: jQuery.facebox({ajax:'affiliate_login.php'});"><u><strong>Login</strong></u></a> to your affiliate account and get the banners and links<br /><br />

<strong>Step 3:</strong> Place the links on your website and start selling<br /><br />

						</div>
					</div>
					
					<div class="support_head">Affiliate FAQ's</div>
					
					<div>
						<strong>1. How can I contact you for help regarding my affiliate account?</strong><br />
For any affiliate help or requests please Open a Support Ticket and we will respond to you within 24 hours or less.<br /><br />
 
<strong>2. How much does it cost to become an affiliate?</strong><br />
Nothing. It is absolutely free!<br /><br />
 
<strong>3. How and when will I be paid?</strong><br />
All payments will be made once a month. Payouts will be made via Paypal, Moneybookers, Bank Wire or Check once all sales has been verified and approved.<br /><br />
 
<strong>4. How can I keep track of my sales?</strong><br />
You can login to your affiliate account anytime and view stats like number of clicks, conversions, commissions, payment date etc.<br /><br />
 
<strong>5. Can I refer myself to buy a membership after becoming an affiliate?</strong><br />
No you cannot. You will not earn commission if you do so. Affiliates program is only for those interested in selling templates.<br /><br />
 
<strong>6. Can I open more than one affiliate account?</strong><br />
No. It is against our Terms of Service.<br /><br />
 
<strong>7. No. It is against our Terms of Service.</strong><br />
Yes. You can sell our templates on any number of websites. You need not signup for a new account for each website.<br /><br />
 
<strong>8. Can I become an affiliate if I live outside of the United States?</strong><br />
Yes. There are no restrictions.<br /><br />
					</div>
<?php
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
?>				
	<div><a href="javascript: jQuery.facebox({ajax:'affiliate.php'});"><img src="<?php echo IMG_PATH."affiliate_now.png";?>" alt="" /></a></div>
	<?php } else { ?>
	<div><a href="javascript: jQuery.facebox({ajax:'affiliatenonuser.php'});"><img src="<?php echo IMG_PATH."affiliate_now.png";?>" alt="" /></a></div>
	<?php
	}
	?>				
				</div>
				<!-- Middle Contents End -->
			</div>
		</div>
	</div>
	<!-- Middle Content Area End -->
<?php 
include "../includes/footer.php";
?>
