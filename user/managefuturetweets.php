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


<!-- jQuery -->

<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->

<!-- required plugins -->
<script
	type="text/javascript" src="../js/date.js"></script>
<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.min.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script
	type="text/javascript" src="../js/jquery.datePicker.js"></script>

<!-- datePicker required styles -->

<link
	rel="stylesheet" type="text/css" media="screen"
	href="../css/datePicker.css">




<style>
/* located in demo.css and creates a little calendar icon
 * instead of a text link for "Choose date"
 */
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url(../images/iconDatePicker.gif) no-repeat;
}
 

a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}

/* makes the input field shorter once the date picker code
 * has run (to allow space for the calendar icon
 */
input.dp-applied {
	width: 140px;
	float: left;
}
</style>





 
 

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



function loadEvent(tweetmessage,dddate,CampaignID,rowid) {
	  var ni = document.getElementById('myDiv');
	  var numi = document.getElementById('theValue');
	  var num = (document.getElementById("theValue").value -1)+ 2;
	  numi.value = num;
	  var divIdName = "my"+num+"Div";
	  var ids = num;

	  var tweetsid = "tweets"+ids;
	  var showid = "show"+ids;
	  var dateid = "date1"+ids;

	  var displaydate = "displaydate"+ids;
	

	
	  
	  
	  var newdiv = document.createElement('div');
	  newdiv.setAttribute("id",divIdName);
	  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" />"+tweetmessage+"</textarea><strong id=show"+ids+"></strong> </td><td><div id=displaydate"+ids+"></div><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";
		

	  ni.appendChild(newdiv);


	  document.getElementById(displaydate).innerHTML="<input name=date1"+ids+" id=date1"+ids+" value="+dddate+" readonly>";


	  
	  document.getElementById(dateid).readOnly = true;
	  document.getElementById(tweetsid).style.border="none";
	  document.getElementById(tweetsid).readOnly = true;
	  document.getElementById(showid).innerHTML = '';
	  var removeid = "remove"+ids;
	  var saveid = "save"+ids;
	  var updateid = "update"+ids;
	  
	  
	  var dateidvalue = document.getElementById(dateid).value;
	  
	  document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">Remove  </a>";
	  document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\','"+dateidvalue+"\')\">update  </a>";

	  
	}




function saveElementwithrowid(divname,id,rowid)
{
	 
	var tweetid = "tweets"+id;
	var showid = "show"+id;
	 
	var displaystatusid = "display"+id;
	//var dateid = "date1"+id;
	//var dateid = document.getElementById(dateid).value;

	var dateidf = "date1"+id;

	var dateid = document.getElementById(dateidf).value;
	
 
 

	  
	 var displaydate = "displaydate"+id;
	  document.getElementById(displaydate).innerHTML="<input name=date1"+id+" id=date1"+id+" class=date-pick value="+dateid+">";

	  
	document.getElementById(dateidf).readOnly = true;
	
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
		var url="futureupdatetweetmessage.php";
	url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"&dateid="+dateid+"";
	 
 
	document.getElementById(displaystatusid).innerHTML="Updating....";
		 
		xmlHttp.onreadystatechange=stateChangedupdateElement;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);
}



function updateElement(divname,id,rowid,dateidvalue){
	var tweetid = "tweets"+id;
	var showid = "show"+id;

	var removeid = "remove"+id;
	var saveid = "save"+id;
	var updateid = "update"+id;
	var dateid = "date1"+id;
	var displaystatusid = "display"+id;


	//var dateid = document.getElementById(dateid).value;
	
	 var displaydate = "displaydate"+id;
	  document.getElementById(displaydate).innerHTML="<input name=date1"+id+" id=date1"+id+" class=date-pick value="+dateidvalue+">";
	  $('.date-pick').datePicker();
	  
	document.getElementById(dateid).readOnly = false;
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
var dateid = "date1"+result;


var dateid = document.getElementById(dateid).value;


var divIdName = "my"+result+"Div";
document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";
document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\','"+dateid+"\')\">update  </a>";
document.getElementById(saveid).innerHTML="";



 
	}		 
}




function saveElement(divname,id)
{
 
var tweetid = "tweets"+id;
var showid = "show"+id;
var dateid = "date1"+id;
 

var displaystatusid = "display"+id;

var dateid = document.getElementById(dateid).value;

var displaydate = "displaydate"+id;
document.getElementById(displaydate).innerHTML="<input name=date1"+id+" id=date1"+id+" value="+dateid+" readonly>";



 
 

//document.getElementById(displaydate).readOnly = true;

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
	var url="futuresavetweetmessage.php";
url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"&dateid="+dateid+"";
 

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
var dateid = "date1"+result;
document.getElementById(displaystatusidf).innerHTML="";

 
var dateid = document.getElementById(dateid).value;


var removeid = "remove"+result;
var saveid = "save"+result;
var updateid = "update"+result;
var rowid = splitresult[1];

var divIdName = "my"+result+"Div";
document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";
document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\','"+dateid+"\')\">update  </a>";
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
	  var displaydate = "displaydate"+ids;
	  
	  var newdiv = document.createElement('div');
	  newdiv.setAttribute("id",divIdName);
	  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top>	  <font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=displaydate"+ids+"></div> <div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";


 
					
	           

      
	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";

	 
	
	  ni.appendChild(newdiv);
	 

	  
	  var removeid = "remove"+ids;
	  var saveid = "save"+ids;
	  var updateid = "update"+ids;
	  
	  document.getElementById(displaydate).innerHTML="<input name=date1"+ids+" id=date1"+ids+" class=date-pick>";
	  document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElement(\'"+divIdName+"\','"+ids+"\')\">save  </a>";
	  $('.date-pick').datePicker();
	  
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
		var url="futuredeletetweetmessage.php";
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


 <script type="text/javascript"  charset="utf-8">
            $(function()
            {
				$('.date-pick').datePicker();
            });
		</script>
 


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
			<!--  work area  -->
			
			
			
		</table></td>

</tr>
		


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
$getallmessages = "SELECT * FROM  ta_future_tweet_messages WHERE CampaignID='$CampaignID'";

 $getallmessagesresult = runQuery($getallmessages);
 
 
if(count($getallmessagesresult) >=1 )
{
	
	for($y=0;$y<count($getallmessagesresult);$y++){
		
		?>
		 
		<script type="text/javascript">
loadEvent('<?php print $getallmessagesresult[$y]["TweetMessage"] ?>','<?php print $getallmessagesresult[$y]["Date"] ?>','<?php print $getallmessagesresult[$y]["CampaignID"] ?>','<?php print $getallmessagesresult[$y]["id"] ?>');
		</script>
		
		
<?php 
 
	}
	
}

?>



<?php 
 


	include "../includes/footer.php";
}
else
{

	Header("Location:../index.php");


}
?>

