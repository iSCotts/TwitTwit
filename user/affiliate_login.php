<?php
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

function GetloginforAffiliate()
{
 document.getElementById("showaffiliatestatus").innerHTML="";
 document.getElementById("usernameid").innerHTML = '';
 var username  = document.getElementById("aff_username").value;
 var password  = document.getElementById("aff_password").value;
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
		// call ajax 
	xmlHttpforaffiliate=GetXmlHttpObject();
	if (xmlHttpforaffiliate==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="getaffiliatelogin.php";
	url=url+"?username="+username+"&pass="+password+"";
	document.getElementById("showaffiliatestatus").style.color="#FFFFFF";
	document.getElementById("showaffiliatestatus").innerHTML="Please Wait";
	xmlHttpforaffiliate.onreadystatechange=stateChangedGetloginforAffiliate;
	xmlHttpforaffiliate.open("GET",url,true);
	xmlHttpforaffiliate.send(null);	
	}
function stateChangedGetloginforAffiliate() 
{ 
if (xmlHttpforaffiliate.readyState==4 || xmlHttpforaffiliate.readyState=="complete")
 { 
 //split response 
	 if(xmlHttpforaffiliate.responseText == "yes"){
	  window.location='<?php echo AFF_PATH.'affnonuser' ?>';
	  }
	   if(xmlHttpforaffiliate.responseText == "no"){
	  document.getElementById("showaffiliatestatus").style.color="#990000";
	  document.getElementById("showaffiliatestatus").innerHTML="Invalid username or password,try again !";
	  }	    
	}		 
}
  </script>
  <div class="face_tophead">
	<div class="affiliate_h1"> Affiliate Login</div>
</div>
<div>
	<div class="face_formdiv">
		<div class="face_title">Name :</div>
		<div class="face_txtbx"><input type="text" class="txtbx_face" name="aff_username"   id="aff_username" /> </div>
		<div class="clear"></div>
	</div>
	<div  id="usernameid" style="padding:0 0 0 90px; color:#FF0000;"></div>
		<div class="face_formdiv">
		<div class="face_title">Password :</div>
		<div class="face_txtbx"><input type="password" class="txtbx_face" name="aff_password"   id="aff_password" /> </div>
		<div class="clear"></div>
	</div>
	<div  id="passwordid" style="padding:0 0 0 90px; color:#FF0000;"></div>
	<div class="face_formdiv01">
		<div class="face_title">&nbsp;</div>
		<div class="btn_facediv"><input class="btn_face" type="button" name="Submit" value="Sign In" onclick="GetloginforAffiliate();"></div>
		<div id="showaffiliatestatus" style="padding:10px 0 0 10px; float:left;"></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
