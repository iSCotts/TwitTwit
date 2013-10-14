<?php
ob_start();
session_start();
//include_once '../mail/sendMail.php';
 

//$email=$_SESSION['email'];
$payment_status = $_POST['payment_status'];
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
// get details 
$getdata = "SELECT * FROM ta_user_subscriptions WHERE Custom ='".$_REQUEST['custom']."'";
$getdataresult =  runQuery($getdata);
//	 print_r($getdataresult);
$email=$getdataresult[0]["Email"];
$_SESSION['username'] = $getdataresult[0]["UserName"];

if(isset($_SESSION['username'])||$_SESSION['username']!=""){
	include_once '../classes/dbClient.php';
	include_once '../common/sqlFunctions.php';
  	//sending mails automatically
	//$from="admin@twitjix.com";
	//$to=$_SESSION['username'];
	//$mailto=$email;
	//$replyto="admin@twitjix.com";
	//$mailsubject="Twitacc subscription confirmation";
	//$template=2;
	//sendtemplatemail($from,$to,$mailto,$replyto,$mailsubject,$template);
	/*$sql3 =  "SELECT * FROM ta_email_template WHERE status='Active' and t_id='1'";
    $gettempdetails3 = runQuery($sql3);
    if(file_exists("../mailtempl/".$gettempdetails3[0]["t_file"]))
				{
				//Output a line of the file until the end is reached
					$file2 = fopen("../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
                    $mcontent="Dear {$_SESSION['username']},\n"; 
						while(!feof($file2))
					    {
					    	 $mcontent.=fgets($file2);
					    }
						 fclose($file2);
				}
				else{
   $mcontent="Dear {$_SESSION['username']},\n"; 
   $mcontent.="Thank you for your subscription.";		
   $mcontent.="You can sign in to the site with the following URL "."\r\n";
   $mcontent.="www.twitjix.com/index.php "."\r\n";
   $mcontent.="Please provide your twitter username and password for login"."\r\n";
				}
	//for sending mail
	$headers = 'From:admin@twitjix.com'."\r\n" .
    'Reply-To: admin@twitjix.com'."\r\n" .
	 'X-Mailer: PHP/'.phpversion();
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject="Twitacc subscription confirmation";
	$body=$mcontent;
	$mailto=$email;
	mail($mailto, $subject, $body, $headers);
    
 */
	
	$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
	if($_REQUEST['login']=='Login'){
    	$username = $_REQUEST["username"];
		$password = $_REQUEST["password"];
		$dt=date('Y-m-d H:i:s');
		$url = "http://twitter.com/account/verify_credentials.json";
		addapistatinfo("signin","account/verify_credentials",$username, $dt); 
		$httpReq = curl_init();
		curl_setopt($httpReq, CURLOPT_URL, $url);
		curl_setopt($httpReq, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($httpReq, CURLOPT_USERPWD, $username . ':' . $password);

		$jsonret = curl_exec($httpReq);
		curl_close($httpReq);

		$data = json_decode($jsonret);

		if($data->screen_name == $username){
			$_SESSION["username"] = $username;
			$_SESSION["password"] = $password;
			// Check USer Name Exists In Users Table IF Not Insert in USer Table 
	$phpdate = date('Y-m-d H:i:s');
	$sql = "SELECT count(*) FROM ta_users WHERE UserName 	='$username'";

	$GetNoOfUsers = runQuery($sql);
	if ($GetNoOfUsers[0][0] == 0) {

		//-------------------
		$sqlsubs = "SELECT count(*) FROM ta_user_subscriptions WHERE UserName 	='$username'";

		$GetSubscriberscount = runQuery($sqlsubs);
		if ($GetSubscriberscount[0][0] == 0) {
			$refidcount = 0;
		} else {
			$sqlsubs = "SELECT * FROM ta_user_subscriptions WHERE UserName 	='$username'";
			$GetSubscriberscountvars = runQuery($sqlsubs);
			$refidcount = $GetSubscriberscountvars[0]["SubsID"];
		}


		//get Max  Ref id 
		//----------------------
		
		 $getmaxrefid = "SELECT MAX( `RefID` )FROM `ta_users`";
 		$getmaxrefidresult = runQuery($getmaxrefid);
 		 $refidvalue =  $getmaxrefidresult[0][0]+1;
 		
		 
		//-----------------------
		$sql = "INSERT INTO  `ta_users` (`RefID`, `UserName`, `Password`, `Email`, `DT`) VALUES ( '$refidvalue', '$username', password('$password'),'', '$phpdate');";
		$GetNoOfUsers = runQuery($sql);

		// Insert Empty Package ID in Subscription table 
		//-----------------------
		$sqlsubs = "INSERT INTO `ta_user_subscriptions` ( `UserName` ,`PackageID` ,`FeatureID` ,`DT`)VALUES (  '$username', '0', '0', '$phpdate')";
		$GetNoOfUserssqlsubs = runQuery($sqlsubs);

		$sql1 = "INSERT INTO `ta_user_keys` (`Username` ,`key` ,`secretkey`,`type`)VALUES ( '$username', '', '$password','yes')";

		$GetNoOfUsers = runQuery($sql1);
		
		 //insert into groupMembers table 
		$sqlmembers = "INSERT INTO `ta_group_member_profile` ( `memberName` ,`profileImage`,`memberLocation`,`profileDesc`,`memberUrl`)VALUES (  '$username', '$profileimage','$location','$description','$memberurl')";
		$GetNoOfmembers = runQuery($sqlmembers);
		    	}			
		//	addLoginUser($username,$password);
		//	header("Location: ../user/".$username);
			header("Location: ../user/home.php");
			exit;
		}
		else{
			header("Location:index.php?act=1");
			exit;
		}
	}
}else{
	header("Location:../index.php");
			exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>twitjix.com</title>
	<link href="../css/main.css" rel="stylesheet" type="text/css" />
	<link href="../facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<link href="facebox/faceplant.css" media="screen" rel="stylesheet" type="text/css" />-->

	<script src="../js/DD_belatedPNG_0.0.7a-min.js"></script>
	<script>
	   DD_belatedPNG.fix('img, div, li');
	</script>
	
	<script src="../js/jquery.js" type="text/javascript"></script>
	<script src="../facebox/facebox.js" type="text/javascript"></script>
	<script src="../js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loading_image : 'facebox/loading.gif',
			close_image   : 'facebox/closelabel.gif'
		  }) 
		})
	 </script>
	 <script type="text/javascript">
	 function validate(theform)
	 {
	 if(theform.username.value=="")
	 {
	 	document.getElementById('userlbl').innerHTML="Required";
	 	document.getElementById('userlbl').style.visibility = 'visible';
	 	theform.username.focus();
	 	return false;
	 	}
	 document.getElementById('userlbl').innerHTML = "";
	 document.getElementById('userlbl').style.visibility = 'hidden';
	 if(theform.password.value=="")
	 {
	 	document.getElementById('passlbl').innerHTML="Required";
	 	document.getElementById('passlbl').style.visibility = 'visible';
	 	theform.password.focus();
	 	return false;
	 	}
	 document.getElementById('passlbl').innerHTML = "";
	 document.getElementById('passlbl').style.visibility = 'hidden';
	 return true;
	 }
	</script>
