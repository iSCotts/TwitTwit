<?php
if($_REQUEST["act"] == 1){
	$Mesasge =  "error username/password";
}
include_once '../classes/dbClient.php';
include_once "../common/EpiCurl.php";
include_once "../common/EpiOAuth.php";
$twitterObj = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET);
?>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function validate(theform)
{
if(theform.username.value=="")
{
	document.getElementById('userlbl').innerHTML="This field is required";
	document.getElementById('userlbl').style.visibility = 'visible';
	theform.username.focus();
	return false;
	}
document.getElementById('userlbl').innerHTML = "";
document.getElementById('userlbl').style.visibility = 'hidden';
if(theform.password.value=="")
{
	document.getElementById('passlbl').innerHTML="This field is required";
	document.getElementById('passlbl').style.visibility = 'visible';
	theform.password.focus();
	return false;
	}
document.getElementById('passlbl').innerHTML = "";
document.getElementById('passlbl').style.visibility = 'hidden';
return true;
}
	</script>

<form id="basiclogin" method="post" action="signin/d.php" onSubmit="return validate(this);">

<div class="face_tophead">
	<div class="face_h1">Sign In</div>
	<div class="face_link">
		<a href="<?php print $twitterObj->getAuthenticateUrl(); ?>"><img src="facebox/sign_in_twitter.gif" alt="Sign in with Twitter"></a>
	</div>
	<div class="clear"></div>
</div>

<div>
	<div class="face_formdiv">
		<div class="face_title">User Name :</div>
		<div class="face_txtbx"><input type="text" class="txtbx_face" name="username" value="" /></div>
		<div class="clear"></div>
	</div>
	<div id="userlbl" class="emailerror01"></div>
	<div class="face_formdiv01">
		<div class="face_title">Password :</div>
		<div class="face_txtbx"><input type="password" class="txtbx_face" name="password" value="" /></div>
		<div class="clear"></div>
	</div>
	<div id="passlbl" class="emailerror01"></div>
	<div class="face_formdiv01">
		<div class="face_title">&nbsp;</div>
		<div class="btn_facediv"><input class="btn_face" type="submit" name="login" value="Login" ></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

</form>





 