<?php
ob_start();
session_start();

$refuser123 = $_SESSION["username"];
$CampaignID = $_REQUEST["CampaignID"];


if($_SESSION["username"] != "" && $_SESSION["password"] !="" ){
	include "../includes/header.php";
	//-------------------
	$sqlsubs = "SELECT *  FROM ta_users WHERE UserName ='$refuser123'";
	 
	$GetSubscriberscount = runQuery($sqlsubs);
	$refuser = $GetSubscriberscount[0]["RefID"];

	//-------------------
	//   if(isset($_REQUEST["delete"]) && $_REQUEST["delete{


	 
	

?>

<script type="text/javascript">
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

function updatesettings(CampaignID,rowid)
{
	var freq_id = document.getElementById('freq_id').value;
	if(document.getElementById('repeat').checked == true){
		var repeat = 1;
		document.getElementById('repeat').value ="Checked";
		
		}
	if(document.getElementById('repeat').checked == false)
	{
		var repeat = 0;
		document.getElementById('repeat').value ="";
	}


	if(document.getElementById('random').checked == true){
		var random = 1;
		document.getElementById('random').value ="Checked";
		
		}
	if(document.getElementById('random').checked == false)
	{
		var random = 0;
		document.getElementById('random').value ="";
	}



	// call ajax 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="updateupdatetweetmessagesettings.php";
	url=url+"?Do=Save&freq_id="+freq_id+"&repeat="+repeat+"&random="+random+"&CampaignID="+CampaignID+"&rowid="+rowid+"";
 

	document.getElementById("Displaytweetsettingsstatus").innerHTML="Updating....";
	 
	xmlHttp.onreadystatechange=stateChangedupdatesettings;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);

}


function stateChangedupdatesettings() 
{ 
	 

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 

	 //split response 
	 var splitresult = xmlHttp.responseText.split("-");
		 
 
	var message = splitresult[0];
	var CampaignID = splitresult[1];
	var rowid = splitresult[2];
	
	//document.getElementById("displaybutton").innerHTML="<input type=button name=updatesettings value=updatesettings onclick=updatesettings('"+CampaignID+"')>";
	
	document.getElementById("Displaytweetsettingsstatus").innerHTML=message;
	}		 
}



function savesettings(CampaignID)
{

	 
var freq_id = document.getElementById('freq_id').value;
if(document.getElementById('repeat').checked == true){
	var repeat = 1;
	document.getElementById('repeat').value ="Checked";
	
	
	}
if(document.getElementById('repeat').checked == false)
{
	var repeat = 0;
	document.getElementById('repeat').value ="Checked";
}


if(document.getElementById('random').checked == true){
	var random = 1;
	document.getElementById('random').value ="Checked";
	
	}
if(document.getElementById('random').checked == false)
{
	var random = 0;
	document.getElementById('random').value ="";
}





// call ajax 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
var url="updatetweetmessagesettings.php";
url=url+"?Do=Save&freq_id="+freq_id+"&repeat="+repeat+"&random="+random+"&CampaignID="+CampaignID+"";


document.getElementById("Displaytweetsettingsstatus").innerHTML="Saving....";
 
xmlHttp.onreadystatechange=stateChangedsavesettings;
xmlHttp.open("POST",url,true);
xmlHttp.send(null);




}


function stateChangedsavesettings() 
{ 
	 

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 

	 //split response 
 
	 
	 var splitresult = xmlHttp.responseText.split("-");
		 
 
	var message = splitresult[0];
	var CampaignID = splitresult[1];
	var rowid = splitresult[2];

	
	document.getElementById("displaybutton").innerHTML="<input type=button name=updatesettings value=updatesettings onclick=updatesettings('"+CampaignID+"','"+rowid+"')>";
	
	document.getElementById("Displaytweetsettingsstatus").innerHTML=message;
	}		 
}