</head>

<body>
<!-- Main Container Begin -->
<div class="main_container">

	<!-- Top Navigation Links Start -->
	<div class="top_navigation">
		<ul>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo 'class="current"';?> href="../index">Home</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'features_and_pricing.php')) echo 'class="current"';?> href="../features_and_pricing">Features &amp; Pricing</a></li><li>|</li>
			<li><a href="#">Terms</a></li><li>|</li>
			<li><a href="#">Contact</a></li>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- Top Navigation Links End -->
	<!-- Banner Area Start -->
	<div class="banner_area_inner">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="banner_mid_inner">
			<div class="banner_left_inner">
				<div><img src="../images/twitacc_logo.png" alt="" /></div>
			</div>
			
			<div class="banner_right_inner">
				<div class="caption_inner"><img src="../images/caption.png" alt="The Twitter Accelerator !" /></div>
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
			<div class="inner_middle_cont">
				<!-- Middle Contents Start -->
				<div class="innermain_head">
					<div class="innermain_head01"><h1></h1></div>
					</div>
				
				<div class="middlecont_01_inner">
				
					<div class="innermid_top"></div>
					<div class="innermid_mid">
						<!-- Inner Page Main Content Start -->
						<form id="basiclogin" method="post" action="" onsubmit="return validate(this);">
					    <div class="cont_form_inner">
							<div class="sign_in_main">
								<div class="sign_in_top"><div class="clear"></div></div>
								<div class="sign_in_mid">
									<div class="sign_in_head">
										<div class="sign_in_head01">Login</div>
										<div class="sign_in_head02"><a href="<?php print $twitterObj->getAuthenticateUrl(); ?>"><input
	src="http://www.twollo.com/images/Sign-in-with-Twitter-lighter.png"
	value="Login" type="image"></a></div>
										<div class="clear"></div>
									</div>
									<div class="sign_in_align">
										<div class="sign_in_title">User Name</div>
										<div class="sign_in_right"><input type="text" class="inner_txtbx_03" name="username" value="<?php echo $_SESSION['username']?>" /></div>
										<div class="clear"></div>
									</div>
									<div id="userlbl" class="emailerror"></div>
									<div class="sign_in_align">
										<div class="sign_in_title">Password</div>
										<div class="sign_in_right"><input type="password" class="inner_txtbx_03" name="password"   /></div>
										<div class="clear"></div>
									</div>
									<div id="passlbl" class="emailerror"></div>
									<div class="sign_in_align">
										<div class="sign_in_title">&nbsp;</div>
										<div class="sign_in_right"><input type="submit" name="login" value="Login"  class="inner_txtbtn_01" /></div>
										<div class="clear"></div>
									</div>
									</div>
								<div class="sign_in_btm"><div class="clear"></div></div>
								<div class="clear"></div>
							</div>
					    </div>
					    </form>
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
	
<!-- Footer Container Start -->
	<div class="footer">
		<div class="footer_left"><a href="#"><img src="../images/logo_footer.jpg" alt="" /></a></div>
		<div class="footer_right">
			<a href="index">Home</a>  |  
			<a href="features_and_pricing">Features &amp; Pricing</a>  |  
			<a href="#">Term</a>  |  
			<a href="#">Contact</a>  
			<br />
			Copyright &copy; 2010 twitjix.com.
		</div>
		<div class="clear"></div>
	</div>
	<!-- Footer Container End -->
	
