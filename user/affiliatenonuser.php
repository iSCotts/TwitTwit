<?php
session_start();
include_once "../config/config.php";
?>
<script type="text/javascript">
 var xmlHttpforaffiliate;
function GetXmlHttpObject()
{
var xmlHttpforaffiliate=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttpforaffiliate=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
	 xmlHttpforaffiliate=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
	 xmlHttpforaffiliate=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttpforaffiliate;
}
function checkEmail(theform) 
{
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(theform)){
		return (true)
	}
	return (false)
}	
function GetuserforAffiliate()
{
 document.getElementById("showaffiliatestatus").innerHTML="";
 document.getElementById("usernameid").innerHTML = '';
 var username  = document.getElementById("username").value;
 var password  = document.getElementById("password").value;
 var email  = document.getElementById("email").value;
 if(username == ''  ||  username == '0' ||  username.charAt(0) == ' ')
		{
		document.getElementById("usernameid").innerHTML = 'Name should not empty';
		return false;
		}
		document.getElementById("usernameid").innerHTML = '';
		document.getElementById('usernameid').style.visibility = 'none';
		 if(password == ''  ||  password == '0' ||  password.charAt(0) == ' ')
		{
		document.getElementById("passwordid").innerHTML = 'Password should not empty';
		document.getElementById('passwordid').style.visibility = 'visible';
		return false;
		}
		document.getElementById("passwordid").innerHTML = '';
		document.getElementById('passwordid').style.visibility = 'none';
		if(email=="")
		{
		document.getElementById('emailid').innerHTML = "Email should not empty";
		document.getElementById('emailid').style.visibility = 'visible';
		return false;
		}
		if(email != "")
		{
		if(!checkEmail(email))
		{
		document.getElementById('emailid').innerHTML = "Invalid email address";
		document.getElementById('emailid').style.visibility = 'visible';
		//theform.os1.focus();
		return false;
		}
		document.getElementById("emailid").innerHTML = '';
		document.getElementById('emailid').style.visibility = 'none';
	  }
 // call ajax 
	xmlHttpforaffiliate=GetXmlHttpObject();
	if (xmlHttpforaffiliate==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="getaffiliatenonuser.php";
	url=url+"?username="+username+"&email="+email+"&pass="+password+"";
	
	xmlHttpforaffiliate.onreadystatechange=stateChangedGetnameforAffiliate;
	xmlHttpforaffiliate.open("GET",url,true);
	xmlHttpforaffiliate.send(null);	
	document.getElementById("showaffiliatestatus").style.color="#FFFFFF";
	document.getElementById("showaffiliatestatus").innerHTML="Please Wait";
}
function stateChangedGetnameforAffiliate() 
{ 
if (xmlHttpforaffiliate.readyState==4 || xmlHttpforaffiliate.readyState=="complete")
 { 
 //split response 
	 if(xmlHttpforaffiliate.responseText == "yes"){
	  document.getElementById("showaffiliatestatus").style.color="#FFFFFF";
	  document.getElementById("showaffiliatestatus").innerHTML="Your affiliate request is being processed. Thank you.";
	  window.location='<?php echo AFF_PATH.'affnonuser' ?>';
	  }
	   if(xmlHttpforaffiliate.responseText == "no"){
	  document.getElementById("showaffiliatestatus").style.color="#FF0000";
	  document.getElementById("showaffiliatestatus").innerHTML="User name already exists !";
	  }	    
	}		 
}
  </script>
  <div class="face_tophead">
	<div class="affiliate_h1">Become An Affiliate</div>
</div>
<div>
	<div class="face_formdiv">
		<div class="face_title">Name :</div>
		<div class="face_txtbx"><input type="text" class="txtbx_face" name="username"   id="username" /> </div>
		<div class="clear"></div>
	</div>
	<div  id="usernameid" style="padding:0 0 0 90px; color:#FF0000;"></div>
		<div class="face_formdiv">
		<div class="face_title">Password :</div>
		<div class="face_txtbx"><input type="password" class="txtbx_face" name="password"   id="password" /> </div>
		<div class="clear"></div>
	</div>
	<div  id="passwordid" style="padding:0 0 0 90px; color:#FF0000;"></div>
	<div class="face_formdiv">
		<div class="face_title">Paypal Email :</div>
		<div class="face_txtbx"><input type="text" class="txtbx_face" name="email"   id="email" /> </div>
		<div class="clear"></div>
	</div>
		<div  id="emailid" style="padding:0 0 0 90px; color:#FF0000;"></div>
	<div class="face_formdiv01">
		<div class="face_title">&nbsp;</div>
		<div class="btn_facediv"><input class="btn_face" type="button" name="Submit" value="Submit" onclick="GetuserforAffiliate();"></div>
		<div id="showaffiliatestatus" style="padding:10px 0 0 10px; float:left;"></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
