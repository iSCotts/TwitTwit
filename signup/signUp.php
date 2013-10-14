<?php
session_start();
$user_name='';
$user_email='';
$_SESSION['pack']=$_REQUEST['pack'];
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
$packages=getPackagedetails($_REQUEST['pack']);
$price=$_REQUEST['price'];
if(isset($_SESSION["affiliateid"]))
{
if(intval($_SESSION["affiliateid"]))
{
 $affiliateid=$_SESSION["affiliateid"];
 $sql = "select * from ta_user_subscriptions where SubsID='".$_SESSION["affiliateid"]."' AND status='N' ";
 $sqlq=  runQuery($sql);
 if(count($sqlq)==0)
 {
 	unset($_SESSION["affiliateid"]);
 }
 else{
 	$user_name=$sqlq[0]['UserName'];
	$user_email=$sqlq[0]['Email'];
 }
 }
}
?>
<head>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var xmlhttp;
function validate(theform)
{
xmlhttp=GetXmlHttpObject();

var pack = theform.pack.value;
var custom = theform.custom.value;


if(theform.os0.value=="")
{
	document.getElementById('userlbl').innerHTML="Username required";
	document.getElementById('userlbl').style.visibility = 'visible';
	theform.os0.focus();
	return false;
	}
document.getElementById('userlbl').innerHTML = "";
document.getElementById('userlbl').style.visibility = 'hidden';
if(theform.os1.value=="")
{
	document.getElementById('emaillbl').innerHTML="Email required";
	document.getElementById('emaillbl').style.visibility = 'visible';
	theform.os1.focus();
	return false;
	}
document.getElementById('emaillbl').innerHTML = "";
document.getElementById('emaillbl').style.visibility = 'hidden';
if(!checkEmail(theform))
{
document.getElementById('emaillbl').innerHTML = "Invalid email address";
document.getElementById('emaillbl').style.visibility = 'visible';
theform.os1.focus();
return false;
	}
	document.getElementById('emaillbl').style.visibility = 'hidden';
	document.getElementById('emaillbl').style.visibility = '';
if(xmlhttp==null)
  {
  alert("Browser does not support HTTP Request");
  return;
  }
var url="signup/getuser.php";
url=url+"?name="+theform.os0.value;
url=url+"&email="+theform.os1.value;
url=url+"&pack="+pack;
url=url+"&custom="+custom;
 

xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}
function stateChanged()
{
	if(xmlhttp.readyState==4)
	{
		var temp = xmlhttp.responseText.split('|');
		if(temp.length<2)
		{
 			document.getElementById('result').innerHTML="System Error, please try again after some time.";
		}
		else
		{
			if(temp[0] == 'error')
			{
				document.getElementById('result').innerHTML=temp[1];
			}
			else
			{
				document.paypaltest.custom.value=temp[1];
				document.paypaltest.submit();
			}
		}
	}
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

function checkEmail(theform) 
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(theform.os1.value)){
		return (true)
	}
	return (false)
}	
</script>
</head>
<body>
<?php
if($packages[0]['monPrice']!=""){
	print "<br><h3 style='color:#fff'>{$packages[0]['packageName']} : {$price}</h3>";
	print "<span style='color:#fff'>{$packages[0]['packageDesc']}</span>";

}else{
	print "<br><h3 style='color:#fff'>4 Day Free Trial</h3>";
}
?>
<br />
<div id="result" style="color:#fff000"></div>
<br />
<?php $buttonid =$_REQUEST['buttonid'];?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypaltest">
<input type="hidden" name="cmd" value="_s-xclick">
  <input type="hidden" name="hosted_button_id" value="<?php print $buttonid; ?>">  

<?php 
if(isset($affiliateid) && ($affiliateid != ""))
{
	?>
	
	
	<!-- <input type="hidden" name="custom" value="<?php print  $affiliateid."!".rand(); ?>" /> -->
	<input type="hidden" name="custom" value="<?php echo  $affiliateid; ?>" />
	<?php 
}
else
{
	//$tokenaa = md5(uniqid(rand(),1));
	
	?>
	<!-- <input type="hidden" name="custom" value="<?php print $tokenaa."!".rand(); ?>" />-->
	<input type="hidden" name="custom" value="" />
	<?php 
}
?>
 
 
 
<input type="hidden" name="pack" value="<?php print $_REQUEST["pack"]; ?>" />
 
 
	
	
	
<input name="cbt"
	value="Return To twitjix.com" type="hidden">
<div class="face_formdiv01">
	<div class="face_titlepackage"><input type="hidden" name="on0"  value="Twitter Username">Twitter Username</div>
	<div class="face_txtbx"><input type="text" name="os0" class="txtbx_face" value=<?php echo $user_name;?>></div>
		<div class="clear"></div>
</div>
<div id="userlbl" class="emailerror"></div>

<div class="face_formdiv01">
	<div class="face_titlepackage"><input type="hidden" name="on1" value="Email">Email</div>
	<div class="face_txtbx"><input type="text" name="os1" class="txtbx_face" value=<?php echo $user_email;?>></div>
	<div class="clear"></div>
</div>
<div id="emaillbl" class="emailerror"></div>

 

<div class="face_packagediv01">
	<!-- <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit"  alt="PayPal - The safer, easier way to pay online!"  onclick="validate(document.paypaltest)"> -->
	
  <!-- <img src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif"   onclick="validate(document.paypaltest)">-->  

<img src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif"   onclick="validate(document.paypaltest)"   style="cursor:pointer"/>
	 
	
</div>
<div class="face_packagediv03">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</div>
</form>
