<?php session_start();
$user_name=$_REQUEST['username'];
?>
<script language="javascript">
var xmlhttp;
var chk;
function emailfrmvalidate(theform)
{
xmlhttp=GetXmlHttpObject();
if(theform.emailtxt.value=="")
{
	document.getElementById('emaillbl').innerHTML="Email required";
	document.getElementById('emaillbl').style.visibility = 'visible';
	theform.emailtxt.focus();
	return false;
	}
document.getElementById('emaillbl').innerHTML = "";
document.getElementById('emaillbl').style.visibility = 'hidden';
if(!checkEmail(theform))
{
	document.getElementById('emaillbl').innerHTML = "Invalid email address";
	document.getElementById('emaillbl').style.visibility = 'visible';
	theform.emailtxt.focus();
	return false;
}
document.getElementById('emaillbl').style.visibility = 'hidden';
document.getElementById('emaillbl').style.visibility = '';
if(theform.follow_chk.checked==true)
{
   chk=theform.follow_chk.value;
}
else{
   chk=0;
}
if(xmlhttp==null)
  {
	  alert("Browser does not support HTTP Request");
	  return;
  }
 
var url="get_user_email.php";
url=url+"?email="+theform.emailtxt.value;
url=url+"&twitacc="+chk;
url=url+"&name="+theform.username.value;
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function stateChanged()
{
	if(xmlhttp.readyState==4)
	{
		var temp = xmlhttp.responseText;
		window.location="../inviter/inviter.php?username="+temp;
	}
}
function checkEmail(theform) 
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(theform.emailtxt.value))
	{
		return (true)
	}
	return (false)
}
function GetXmlHttpObject()
{
		if (window.XMLHttpRequest)
		{
		 		 // code for IE7+, Firefox, Chrome, Opera, Safari
		 		 return new XMLHttpRequest();
		 }
		if (window.ActiveXObject)
		{
				  // code for IE6, IE5
				  return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
}
</script>
<script type='text/javascript' src='../js/jquery_pop.js'></script>
<script type='text/javascript' src='../js/jquery.simplemodal_pop.js'></script>
<script type="text/javascript" src='../js/DD_belatedPNG_0.0.7a-min.js'></script>
<script>
DD_belatedPNG.fix('img, div, li');
</script>
<style type="text/css">
.new_txtbx_01 {
	padding:2px 0 0px 2px;
	width:180px;
	height:20px;
	background-color:#fff;
	border:1px solid #3B6F80;
	color:#193842;
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
</style>
<link href="../css/home.css" rel="stylesheet" type="text/css" />
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<form action="#" method="post" name="emailfrm">
<div style="text-align:center; width:550px; margin:0 auto;">
						<div style="text-align:center;"><img src="../images/twitacc_logo.png" alt=""></div>
						
						<div style="text-align:center; font-size:18px; padding:20px 0 10px 0;">A valid email address is required. Please enter one.  </div>
						<div style="padding:20px 0 0 0;">
							<div style="float:left; padding:0 0 0 110px;"><strong>Enter Your Email ID : &nbsp;</strong></div>
							<div style="float:left;"><input type="hidden" class="new_txtbx_01" name="username" value="<?php echo $user_name;?>"><input type="text" class="new_txtbx_01" name="emailtxt" value="">
							<div class="clear"></div>
						</div>
						<div id="emaillbl" style="text-align:center; font-size:12px; padding:1px 0 0 2px; color:#990000"></div>
						<div style="padding:20px 0 0 0;">
						<div style="text-align:center; padding:10px 0 0 7px;">follow@twitacc<input type="checkbox" name="follow_chk" checked="checked" value="twitacc_com"></div>
						<div class="clear"></div>
						</div>
						<div style="text-align:center; padding:20px 0 0 0;"><img src="../images/next.png" border="0" alt=""  onclick="emailfrmvalidate(document.emailfrm)"></div>
					</div>
</form>
