<?php
ob_start();
session_start();
include "includes/header.php";
include "includes/left.php";
include "common/dbconfig.php";
include "common/sqlFunctions.php";
include_once('twitteroauth/twitteroauth.php');
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes"))
{
	db_connect();
	$phpdate = date('Y-m-d H:i:s');
	if(isset($_REQUEST['Add']))
	{
	$query = "SELECT * FROM `ta_user_keys` uk LEFT JOIN  `ta_user_subscriptions` us ON us.UserName=uk.UserName WHERE PackageID ='0'";
	$result2 	=@mysql_query($query);
	$TweetMessage=$_POST['insttweetmsg'];
	$campaignID='0';
	$appType = 'admin_posttweets';
	$comId = '0';
	$status     =  dkCreatStringWithShortUrls($campaignID,$appType,$comId,$TweetMessage);
	for($i=0;$i<mysql_num_rows($result2);$i++)
	{
	$result=mysql_fetch_array($result2);
	$username=$result['Username'];
	$loginkey=$result['key'];
	$loginpassword=$result['secretkey'];
	$type=$result['type'];
	$_SESSION['oauth_access_token'] =     $loginkey;
	$_SESSION['oauth_access_token_secret'] =  $loginpassword;
	$token  =   $_SESSION['oauth_access_token'];
	$secret =   $_SESSION['oauth_access_token_secret'];
	$schquery ="INSERT INTO `ta_adv_tweets_log` (`username`,`tweetmessage` ,`DT` ) VALUES ('$username','$status', '$phpdate')";
	mysql_query($schquery);
    db_close();
	if($type=='no')
	{
	try {
		$to = new TwitterOAuth($consumer_key, $consumer_secret, $token, $secret);
		$params     =   array('status' => $status);
		$do_dm      =   simplexml_load_string($to->oAuthRequest('http://twitter.com/statuses/update.xml', 'POST',$params));
		}
		catch(Exception $o )
		{
			print_r($o);
		}
	  }
	}
	 $resultstatus= "Tweet posted";
	}
	?>
<script language="javascript" type="text/javascript">
function validatepost1() {
	if(document.xyz.insttweetmsg.value=="")
	{
	alert("Please enter your message");
	document.xyz.insttweetmsg.focus();
	return false;
	}
return true;
}
function validatepost2() {
	if(document.xyz.schtweetmsg.value=="")
	{
	alert("Please enter your message");
	document.xyz.schtweetmsg.focus();
	return false;
	}
	if(document.xyz.frequency.value=="-1")
	{
	alert("Please select frequency");
	document.xyz.schtweetmsg.focus();
	return false;
	}
return true;
}

function updateCounterfirst() {
	var maxlength=139;
	var field=document.getElementById('insttweetmsg');
	var totalLength = field.value.length;
	document.getElementById('counter').innerHTML = maxlength-totalLength;
}
function updateCountersec() {
	var maxlength=139;
	var field=document.getElementById('schtweetmsg');
	var totalLength = field.value.length;
	document.getElementById('counter2').innerHTML = maxlength-totalLength;
}
function updateCounter(maxlength,id,counter) {
 
		var field = document.getElementById(id);
		 
		var totalLength = field.value.length;
		if(totalLength >= maxlength) {
		field.value = field.value.substring(0, maxlength);
		}
		document.getElementById(counter).innerHTML = maxlength-field.value.length;
		}
var xmlHttp;
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function loadEvent(tweetmessage,frequ,rowid,repeat,status) {
	  var ni = document.getElementById('myDiv');
	  var numi = document.getElementById('theValue');
	  var num = (document.getElementById("theValue").value -1)+ 2;
	  numi.value = num;
	  var divIdName = "my"+num+"Div";
	  var ids = num;
	  var tweetsid = "tweets"+ids;
	  var showid = "show"+ids;
	  var newdiv = document.createElement('div');
	  newdiv.setAttribute("id",divIdName); 
	  newdiv.innerHTML =    " <table cellpadding=2 cellspacing=5  width=735 border=1><tr><td colspan=2 align=center><div id=display"+ids+"></div><textarea class=\"textarea_editable\" name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" />"+tweetmessage+"</textarea><strong id=show"+ids+"></strong> </td> <td colspan=3 align=center width=350><font face=verdana size=2>"+status+"</td><td width=109 align=center><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";
	  ni.appendChild(newdiv);
	  document.getElementById(tweetsid).style.border="none";
	  document.getElementById(tweetsid).readOnly = true;
	  document.getElementById(showid).innerHTML = '';
	  if(repeat==1)
	{
		document.getElementById('repeat_div').innerHTML="<input type=\"checkbox\"  name=\"repeat\" id=\"repeat\"  checked/>"
	}
	else
	{
		document.getElementById('repeat_div').innerHTML="<input type=\"checkbox\"  name=\"repeat\" id=\"repeat\" />"
	}
	  var removeid = "remove"+ids;
	  var saveid = "save"+ids;
	  var updateid = "update"+ids;
	  document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">Remove  </a>";
	  document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+ids+"\','"+frequ+"\','"+rowid+"\','"+repeat+"\')\">Edit</a>";
  
	}
function saveElementwithrowid(divname,id,frequ,rowid,repeat)
{
	var tweetid = "tweets"+id;
	var showid = "show"+id;
	var displaystatusid = "display"+id;

	document.getElementById(tweetid).style.border="none";
	document.getElementById(tweetid).readOnly = true;
	document.getElementById(showid).innerHTML = '';

	var tweetmessage = document.getElementById(tweetid).value;
	var newfrequ=document.getElementById('frequency').value;
	if(document.getElementById('repeat').checked == true){
		var repeat = 1;
		document.getElementById('repeat').value ="Checked";
			}
	if(document.getElementById('repeat').checked == false)
	{
		var repeat = 0;
		document.getElementById('repeat').value ="";
	}
//	var newrepeat=document.getElementById('repeat').value;
	 xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  } 
		var url="adupdatetweetmessage.php";
	    url=url+"?Do=Save&tweetmessage="+tweetmessage+"&did="+id+"&rowid="+rowid+"&frequ="+newfrequ+"&repeat="+repeat+"";
	    document.getElementById(displaystatusid).innerHTML="Updating....";
		xmlHttp.onreadystatechange=stateChangedupdateElement;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);
}
function updateElement(divname,id,frequ,rowid,repeat){
	var tweetid = "tweets"+id;
	var showid = "show"+id;

	var removeid = "remove"+id;
	var saveid = "save"+id;
	var updateid = "update"+id;
 
	var displaystatusid = "display"+id;
	var fr1="";
	var fr2="";
	var fr3="";
	var fr4="";
	var fr5="";
	if(frequ=="00") fr1="selected=selected";
	if(frequ=="06") fr2="selected=selected";
	if(frequ=="12") fr3="selected=selected";
	if(frequ=="23") fr4="selected=selected";
	if(frequ=="168") fr5="selected=selected";
	document.getElementById(tweetid).style.border="medium solid black";
	document.getElementById(tweetid).readOnly = false;
	document.getElementById(showid).innerHTML = '';
	document.getElementById('freq_div').innerHTML ="<select name=frequency id=frequency><option "+fr1+" value=\"00\">Every hour</option><option "+fr2+" value=\"06\">Every 6 hours</option><option "+fr3+" value=\"12\">Every 12 hours</option><option "+fr4+" value=\"23\">Every 24 hours</option><option "+fr5+" value=\"168\">Every Week</option></select>";
	if(repeat==1)
	{
		document.getElementById('repeat_div').innerHTML="<input type=\"checkbox\"  name=\"repeat\" id=\"repeat\"  checked/>"
	}
	else
	{
		document.getElementById('repeat_div').innerHTML="<input type=\"checkbox\"  name=\"repeat\" id=\"repeat\" />"
	}
	var divIdName = "my"+id+"Div";
	document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">Remove  </a>";
	document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowid(\'"+divIdName+"\','"+id+"\','"+frequ+"\','"+rowid+"\','"+repeat+"\')\">Save  </a>";
	document.getElementById(updateid).innerHTML="";
}
function stateChangedupdateElement() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
	//split id and inserted id 
var splitresult = xmlHttp.responseText.split("-");
var result = splitresult[0];
var rowid = splitresult[1];
var frequ = splitresult[2];
var repeat = splitresult[3];
var tweetidf = "tweets"+result;
var displaystatusidf = 'display'+result;
var showidf = "show"+result;
document.getElementById(displaystatusidf).innerHTML="";
var removeid = "remove"+result;
var saveid = "save"+result;
var updateid = "update"+result;
var divIdName = "my"+result+"Div";
document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";
document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+frequ+"\','"+rowid+"\','"+repeat+"\')\">Edit </a>";
document.getElementById(saveid).innerHTML="";

	}		 
}
function djGetValue(id)
{
	if(document.getElementById(id))
	{
		return document.getElementById(id).value;
	}
	else
	{
		return '';
	}
}
function saveElement(divname,id)
{
var tweetid = "tweets"+id;
var showid = "show"+id;
var displaystatusid = "display"+id;
document.getElementById(tweetid).style.border="none";
document.getElementById(tweetid).readOnly = true;
document.getElementById(showid).innerHTML = '';
var tweetmessage = document.getElementById(tweetid).value;
var frequency = djGetValue('frequency');
if(document.getElementById('repeat').checked == true){
var repeat = '1';
document.getElementById('repeat').value ="Checked";
	}
if(document.getElementById('repeat').checked == false)
{
var repeat = '0';
document.getElementById('repeat').value ="";
}
	 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
var url="adsavetweetmessage.php";
url=url+"?Do=Save&tweetmessage="+tweetmessage+"&did="+id+"&frequency="+frequency+"&repeat="+repeat+"";
document.getElementById(displaystatusid).innerHTML="saving....";
	xmlHttp.onreadystatechange=stateChangedsaveElement;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);
}
function stateChangedsaveElement() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
var splitresult = xmlHttp.responseText.split("-");
var result = splitresult[0];
var tweetidf = "tweets"+result;
var displaystatusidf = 'display'+result;
var showidf = "show"+result;
document.getElementById(displaystatusidf).innerHTML="";
var removeid = "remove"+result;
var saveid = "save"+result;
var updateid = "update"+result;
var rowid = splitresult[1];
var frequ = splitresult[2];
var repeat = splitresult[3];
var divIdName = "my"+result+"Div";
document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";
document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+frequ+"\','"+rowid+"\','"+repeat+"\')\">Edit  </a>";
document.getElementById(saveid).innerHTML="";
	}		 
}
function addEvent() {
  var ni = document.getElementById('myDiv');
  var numi = document.getElementById('theValue');
  var num = (document.getElementById("theValue").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"Div";
  var ids = num;
  var tweetsid = "tweets"+ids;
  var showid = "show"+ids;
  var newdiv = document.createElement('div');
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2   border=0><tr> <td width=25% valign=top><font face=verdana size=2>&nbsp;</td><td><div id=display"+ids+"></div><textarea class=\"textarea_editable\" name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";
  ni.appendChild(newdiv);
  var removeid = "remove"+ids;
  var saveid = "save"+ids;
  var updateid = "update"+ids;
   document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElement(\'"+divIdName+"\','"+ids+"\')\">save  </a>";
 }
function removeElement(divNum,id,rowid) {
var tweetid = "tweets"+id;
var showid = "show"+id;
var displaystatusid = "display"+id;
 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="addeletetweetmessage.php";
url=url+"?Do=Save&did="+id+"&rowid="+rowid+"";
document.getElementById(displaystatusid).innerHTML="Deleting....";
xmlHttp.onreadystatechange=stateChangeddeleteElement;
xmlHttp.open("POST",url,true);
xmlHttp.send(null);
 var d = document.getElementById('myDiv');
 var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}
function stateChangeddeleteElement() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
   { 

	}		 
}
 </script>
<td height="380" align="center" valign="top">
<form name="xyz" id="xyz" action="posttweets.php"	method="post">
<table width="735" border="1" cellpadding="2" cellspacing="5" >
<tr>
		<td colspan="4" align="center" style="color:#006600;"><?php echo $resultstatus; ?></td>
	</tr>
<!--	<form name="addtweetfrm" id="addtweetfrm" action="posttweets.php"	method="post">
-->	<tr>
		<td colspan="4" align="center"><b>Instant Post</b></td>
	</tr>
	<tr>
		<td colspan="4" align="center"></td>
	</tr>
	<tr>
		<td width="165" class="label"> Message : </td>
		<td colspan="3">
		<div id="counter" name="counter"></div>
		<textarea name="insttweetmsg" id="insttweetmsg" class="textarea_editable" onkeypress="updateCounterfirst()" onkeyup="updateCounterfirst()"></textarea></td>
	</tr>
	<tr>
		<td colspan="4" align="center"><input type="submit" name="Add" id="Add" value="Post Now"  onclick="return validatepost1()"/></td>
	</tr>
</table>
<table width="735" border="0" cellpadding="2" cellspacing="5" >
	<tr>
	  <td colspan="6" align="center"><b>Scheduled Posts</b></td>
	  </tr>
	  <tr align="left">
	  <td width="331" align="center">Message </td> 
	  <td colspan="4" align="center">Status</td>
	  <td width="109" align="center"> Action </td>
	  </tr>
	  <tr><td></td></tr>
	 <tr align="left">
	  <td colspan="6" class="label">
  <div id="myDiv"> </div>
  <p><a href="javascript:;" onclick="addEvent();">Add Tweets</a></p></td>
	  </tr>
	  	<tr align="left">
	  <td class="label">Frequency:	    </td>
	  <td width="122" class="label">  <div id="freq_div">
	      <select name="frequency" id="frequency">
	        <option value="00">Every hour</option>
	        <option value="06">Every 6 hours</option>
	        <option value="12">Every 12 hours</option>
	        <option value="23">Every 24 hours</option>
	        <option value="168">Every Week</option>
	        </select>	
	      </div>	</td>
	  <td width="53" class="label">   Repeat&nbsp;&nbsp;	    <div id="repeat_div"><input type="checkbox"  name="repeat" id="repeat" />  </div></td>
   	  <td width="100" class="label">&nbsp;</td>
  	  </tr>
	<tr>
	  <td colspan="6" align="center"><!--<input type="submit" name="Addscheduled" id="Addscheduled" value="Post" onclick="return validatepost2()" />--></td>
	  </tr>
	  <input type="hidden" value="1" id="theValue" name="theValue" />
	</table>
  </form>
</td>
</tr>
<?php

	// get all tweet messages frm save tweets table 
	$getallmessages = "SELECT * FROM ta_adv_tweets";
	db_connect();
	$getallmessagesresult 	=@mysql_query($getallmessages);
	$rescount=mysql_num_rows($getallmessagesresult);
	for($y=0;$y<$rescount;$y++)
	{
	$msgresult=mysql_fetch_array($getallmessagesresult);
			?>
		<script type="text/javascript">
	     loadEvent('<?php echo $msgresult["tweetmessage"] ?>','<?php echo $msgresult["frequency"] ?>','<?php echo $msgresult["t_id"] ?>','<?php echo $msgresult["repeat"] ?>','<?php echo $msgresult["poststatus"] ?>');
		</script>
	<?php 
	}
db_close();
include "includes/footer.php";
}
else
{
	header("Location:index.php?act=3");
}
?>