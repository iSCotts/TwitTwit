<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
$categoryrowid = $_REQUEST["id"];
	
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



function loadEvent(tweetmessage,categoryrowid,rowid) {
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
	  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr><td><div id=display"+ids+"></div><textarea cols=80 style=height:50px rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" />"+tweetmessage+"</textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

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
	var categoryrowid  = <?php print $categoryrowid; ?>;
	 
	 xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  } 
		var url="updatetweetmessage.php";
	url=url+"?Do=Save&tweetmessage="+tweetmessage+"&categoryrowid="+categoryrowid+"&did="+id+"&rowid="+rowid+"";
	 
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
var categoryrowid  = <?php print $categoryrowid; ?>;
 
 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="savetweetmessage.php";
url=url+"?Do=Save&tweetmessage="+tweetmessage+"&categoryrowid="+categoryrowid+"&did="+id+"";
 

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
  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2   border=0><tr> <td><div id=display"+ids+"></div><textarea cols=40 rows=2 style=height:50px name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

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

var categoryrowid  = <?php print $categoryrowid; ?>;
 
 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="deletetweetmessage.php";
url=url+"?Do=Save&categoryrowid="+categoryrowid+"&did="+id+"&rowid="+rowid+"";
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
 <td   align="center" valign="top">
 <table  cellpadding="2" cellspacing="0" border="0">
 <!--  work area  -->
		<tr>
			<td colspan="2">
			<div id="myDiv" style="height:auto"></div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="left">
			<input type="hidden" value="0" id="theValue" name="theValue" />
			<a href="javascript:;"
				onClick="addEvent();">Add</a></td>
		</tr>
		 <!--  work area  -->
		</table></td>
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
<?php
	// get all tweet messages frm save tweets table 
$getallmessages = "SELECT * FROM ta_category_tweet_messages WHERE categoryid='$categoryrowid'";
 $getallmessagesresult = runQuery($getallmessages);
if(count($getallmessagesresult) >=1 )
{
	for($y=0;$y<count($getallmessagesresult);$y++){
		?>
		<script type="text/javascript">
loadEvent('<?php print $getallmessagesresult[$y]["TweetMesasge"] ?>','<?php print $getallmessagesresult[$y]["categoryid"] ?>','<?php print $getallmessagesresult[$y]["id"] ?>');
		</script>
	
<?php 

	}
}
?>
<?php 	
include "includes/footer.php";
 }
 else
 {
 header("Location:index.php?act=3");
 }
 
 ?>
 
 
 