<?php
include_once "../includes/header.php";
include_once "../classes/dbClient.php";
include_once "../config/config.php";
include_once "../common/EpiCurl.php";
include_once "../common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
$txn_id=$_REQUEST['tx'];
?>
<script type="text/javascript">
 /*    setTimeout("redirect()", 15000);
	 function redirect()
	 {
	window.location="http://www.twitjix.com/index.php";
	 }*/
	</script>
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="inner_middle_cont">
				<!-- Middle Contents Start -->
							
				<div class="middlecont_01_inner">
				
					<div class="innermid_top"></div>
					<div class="innermid_mid">
						<!-- Inner Page Main Content Start -->
				      <div class="cont_form_inner">
					     <div style="text-align:center">
						 	<p style="font-size:24px; font-weight:bold; padding:20px 0 20px 0;">Thank you for Signing Up with twitjix.com</p>
							<p  style="font-size:16px;">Transaction id of your subscription is <?php echo $txn_id; ?></p>
							<p style="font-size:24px; font-weight:bold; padding:20px 0 20px 0;">You may login with twitjix.com</p>
							<p style="padding:15px 0 0 0;"><a href="<?php print $twitterObj->getAuthenticateUrl(); ?>"><img src="<?php echo FACEBX_PATH.'sign_in_twitter.gif' ?>" alt="Sign in with Twitter" /></a></p>
						 </div>
					  </div>
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
<!-- Google Code for Sign Up Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1005658861;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "dXvrCPO45QEQ7cXE3wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1005658861/?label=dXvrCPO45QEQ7cXE3wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
	
	<!-- Footer Container Start -->
<?php
include "../includes/footer.php";
?>
	<!-- Footer Container End -->
	
</div>
<!-- Main Container End -->
</body>
</html>
