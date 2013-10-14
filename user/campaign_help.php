<?php
session_start();
include ('../classes/dbClient.php');
include "../common/sqlFunctions.php"; 
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
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
					<div class="innermain_head01" style="width:500px;"><h1>Campaigns - Help Video</h1></div>
					<div class="clear"></div>
				</div>
				<div class="middlecont_01_inner">
					<div class="innermid_top"></div>
					<div class="innermid_mid_campaign">
					
							<div style="height:20px";></div><object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/A1PdqR5kh0s?fs=1&amp;hl=en_US&amp;rel=0&amp;color1=0x006699&amp;color2=0x54abd6"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/A1PdqR5kh0s?fs=1&amp;hl=en_US&amp;rel=0&amp;color1=0x006699&amp;color2=0x54abd6" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object>
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
