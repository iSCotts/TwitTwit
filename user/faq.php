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
				
				<div><h1>FAQ</h1></div>
				
				<div class="middlecont_01">
					<div class="features_inner">
						<div class="features_inner_cont">
Fusce fermentum dapibus leo, vel sollicitudin diam malesuada id. Curabitur congue viverra nibh eu vestibulum Quisque ut risus eu sem euismod suscipit. Fusce fermentum dapibus leo, vel sollicitudin diam malesuada id. Curabitur congue viverra nibh eu vestibulum Quisque ut risus eu sem euismod suscipit Fusce fermentum dapibus leo, vel sollicitudin diam malesuada id. Curabitur congue viverra nibh eu vestibulum Quisque ut risus eu sem euismod suscipit.
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
