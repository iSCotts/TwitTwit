<?php 
ob_start();
session_start();
if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {
include "../includes/header.php";
 ?>
	<!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="middle_cont">
				<!-- Middle Contents Start -->
				
				<div><h1>Tutorial</h1></div>
				<div class="middlecont_01">
					<div class="features_inner">
						<div class="features_inner_cont" >
						<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/A1PdqR5kh0s?fs=1&amp;hl=en_US&amp;rel=0&amp;color1=0x006699&amp;color2=0x54abd6"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/A1PdqR5kh0s?fs=1&amp;hl=en_US&amp;rel=0&amp;color1=0x006699&amp;color2=0x54abd6" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object>
						</div>
						<div class="clear"></div>
					</div>
					
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