function loadEvent(tweetmessage,CampaignID,rowid) {
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
	  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" />"+tweetmessage+"</textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";


	  ni.appendChild(newdiv);
	  document.getElementById(tweetsid).style.border="none";
	  document.getElementById(tweetsid).readOnly = true;
	  document.getElementById(showid).innerHTML = '';
	  var removeid = "remove"+ids;
	  var saveid = "save"+ids;
	  var updateid = "update"+ids;
	  
	  
	  document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">Remove  </a>";
	  document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">update  </a>";

	  
	}



function saveElementwithrowid(divname,id,rowid)
{

	var tweetid = "tweets"+id;
	var showid = "show"+id;
	 
	var displaystatusid = "display"+id;

	document.getElementById(tweetid).style.border="none";
	document.getElementById(tweetid).readOnly = true;
	document.getElementById(showid).innerHTML = '';

	
	
	var tweetmessage = document.getElementById(tweetid).value;
	var CampaignID  = <?php print $CampaignID; ?>;
	 
	 xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  } 
		var url="updatetweetmessage.php";
	url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"";
	 

	document.getElementById(displaystatusid).innerHTML="Updating....";
		 
		xmlHttp.onreadystatechange=stateChangedupdateElement;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);
}


function updateElement(divname,id,rowid){
	var tweetid = "tweets"+id;
	var showid = "show"+id;

	var removeid = "remove"+id;
	var saveid = "save"+id;
	var updateid = "update"+id;
 
	var displaystatusid = "display"+id;
	
	document.getElementById(tweetid).style.border="medium solid black";
	document.getElementById(tweetid).readOnly = false;
	document.getElementById(showid).innerHTML = '';

	var divIdName = "my"+id+"Div";
	document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">Remove  </a>";
	document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowid(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">save  </a>";
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
 	
var tweetidf = "tweets"+result;

var displaystatusidf = 'display'+result;
var showidf = "show"+result;
 
document.getElementById(displaystatusidf).innerHTML="";

 



var removeid = "remove"+result;
var saveid = "save"+result;
var updateid = "update"+result;

var divIdName = "my"+result+"Div";
document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";
document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">update  </a>";
document.getElementById(saveid).innerHTML="";



 
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
var CampaignID  = <?php print $CampaignID; ?>;
 
 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="savetweetmessage.php";
url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"";
 

document.getElementById(displaystatusid).innerHTML="saving....";
	 
	xmlHttp.onreadystatechange=stateChangedsaveElement;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);

	

}


