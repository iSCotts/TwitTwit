<?php
session_start();
include_once "../config/config.php";
?>
<script type="text/javascript">
 var xmlHttpforaffiliate;
 var xmlHttpforemailcheck;
 function CheckingEmailIdthere(un)
 {
 // call ajax 
	xmlHttpforemailcheck=GetXmlHttpObject();
	if (xmlHttpforemailcheck==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="checkemailid.php";
	url=url+"?usernamea="+un+"";
	xmlHttpforemailcheck.onreadystatechange=stateChangedCheckingEmailIdthere;
	xmlHttpforemailcheck.open("GET",url,true);
	xmlHttpforemailcheck.send(null);	
	//document.getElementById("showaffiliatestatus").innerHTML="Please Wait";
 }
function stateChangedCheckingEmailIdthere() 
{ 
if (xmlHttpforemailcheck.readyState==4 || xmlHttpforemailcheck.readyState=="complete")
 { 
	 //split response 
	 if(xmlHttpforemailcheck.responseText != 0)
	 {
	 document.getElementById("username").value=xmlHttpforemailcheck.responseText;
	  document.getElementById("username").readOnly = true;
	 }
	 else
	 {
	 
	 }
	 
	 //document.getElementById("username").value=
	//  document.getElementById("showaffiliatestatus").innerHTML="Saved";
//	  
	}		 
}


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



 function GetEmailforAffiliate()
{

 var susername = '<?php print $_SESSION[username]?>';
 document.getElementById("showaffiliatestatus").innerHTML="";
 document.getElementById("usernameid").innerHTML = '';
 
 
var username  = document.getElementById("username").value;

if(username == ''  ||  username == '0' ||  username.charAt(0) == ' ')
{
document.getElementById("usernameid").innerHTML = 'Email Should not empty';
			return false;
			
}

  
  if(username != "")
  {
  
  if(!checkEmail(username))
{
document.getElementById('usernameid').innerHTML = "Invalid email address";
document.getElementById('usernameid').style.visibility = 'visible';
//theform.os1.focus();
return false;
	}
	
	
	
  }
  
  
// call ajax 
	xmlHttpforaffiliate=GetXmlHttpObject();
	if (xmlHttpforaffiliate==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="getaffiliateuser.php";
	url=url+"?username="+username+"&susername="+susername+"";
	
	xmlHttpforaffiliate.onreadystatechange=stateChangedGetEmailforAffiliate;
	xmlHttpforaffiliate.open("GET",url,true);
	xmlHttpforaffiliate.send(null);	
	
	
	
    document.getElementById("showaffiliatestatus").style.color="#FFFFFF";
	document.getElementById("showaffiliatestatus").innerHTML="Please Wait";
}



function stateChangedGetEmailforAffiliate() 
{ 
	 

if (xmlHttpforaffiliate.readyState==4 || xmlHttpforaffiliate.readyState=="complete")
 { 

	 //split response 
	  
	 
	 if(xmlHttpforaffiliate.responseText == "yes"){
	  document.getElementById("showaffiliatestatus").style.color="#FFFFFF";
	  document.getElementById("showaffiliatestatus").innerHTML="Your affiliate request is being processed. Thank you.";
	  window.location='<?php echo AFF_PATH.'aff' ?>';
	  }
	   if(xmlHttpforaffiliate.responseText == "no"){
	  document.getElementById("showaffiliatestatus").style.color="#FF0000";
	  document.getElementById("showaffiliatestatus").innerHTML="EmailId Already Exists !";
	  }
	  
	  
	}		 
}



CheckingEmailIdthere('<?php print $_SESSION[username]; ?>');


 
 </script>
 
 
 
 
 
 

<div class="face_tophead">
	<div class="affiliate_h1">Become An Affiliate</div>
</div>

<div>
	<div class="face_formdiv">
		<div class="face_title">Email :</div>
		<div class="face_txtbx"><input type="text" class="txtbx_face" name="username"   id="username" /> </div>
		<div class="clear"></div>
	</div>
		<div  id="usernameid" style="padding:0 0 0 90px; color:#FF0000;"></div>
	<div class="face_formdiv01">
		<div class="face_title">&nbsp;</div>
		<div class="btn_facediv"><input class="btn_face" type="button" name="Submit" value="Submit" onclick="GetEmailforAffiliate();"></div>
		<div id="showaffiliatestatus" style="padding:10px 0 0 10px; float:left;"></div>
		<div class="clear"></div>
	</div>
	
	
	
	<div class="clear"></div>
	
	
	
	
</div>

<!--</form>-->
<!--
<br/>
<div class="form-row"><span class="label"> Username  </span> <input
	type="text" name="username" class="txtbx_face" value="" /></div>
<div class="form-row"><span class="label"> Password  </span> <input
	type="password" name="password" /></div>

<div class="form-row"><input class="submit" type="submit" name="login"
	value="Login"></div>
-->