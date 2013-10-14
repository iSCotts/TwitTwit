<?php
include "../includes/header.php";
include '../classes/dbClient.php';
include "../common/EpiCurl.php";
include "../common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){
  $refuser123 = $_SESSION["username"];
  $sqlsubs = "SELECT *  FROM ta_users WHERE UserName ='$refuser123'";
  $GetSubscriberscount = runQuery($sqlsubs);
  $refuser = $GetSubscriberscount[0]["RefID"];
// Delete user 
//if(isset($_REQUEST["uid"]) && ($_REQUEST["uid"] !="")){
if(isset($_REQUEST["act"]) && ($_REQUEST["act"] =="d"))
{
	//$sql = "DELETE  FROM ta_users WHERE UserID='$_REQUEST[uid]'"; 
	$sql = "DELETE a.*,b.*,c.*,d.* FROM `ta_users` a LEFT JOIN `ta_user_subscriptions` b ON a.`UserName` = b.`UserName` LEFT JOIN `ta_user_keys` c ON a.`UserName` = c.`Username` LEFT JOIN `ta_group_member_profile` d ON a.`UserName` = d.`memberName` WHERE a.`UserID`='$_REQUEST[uid]'"; 
	$GetAdminUserlist = runQuery($sql);
	if($GetAdminUserlist  ==1)
	{
		$Message = "Problem while deleting ";
	}
	else
	{
		$Message = "User Deleted Successfully";
	}
}
 if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==1)){
 $Message ="<div class=error>The Twitter username and password are not correct</div>";
 }
 if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==2)){
  $Message ="<div class=green>The Twitter account has been added</div>";
 }  
 if(isset($_REQUEST["act"]) && ($_REQUEST["act"] ==3)){
  $Message = "<div class=error>This Twitter account has already been used</div>";
  }
  ?>
 <!-- Middle Content Area Start -->
	<div class="middle_main">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="bx_mid">
			<div class="inner_middle_cont">
				<!-- Middle Contents Start -->
				<div class="innermain_head">
					<div class="innermain_head01"><h1>Add Multiple Twitter Accounts</h1></div>
					<!-- <div class="innermain_pause01"><a href="add_account">Add Mutiple Accounts</a></div>-->
				</div>
				<div class="middlecont_01_inner">
						<div class="innermid_top"></div>
					<div class="innermid_mid">
						<!-- Inner Page Main Content Start -->
						<div class="subhead_main">
							<div class="subhead_main_head"><h1>Your Twitter Accounts</h1></div>
							<!--  <div class="clear"></div>-->
						</div>
						<div class="cont_form_inner">
							<!-- Followers Area Start -->
							<div class="editaccounts">
								<div class="followers_top">
									<div class="followers_left"></div>
									<div class="followers_middle">
										<div class="followers_middle06">Twitter Username</div>
										<div class="followers_middle04">&nbsp;</div>
										<div class="followers_middle05">Actions</div>
										<div class="clear"></div>
									</div>
									<div class="followers_right"></div>
									<div class="clear"></div>
								</div>
						<?php
 						$sql = "SELECT * FROM ta_users WHERE RefID ='$refuser' ";
						$GetAdminUserlist = runQuery($sql);
						$i=1;
						for($k=0;$k<count($GetAdminUserlist);$k++){
						 ?>
							<!-- Feed 2 Start -->
								<div class="account_01">
									<div class="feed_name"><?php print $GetAdminUserlist[$k]["UserName"] ?></div>
									<div class="feed_url">&nbsp;</div>
								<!--	<div class="feeds_close"><a href=?act=e&uid=<?php print $GetAdminUserlist[$k]["UserID"] ?>><img src="../images/edit.jpg" title="Edit" alt="" /></a></div>-->
									
									<?php 
									if($_SESSION["username"] != $GetAdminUserlist[$k]["UserName"])
									{
									$sql_org = "SELECT min(`UserID`) as minuser FROM ta_users WHERE RefID ='$refuser'";
									$GetAdmin_org = runQuery($sql_org);
									if($GetAdminUserlist[$k]["UserID"]!=$GetAdmin_org[0]['minuser'])
									{
									?>
									<div class="feeds_close"><a href=?act=d&uid=<?php print $GetAdminUserlist[$k]["UserID"] ?>><img src="<?php echo IMG_PATH."close.png";?>" title="Delete" alt="Del" /></a></div>
									
									<?php } 
									}
									 ?>
									<div class="clear"></div>
								</div>
								<!-- Feed 2 End -->
						<?php
						$i++;
						 }
						 ?></div>
					
<div class="forms02">
	<?php print $Message; ?>
</div>
		 <?php
$dkPackage 			= dkGetPackagedetails($refuser123);
$dkGetNoAdd     	= dkGetNoAddons($refuser); 
if($dkGetNoAdd >= $dkPackage['twitterAcc'])
{
echo	$Message='<div class=error>You have created '.$dkGetNoAdd.' accounts and your Twitter Account limit is over.<a href="upgrade"> Please upgrade your account.</a></div>';
}
else{
?>														
<div class="forms02">
	Please logout from your twitter account.
</div>								
<div class="forms02">								
		<div class="inner_title">&nbsp;</div>
		<div class="account_title">
		<a href="<?php print $twitterObj->getAuthenticateUrl(); ?>">
			<img src="<?php echo IMG_PATH."sign_in_twitter.gif";?>" alt="Sign in with Twitter">
		</a>
	</div>
</div>
<?php 
}
?>
							<div class="clear"></div>
						</div>
						<!-- Inner Page Main Content End -->
						<div class="clear"></div>
					</div>
					<div class="innermid_btm"></div>
					
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
	 
	 
	 
	