function stateChangedsaveElement() 
{ 
	 

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 

	 
//split id and inserted id 
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

var divIdName = "my"+result+"Div";
document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";
document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">update  </a>";
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
  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";


  ni.appendChild(newdiv);

  var removeid = "remove"+ids;
  var saveid = "save"+ids;
  var updateid = "update"+ids;
  
  
  document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElement(\'"+divIdName+"\','"+ids+"\')\">save  </a>";

  
}

function removeElement(divNum,id,rowid) {


	 // first remove from db and remove lement 
	 var tweetid = "tweets"+id;
var showid = "show"+id;
var displaystatusid = "display"+id;


  
var CampaignID  = <?php print $CampaignID; ?>;
 
 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="deletetweetmessage.php";
url=url+"?Do=Save&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"";
 

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


<tr>

	<td colspan="2">

	<table cellpadding="2" cellpadding="2">





		<!--  work area  -->
		<tr>
			<td colspan="2">
			<div id="myDiv"></div>
			</td>
		</tr>

		

		<tr>
			<td colspan="2" align="left">
			<input type="hidden" value="0" id="theValue" name="theValue" />
			<a href="javascript:;"
				onClick="addEvent();">Add</a></td>
		</tr>
		<?php 
		
			// get all tweet setting  by campaign id 
$getallsettingspop = "SELECT * FROM ta_save_tweets_settings WHERE CampaignID='$CampaignID'";
 $getallsettingspop = runQuery($getallsettingspop);
 
 if($getallsettingspop[0]["Repeat"] == 0)
 {
 $Repeatstatus = 	"";
 }
 else
 $Repeatstatus = 	"Checked";
 
 
 if($getallsettingspop[0]["Random"] == 0)
 {
 $Randomstatus = 	"";
 }
 else
 $Randomstatus = 	"Checked";
 
 
 
 ?>
 
		
		<tr><td>  Update Frequency  
    <select id="freq_id" name="freq_id">
  
  
   
<option value="1" <?php if($getallsettingspop[0]["Frequency"] == 1) print "Selected" ?>>Every hour</option>
<option value="2" <?php if($getallsettingspop[0]["Frequency"] == 2) print "Selected" ?>>Every 2 hours</option>
<option value="3" <?php if($getallsettingspop[0]["Frequency"] == 3) print "Selected" ?>>Every 3 hours</option>
<option value="6" <?php if($getallsettingspop[0]["Frequency"] == 6) print "Selected" ?>>Every 6 hours</option>
<option value="12" <?php if($getallsettingspop[0]["Frequency"] == 12) print "Selected" ?>>Every 12 hours</option>
<option value="24" <?php if($getallsettingspop[0]["Frequency"] == 24) print "Selected" ?>>Every 24 hours</option></select>
		</td>
		<td>Repeat<input type="checkbox" name="repeat" <?php  print $Repeatstatus?> id="repeat"></input>Random<input type="checkbox" <?php  print $Randomstatus?> name="random"  id="random"></input>
		<!-- <input type="button" name="savesettings" value="Savesettings" onclick="savesettings('<?php print $CampaignID; ?>');"></input> -->
		<div id="displaybutton"></div>
		<div id="Displaytweetsettingsstatus"></div>
		</td>
		</tr>
		
		<!--  work area  -->


	<?php 
		
			// get all tweet setting  by campaign id 
$getallsettings = "SELECT * FROM ta_save_tweets_settings WHERE CampaignID='$CampaignID'";
 $getallsettings = runQuery($getallsettings);
 
 if(count($getallsettings) == 1 )
 {
 	?>
 	<script type="text/javascript">
 	
 	document.getElementById("displaybutton").innerHTML="<input type=button name=updatesettings value=updatesettings onclick=updatesettings('<?php print $CampaignID; ?>','<?php print $getallsettings[0]["Id"]; ?>')>";
 	
 	</script>
 	
 	<?php 
 }
 else
 {
 	?>
 	<script type="text/javascript">
 	
 	document.getElementById("displaybutton").innerHTML="<input type=button name=savesettings value=Savesettings onclick=savesettings('<?php print $CampaignID; ?>')>";
 	
 	</script>
 	<?php 
 }
 
 ?>


	</table>
<script type="text/javascript">

	function updateCounter(maxlength,id,counter) {
 
		var field = document.getElementById(id);
		 
		var totalLength = field.value.length;
		if(totalLength >= maxlength) {
		field.value = field.value.substring(0, maxlength);
		}
		document.getElementById(counter).innerHTML = maxlength-field.value.length;
		}
</script>
	</td>

</tr>




	<?php
	
	// get all tweet messages frm save tweets table 
$getallmessages = "SELECT * FROM ta_save_tweets WHERE CampaignID='$CampaignID'";

 $getallmessagesresult = runQuery($getallmessages);
 
 
if(count($getallmessagesresult) >=1 )
{
	
	for($y=0;$y<count($getallmessagesresult);$y++){
		
		?>
		 
		<script type="text/javascript">
loadEvent('<?php print $getallmessagesresult[$y]["TweetMessage"] ?>','<?php print $getallmessagesresult[$y]["CampaignID"] ?>','<?php print $getallmessagesresult[$y]["id"] ?>');
		</script>
		
		
<?php 
 
	}
	
}



 


	include "../includes/footer.php";
}
else
{

	Header("Location:../index.php");


}
?>




