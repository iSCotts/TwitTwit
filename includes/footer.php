<?php
if($_SESSION["username"]!="" && $_SESSION["password"]!="" )
{
	?>
	<!-- Footer Container Start -->
	<div class="footer">
		<div class="footer_left"><a href="#"><img src="<?php echo IMG_PATH."logo_footer.jpg";?>" alt="" /></a></div>
		<div class="footer_right">
			<a href="<?php echo USR_PATH.'home' ?>">Home</a>  |  
			<a href="http://twitacc.uservoice.com" target="_blank">Request Feature</a>   |
			<a href="<?php echo SITE_URL.'terms' ?>">TOS</a>  |  
			<a href="<?php echo SITE_URL.'privacy_policy' ?>">Privacy Policy</a>   |
			<a href="<?php echo USR_PATH.'logout' ?>">Logout</a>  
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
<?php } else{?>
<!-- Footer Container Start -->
	<div class="footer">
		<div class="footer_left"><a href="#"><img src="<?php echo IMG_PATH."logo_footer.jpg";?>" alt="" /></a></div>
		<div class="footer_right">
			<a href="index">Home</a>  |
			<a href="http://www.twitter.com/twitacc_com" target="_blank">Follow us</a>  |
			<a href="<?php echo SITE_URL."privacy_policy" ?>">Privacy Policy</a>   |
			<a href="<?php echo SITE_URL."terms" ?>">Terms &amp; Conditions</a>  |
			<a href="<?php echo SITE_URL."sitemap" ?>">Site Map</a> |
			<a <?php  if(isset($_SESSION["aff_username"]))  {?> href="<?php echo AFF_PATH."affnonuser" ?>"  <?php }else{ ?> href="<?php echo USR_PATH.'affiliate_program' ?>"<?php } ?>>Affiliate Program</a>
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
<?php 	
}?>