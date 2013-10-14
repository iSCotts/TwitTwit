<?php

ob_start();

session_start();

if ($_SESSION["username"] != "" && $_SESSION["password"] != "") {

	include "../includes/header.php";



	// 	Get REfID using username from users Table

	$getrefidusingusername ="SELECT * FROM ta_users WHERE UserName='$_SESSION[username]'";

	$getrefidusingusernameresult  = runQuery($getrefidusingusername);

	$refid = $getrefidusingusernameresult[0]["RefID"];

	// 	Get REfID using username from users Table



	

	if (isset ($_REQUEST['c'])) {

		$campainDetails = getCampaignUser($_REQUEST['c']);



		$campaignUser = explode('-', $campainDetails[0]['UserID']);

		$campaignUserCount = count($campaignUser);

		$userNames = array ();

		for ($i = 1; $i < $campaignUserCount; $i++) {

			$userFromDB = getUserName($campaignUser[$i]);

			if($userFromDB[0]['UserName']!="")

			{

			array_push($userNames, $userFromDB[0]['UserName']);

			}

		}

		$userNamesCount = count($userNames);



	} else {

		$campainDetails[0]['CampaignName'] = "New Campaign";

	}

?>

 <script type="text/javascript" src="../js/jquery.js"></script>

<script 	type="text/javascript" src="../js/date.js"></script>

<script 	type="text/javascript" src="../js/jquery.datePicker.js"></script>

<link 	rel="stylesheet" type="text/css" media="screen" 	href="<?php echo CSS_PATH.'datePicker.css' ?>">

<script	src="<?php echo JS_PATH.'jquery.validate.js' ?>" type="text/javascript"></script>

<script	src="<?php echo JS_PATH.'jquery.pagnation.js' ?>" type="text/javascript"></script>

<script src="<?php echo SRCH_PATH.'jquery.hotkeys.js' ?>" type="text/javascript"></script>

<script src="<?php echo SRCH_PATH.'searchFollow.js' ?>" type="text/javascript"></script>

<script src="<?php echo FACEBX_PATH.'facebox_big.js' ?>" type="text/javascript"></script>

<link href="<?php echo FACEBX_PATH.'facebox_big.css' ?>" media="screen" rel="stylesheet" type="text/css" /> 

<script type="text/javascript">

  jQuery(document).ready(function($) {

    $('a[rel*=facebox]').facebox({

   loading_image : '<?php echo FACEBX_PATH.'loading.gif' ?>',

   close_image   : '<?php echo FACEBX_PATH.'closelabel.gif' ?>'

    }) 

  })

//jQuery(document).ready(dkShortKeys); // this registers shortcut keys // old
//------------------------------------- new short cut keys -------------------------------------------
var dkKeySelFlag = 0;
function dkChangeSelStatus(obj)
{
	var allPageTags=obj.getElementsByTagName("input");
	for (i=0; i<allPageTags.length; i++) 
	{
		if(allPageTags[i].checked) 
		{
			if(dkKeySelFlag == 2)
			{
				allPageTags[i].checked='';
			}
		}
		else
		{
			if(dkKeySelFlag == 1)
			{
				allPageTags[i].checked='checked';
			}
		}
	}
}
jQuery(document).keydown(function(event) {
	if (event.keyCode == '16') 
	{
		 dkKeySelFlag=1;
	}
	else if (event.keyCode == '17') 
	{
		 dkKeySelFlag=2;
	}
	else 
	{
		 dkKeySelFlag=0;
	}
});
jQuery(document).keyup(function(event) {
	if (event.keyCode == '16') 
	{
		 dkKeySelFlag=0;
	}
	else if (event.keyCode == '17') 
	{
		 dkKeySelFlag=0;
	}
	else 
	{
		 dkKeySelFlag=0;
	}
});
//------------------------------------- new short cut keys -------------------------------------------

  </script>

<style>  .qp_counter { margin: 10px; } pre { margin: 20px 0 10px 0; background: #ccc !important; padding: 10px; } a.qp_disabled { color: #888; } </style> 





 <style>

 

 

 

 

/* located in demo.css and creates a little calendar icon

 * instead of a text link for "Choose date"

 */

a.dp-choose-date {

	float: left;

	width:23px;

	height:20px;

	padding: 0;

	margin:0 0 0 3px;

	display: block;

	text-indent: -2000px;

	overflow: hidden;

	background: url(../images/calender.jpg) no-repeat;

	float:left;

}



a.dp-choose-date.dp-disabled {

	background-position: 0 -20px;

	cursor: default;

}



/* makes the input field shorter once the date picker code

 * has run (to allow space for the calendar icon

 */

input.dp-applied {

	width: 70px;

	float: left;

	padding:2px 0 0 0px;

	height:17px;

	background-color:#fff;

	border:1px solid #3B6F80;

	color:#193842;

	font-size:12px;

	font-family:Verdana, Arial, Helvetica, sans-serif;

	float:left;

}

</style>

<script type="text/javascript">

var xmlHttp;



var xmlHttpkeyword;



var xmlHttpnew;



var xmlHttpforNorecordsavetweets;



var xmlHttpforNorecordfuturetweets;



var xmlHttpforplayandpause;





var xmlHttpforfeeds;







function GetXmlHttpObject()

{

var xmlHttpforplayandpause=null;

try

 {

 // Firefox, Opera 8.0+, Safari

 xmlHttpforplayandpause=new XMLHttpRequest();

 }

catch (e)

 {

 // Internet Explorer

 try

  {

	 xmlHttpforplayandpause=new ActiveXObject("Msxml2.XMLHTTP");

  }

 catch (e)

  {

	 xmlHttpforplayandpause=new ActiveXObject("Microsoft.XMLHTTP");

  }

 }

return xmlHttpforplayandpause;

}











function GetXmlHttpObject()

{

var xmlHttpforfeeds=null;

try

 {

 // Firefox, Opera 8.0+, Safari

 xmlHttpforfeeds=new XMLHttpRequest();

 }

catch (e)

 {

 // Internet Explorer

 try

  {

	 xmlHttpforfeeds=new ActiveXObject("Msxml2.XMLHTTP");

  }

 catch (e)

  {

	 xmlHttpforfeeds=new ActiveXObject("Microsoft.XMLHTTP");

  }

 }

return xmlHttpforfeeds;

}







function GetXmlHttpObject()

{

var xmlHttpforNorecordsavetweets=null;

try

 {

 // Firefox, Opera 8.0+, Safari

 xmlHttpforNorecordsavetweets=new XMLHttpRequest();

 }

catch (e)

 {

 // Internet Explorer

 try

  {

	 xmlHttpforNorecordsavetweets=new ActiveXObject("Msxml2.XMLHTTP");

  }

 catch (e)

  {

	 xmlHttpforNorecordsavetweets=new ActiveXObject("Microsoft.XMLHTTP");

  }

 }

return xmlHttpforNorecordsavetweets;

}















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





function GetXmlHttpObject()

{

var xmlHttpnew=null;

try

 {

 // Firefox, Opera 8.0+, Safari

 xmlHttpnew=new XMLHttpRequest();

 }

catch (e)

 {

 // Internet Explorer

 try

  {

	 xmlHttpnew=new ActiveXObject("Msxml2.XMLHTTP");

  }

 catch (e)

  {

	 xmlHttpnew=new ActiveXObject("Microsoft.XMLHTTP");

  }

 }

return xmlHttpnew;

}









</script>

 



<script type="text/javascript">


function reloaddata()

{

	var CampaignID = document.getElementById('CampaignID').value;
		// call ajax 

	xmlHttpkeyword=GetXmlHttpObject();

	if (xmlHttpkeyword==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="reloaddata.php";

	url=url+"?CamID="+CampaignID+"";

	xmlHttpkeyword.onreadystatechange=stateChangedreloaded;

	xmlHttpkeyword.open("GET",url,true);

	xmlHttpkeyword.send(null);	



}

function stateChangedreloaded()

{

if(xmlHttpkeyword.readyState==4)

{

document.getElementById('keywords').innerHTML=xmlHttpkeyword.responseText;
}

}

//up to here 

  



//added by divya on 8 april

function Getmassfollow(uname)

{

	// call ajax 

	xmlHttpformassfollow=GetXmlHttpObject();

	if (xmlHttpformassfollow==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="massfollow.php";

	url=url+"?name="+uname;

	document.getElementById("massfollowresult").innerHTML="Please wait....";

	xmlHttpformassfollow.onreadystatechange=stateChangemassfollow;

	xmlHttpformassfollow.open("GET",url,true);

	xmlHttpformassfollow.send(null);	



}



function stateChangemassfollow() 

{ 

if (xmlHttpformassfollow.readyState==4 || xmlHttpformassfollow.readyState=="complete")

 { 	 

	document.getElementById("massfollowresult").innerHTML=xmlHttpformassfollow.responseText;

	}		 

}

//end here

function updateplaypasuse(type,cid)

{



 



//	document.getElementById("DisplayCmapignPlayPauseStatus").innerHTML="<img src=../images/play.png title='Play The Campaign' alt='' onclick=updateplaypasuse('play','"+cid+"') >";

	

	// call ajax 

	xmlHttpforplayandpause=GetXmlHttpObject();

	if (xmlHttpforplayandpause==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="updateplaypause.php";

	url=url+"?type="+type+"&cid="+cid+"";

	xmlHttpforplayandpause.onreadystatechange=stateChangedupdateplaypasuse;

	xmlHttpforplayandpause.open("GET",url,true);

	xmlHttpforplayandpause.send(null);	



	

}







function stateChangedupdateplaypasuse() 

{ 

	 



if (xmlHttpforplayandpause.readyState==4 || xmlHttpforplayandpause.readyState=="complete")

 { 



	 //split response 

	//document.getElementById("DisplayCmapignPlayPauseStatus").innerHTML="<img src=../images/play.png title=Play The Campaign alt= onclick=updateplaypasuse('play','"+cid+"') >";



	 

	document.getElementById("DisplayCmapignPlayPauseStatus").innerHTML=xmlHttpforplayandpause.responseText;

		

				

		

	}		 

}





function loadallaccounts()

{

	var CampaignID = document.getElementById('CampaignID').value;





	// call ajax 

	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="loadallaccounts.php";

	url=url+"?Do=Save&CampaignID="+CampaignID+"";

	 

	

 



	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML="Loading....";

	 

	xmlHttp.onreadystatechange=stateChangedloadallaccounts;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);

	

	

}









function stateChangedloadallaccounts() 

{ 

	 



if (xmlHttpforNorecordfuturetweets.readyState==4 || xmlHttpforNorecordfuturetweets.readyState=="complete")

 { 



	 //split response 

	 var splitresult = xmlHttpforNorecordfuturetweets.responseText;



	 

	 

		

				

		

	}		 

}













function ShowNoRecordsForFutureTweets()

{



 

	var CampaignID = document.getElementById('CampaignID').value;



	// call ajax 

	xmlHttpforNorecordfuturetweets=GetXmlHttpObject();

	if (xmlHttpforNorecordfuturetweets==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="norecordsforfuturetweetss.php";

	url=url+"?Do=Save&CampaignID="+CampaignID+"";

	 

	

 



	document.getElementById("DisplayNoreecorsForfutureTweets").innerHTML="Loading....";

	 

	xmlHttpforNorecordfuturetweets.onreadystatechange=stateChangedShowNoRecordsForFutureTweetsF;

	xmlHttpforNorecordfuturetweets.open("POST",url,true);

	xmlHttpforNorecordfuturetweets.send(null);





	

}









function stateChangedShowNoRecordsForFutureTweetsF() 

{ 

	 



if (xmlHttpforNorecordfuturetweets.readyState==4 || xmlHttpforNorecordfuturetweets.readyState=="complete")

 { 



	 //split response 

	 var splitresult = xmlHttpforNorecordfuturetweets.responseText;

	 var out  = '';

	  



		if(xmlHttpforNorecordfuturetweets.responseText == "no"){

			

	 out +="<div  class=followers_data>";

	 out += "<div class=autotweet07 >No Tweet Messages  Found in Future  Tweets<input type=hidden name=testforfuturetweets id=testforfuturetweets>";

	// out +="<textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter('139', '"+tweetsid+"', '"+showid+"')\" class=textarea_editable  ></textarea><strong id=show"+ids+"></strong>";

	 out +="</div>";

	 out +="<div class=tick_red01>&nbsp;</div>";

	 out +="<div class=followers_data03>";



	// out +=	"<div style=float:left id=remove"+ids+"></div><div style=float:left id=save"+ids+"></div><div style=float:left id=update"+ids+"></div>";

	 out +=	"</div>";

	 out +=	"<div class=clear></div>";

	 out +="</div>";

	 	

	  



	 

	document.getElementById("DisplayNoreecorsForfutureTweets").innerHTML=out;

	document.getElementById("testforfuturetweets").value="no";





	//document.getElementById("random").checked =false;

	//document.getElementById("repeat").checked =false;

	



		}











		if(xmlHttpforNorecordfuturetweets.responseText == "yes"){

			

			 



			 

		 

			document.getElementById("DisplayNoreecorsForfutureTweets").innerHTML="<input type=hidden name=testforfuturetweets id=testforfuturetweets>";

			document.getElementById("testforfuturetweets").value="yes";

				}







		

				

		

	}		 

}













function ShowNoRecordsForSaveTweets()

{



 

	var CampaignID = document.getElementById('CampaignID').value;



	// call ajax 

	xmlHttpforNorecordsavetweets=GetXmlHttpObject();

	if (xmlHttpforNorecordsavetweets==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="norecordsforsavetweetss.php";

	url=url+"?Do=Save&CampaignID="+CampaignID+"";

	 

	

 



	document.getElementById("DisplayNoreecorsForsaveTweets").innerHTML="Loading....";

	 

	xmlHttpforNorecordsavetweets.onreadystatechange=stateChangedShowNoRecordsForSaveTweetsF;

	xmlHttpforNorecordsavetweets.open("POST",url,true);

	xmlHttpforNorecordsavetweets.send(null);





	

}





function stateChangedShowNoRecordsForSaveTweetsF() 

{ 

	 



if (xmlHttpforNorecordsavetweets.readyState==4 || xmlHttpforNorecordsavetweets.readyState=="complete")

 { 



	 //split response 

	 var splitresult = xmlHttpforNorecordsavetweets.responseText;



	 

	 var out  = '';



		if(xmlHttpforNorecordsavetweets.responseText == "no"){

			

	 out +="<div  class=followers_data>";

	 out += "<div class=autotweet07 >No Tweet Messages  Found in Save Tweets<input type=hidden name=testforsavetweets id=testforsavetweets>";

	// out +="<textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter('139', '"+tweetsid+"', '"+showid+"')\" class=textarea_editable  ></textarea><strong id=show"+ids+"></strong>";

	 out +="</div>";

	 out +="<div class=tick_red01>&nbsp;</div>";

	 out +="<div class=followers_data03>";



	// out +=	"<div style=float:left id=remove"+ids+"></div><div style=float:left id=save"+ids+"></div><div style=float:left id=update"+ids+"></div>";

	 out +=	"</div>";

	 out +=	"<div class=clear></div>";

	 out +="</div>";

	 	

	  



	 

 

	document.getElementById("DisplayNoreecorsForsaveTweets").innerHTML=out;

	document.getElementById("testforsavetweets").value="no";





	document.getElementById("random").checked =false;

	document.getElementById("repeat").checked =false;

	



		}











		if(xmlHttpforNorecordsavetweets.responseText == "yes"){

			

			 



			 

		 

			document.getElementById("DisplayNoreecorsForsaveTweets").innerHTML="<input type=hidden name=testforsavetweets id=testforsavetweets>";

			document.getElementById("testforsavetweets").value="yes";

				}







		

				

		

	}		 

}













function loadEventforfuturetweets(tweetmessage,dddate,CampaignID,rowid,Status) {

	  var ni = document.getElementById('myDivforfuturetweets');

	  var numi = document.getElementById('theValueforfuturetweets');

	  var num = (document.getElementById("theValueforfuturetweets").value -1)+ 2;

	  numi.value = num;

	  var divIdName = "my"+num+"Divforfuturetweets";

	  var ids = num;



	  var tweetsid = "ftweets"+ids;

	  var showid = "fshow"+ids;

	  var dateid = "fdateff"+ids;



	  var displaydate = "fdisplaydate"+ids;

	



	

	  

	  

	  var newdiv = document.createElement('div');

	  newdiv.setAttribute("id",divIdName);

//	  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" />"+tweetmessage+"</textarea><strong id=show"+ids+"></strong> </td><td><div id=displaydate"+ids+"></div><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";



	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";

		



	  var  out = ''; 

	  out +=" <div class=followers_data>";

	  out +="	<div class=autotweet05>";

	  out +=	"	<div style=float:left id=fdisplay"+ids+"></div><div style=float:left><textarea  cols=80 rows=4 name=ftweets"+ids+"  id=ftweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" class=textarea_editable01  >"+tweetmessage+"</textarea><strong id=fshow"+ids+"></strong> </div>";

	  out +="	</div>";

	  out +=	"<div class=tick_red02>&nbsp;</div>";

	  out +=	"<div class=autotweet06>";

	  out +=	"<div class=inner_boxes02><div id=fdisplaydate"+ids+"></div></div>";

	//  newdiv.innerHTML .=	"<div class=inner_link_00><a href=#><img src=../images/calender.jpg alt= /></a></div>";



	  out +="</div>";

	  out +="<div class=followers_data03>";

	  out +=	"<div style=float:left id=fremove"+ids+"></div><div style=float:left id=fsave"+ids+"></div><div style=float:left id=fupdate"+ids+"></div> ";

	  out +=	"</div>"

		  out +="	<div class=clear></div>";

		  out +="</div>";



		  newdiv.innerHTML = out;





		  

	  ni.appendChild(newdiv);





	  document.getElementById(displaydate).innerHTML="<input name=fdateff"+ids+" id=fdateff"+ids+" value="+dddate+" readonly>";





	  

	  document.getElementById(dateid).readOnly = true;

	  document.getElementById(tweetsid).style.border="none";

	  document.getElementById(tweetsid).readOnly = true;

	  document.getElementById(showid).innerHTML = '';

	  var removeid = "fremove"+ids;

	  var saveid = "fsave"+ids;

	  var updateid = "fupdate"+ids;

	  

	  

	  var dateidvalue = document.getElementById(dateid).value;

	  

	//  document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">Remove  </a>";

	 // document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\','"+dateidvalue+"\')\">update  </a>";



	 	 document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforfuturetweets(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\"><img src=../images/close.png>  </a>";

	if(Status =='N')

	{

	 document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElementforfuturetweets(\'"+divIdName+"\','"+ids+"\','"+rowid+"\','"+dateidvalue+"\')\"><img src=../images/edit.png>  </a>";

	 }

	 else

	 {

	 document.getElementById(updateid).innerHTML="<img src=../images/tweetc.png>";

	 }



		 



	  

	}











 

function loadtweetmessages(selectedids){



	// call ajax 

	xmlHttpnew=GetXmlHttpObject();

	if (xmlHttpnew==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="autoloadtweetmessages.php";

	url=url+"?Do=Save&selecetedarray="+selectedids+"";

 



	//  document.getElementById("Displaytweetsettingsstatusforcategorytweets").innerHTML="Updating....";

	 

	xmlHttpnew.onreadystatechange=stateChangedloadtweetmessagesforcategorytweets;

	xmlHttpnew.open("POST",url,true);

	xmlHttpnew.send(null);

}







function updatesettings1(rowid)

{

	var CampaignID = document.getElementById('CampaignID').value;
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
  //  var repeat=0;
	url=url+"?Do=Save&freq_id="+freq_id+"&repeat="+repeat+"&random="+random+"&CampaignID="+CampaignID+"&rowid="+rowid+"";

 



	document.getElementById("Displaytweetsettingsstatus").innerHTML="<div class=blue>Updating....</div>";

	 

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
//document.getElementById("Displaytweetsettingsstatus").innerHTML="saved";
	}		 

}













function loadEventforsavetweets(tweetmessage,CampaignID,rowid) {

	  var ni = document.getElementById('myDivforsavetweets');

	  var numi = document.getElementById('theValue');

	  var num = (document.getElementById("theValue").value -1)+ 2;

	  numi.value = num;

	  var divIdName = "my"+num+"Div";

	  var ids = num;



	  var tweetsid = "tweets"+ids;

	  var showid = "show"+ids;







	

	  

	  

	  var newdiv = document.createElement('div');

	  newdiv.setAttribute("id",divIdName);

	 // newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" />"+tweetmessage+"</textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";



	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";



var out  = '';

out +="<div class=followers_data>";

out += "<div class=autotweet07><div id=display"+ids+"></div>";

out +="<textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter('139', '"+tweetsid+"', '"+showid+"')\" class=textarea_editable  >"+tweetmessage+"</textarea><strong id=show"+ids+"></strong>";

out +="</div>";

out +="<div class=tick_red01>&nbsp;</div>";

out +="<div class=followers_data03>";



out +=	"<div style=float:left id=remove"+ids+"></div><div style=float:left id=save"+ids+"></div><div style=float:left id=update"+ids+"></div>";

out +=	"</div>";

out +=	"<div class=clear></div>";

out +="</div>";

	

newdiv.innerHTML =out;







	  ni.appendChild(newdiv);

	  document.getElementById(tweetsid).style.border="none";

	  document.getElementById(tweetsid).readOnly = true;

	  document.getElementById(showid).innerHTML = '';

	  var removeid = "remove"+ids;

	  var saveid = "save"+ids;

	  var updateid = "update"+ids;

	  

	  

	 // document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">Remove  </a>";

	 // document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\">update  </a>";



	 

	  document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\"><img style=float:left; padding:0 0 0 7px; src=../images/edit.png alt= title=Update />  </a>";

	  document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforsavetweets(\'"+divIdName+"\','"+ids+"\','"+rowid+"\')\"><img style=float:left; padding:0 0 0 7px; src=../images/close.png alt= title=Remove />  </a>";



		 



	  

	}


function removeElementforfuturetweets(divNum,id,rowid) {





	 // first remove from db and remove lement 

	 var tweetid = "ftweets"+id;

var showid = "fshow"+id;

var displaystatusid = "fdisplay"+id;





 

var CampaignID  = document.getElementById('CampaignID').value;



xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="futuredeletetweetmessage.php";

url=url+"?Do=Save&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"";





document.getElementById(displaystatusid).innerHTML="<div class=blue>Deleting....</div>";

	 

	xmlHttp.onreadystatechange=stateChangedremoveElementforfuturetweets;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





	

 var d = document.getElementById('myDivforfuturetweets');

 var olddiv = document.getElementById(divNum);

 d.removeChild(olddiv);

}





function stateChangedremoveElementforfuturetweets() 

{ 

	 



if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

{ 



	 

	ShowNoRecordsForFutureTweets();



	}		 

}













function saveElementwithrowidforfuturetweets(divname,id,rowid)

{



	 

	var tweetid = "ftweets"+id;

	var showid = "fshow"+id;

	 

	var displaystatusid = "fdisplay"+id;

	//var dateid = "date1"+id;

	//var dateid = document.getElementById(dateid).value;



	var dateidf = "fdateff"+id;

var tempdateid = "fdateff"+id;



	var dateid = document.getElementById(dateidf).value;





	var enteredtextvaluef = document.getElementById(tweetid).value;



	var entereddatevaluef = dateid;





	if(enteredtextvaluef == '' || enteredtextvaluef == '0' || !isNaN(enteredtextvaluef) || enteredtextvaluef.charAt(0) == ' ')

	{

		document.getElementById(tweetid).select;

		

		document.getElementById(tweetid).value = '' ;

		document.getElementById(displaystatusid).innerHTML = 'Tweet message  Should not empty';

		return false;

		

	}





	if(entereddatevaluef == '' || entereddatevaluef == '0' || !isNaN(entereddatevaluef) || entereddatevaluef.charAt(0) == ' ')

	{

		document.getElementById(tempdateid).select;

		

		document.getElementById(tempdateid).value = '' ;

		document.getElementById(displaystatusid).innerHTML = 'Date  Should not empty';

		return false;

		

	}





	

 

 



	  

	 var displaydateSAVEROW = "fdisplaydate"+id;

	//  document.getElementById(displaydate).innerHTML="<input name=date1"+id+" id=date1"+id+" class=date-pick value="+dateid+">";

	  document.getElementById(displaydateSAVEROW).innerHTML="<input name=fdateff"+id+" id=fdateff"+id+" class=date-pick value="+dateid+">";



	  

	document.getElementById(dateidf).readOnly = true;

	

	document.getElementById(tweetid).style.border="none";

	document.getElementById(tweetid).readOnly = true;

	document.getElementById(showid).innerHTML = '';



	

	

	var tweetmessage = document.getElementById(tweetid).value;

	var CampaignID  = document.getElementById('CampaignID').value;

	 

	 xmlHttp=GetXmlHttpObject();

		if (xmlHttp==null)

		  {

		  alert ("Browser does not support HTTP Request");

		  return;

		  } 

		var url="futureupdatetweetmessage.php";

	url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"&dateid="+dateid+"";

	 

 

	document.getElementById(displaystatusid).innerHTML="<div class=blue>Updating....</div>";

		 

		xmlHttp.onreadystatechange=stateChangedsaveElementwithrowidforfuturetweets;

		xmlHttp.open("POST",url,true);

		xmlHttp.send(null);

}









function stateChangedsaveElementwithrowidforfuturetweets() 

{ 

	 



if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 { 

	//split id and inserted id 

	//alert(xmlHttp.responseText);

	var splitresult = xmlHttp.responseText.split("-");

		 

 

	var result = splitresult[0];

	

 	var rowid = splitresult[1];

 	

var tweetidf = "ftweets"+result;



var displaystatusidf = 'fdisplay'+result;

var showidf = "fshow"+result;

 

document.getElementById(displaystatusidf).innerHTML="";



 







var removeid = "fremove"+result;

var saveid = "fsave"+result;

var updateid = "fupdate"+result;

var dateid = "fdateff"+result;





var dateid = document.getElementById(dateid).value;





var divIdName = "my"+result+"Divforfuturetweets";

//document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";

//document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\','"+dateid+"\')\">update  </a>";



document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforfuturetweets(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/close.png alt= />  </a>";

document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElementforfuturetweets(\'"+divIdName+"\','"+result+"\','"+rowid+"\','"+dateid+"\')\"><img src=../images/edit.png alt= />  </a>";







document.getElementById(saveid).innerHTML="";









 

	}		 

}

















function updateElementforfuturetweets(divname,id,rowid,dateidvalue){





	 

	var tweetid = "ftweets"+id;

	var showid = "fshow"+id;



	var removeid = "fremove"+id;

	var saveid = "fsave"+id;

	var updateid = "fupdate"+id;

	var dateidFU = "fdateff"+id;

	var displaystatusid = "fdisplay"+id;





	//var dateid = document.getElementById(dateid).value;

	

	// var displaydate = "fdisplaydate"+id;

	

	 var displaydateFU = "fdisplaydate"+id;



	 

	  document.getElementById(displaydateFU).innerHTML="<input name=fdateff"+id+" id=fdateff"+id+" class=date-picku value="+dateidvalue+">";

	 // $('.date-pick').datePicker();

	  $('.date-picku').datePicker();

	  

	document.getElementById(dateidFU).readOnly = false;

	document.getElementById(tweetid).style.border="medium solid black";

	document.getElementById(tweetid).readOnly = false;

	document.getElementById(showid).innerHTML = '';



	var divIdName = "my"+id+"Divforfuturetweets";

//	document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">Remove  </a>";

//	document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowid(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">save  </a>";



	document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforfuturetweets(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\"><img src=../images/close.png alt= />  </a>";

	document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowidforfuturetweets(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\"><img src=../images/save.png alt= />  </a>";

	

	document.getElementById(updateid).innerHTML="";

	



	



	



		

}







function saveElementforfuturetweets(divname,id)

{

	 

 

var tweetid = "ftweets"+id;

var showid = "fshow"+id;

var dateid = "fdateff"+id;

 

var tempdateid = "fdateff"+id;

var displaystatusid = "fdisplay"+id;



var dateid = document.getElementById(dateid).value;





var enteredtextvaluef = document.getElementById(tweetid).value;



var entereddatevaluef = dateid;





if(enteredtextvaluef == '' || enteredtextvaluef == '0' || !isNaN(enteredtextvaluef) || enteredtextvaluef.charAt(0) == ' ')

{

	document.getElementById(tweetid).select;

	

	document.getElementById(tweetid).value = '' ;

	document.getElementById(displaystatusid).innerHTML = 'Tweet message  Should not empty';

	return false;

	

}





if(entereddatevaluef == '' || entereddatevaluef == '0' || !isNaN(entereddatevaluef) || entereddatevaluef.charAt(0) == ' ')

{

	document.getElementById(tempdateid).select;

	

	document.getElementById(tempdateid).value = '' ;

	document.getElementById(displaystatusid).innerHTML = 'Date  Should not empty';

	return false;

	

}







var displaydateSAVE = "fdisplaydate"+id;

document.getElementById(displaydateSAVE).innerHTML="<input name=fdateff"+id+" id=fdateff"+id+" value="+dateid+" readonly>";







 

 



//document.getElementById(displaydate).readOnly = true;



document.getElementById(tweetid).style.border="none";

document.getElementById(tweetid).readOnly = true;

document.getElementById(showid).innerHTML = '';





var tweetmessage = document.getElementById(tweetid).value;





var CampaignID  = document.getElementById('CampaignID').value;

 

 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="futuresavetweetmessage.php";

url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"&dateid="+dateid+"";

 



document.getElementById(displaystatusid).innerHTML="<div class=blue>saving....</div>";

	 

	xmlHttp.onreadystatechange=stateChangedsaveElementforfuturetweets;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);



	

	

}





function stateChangedsaveElementforfuturetweets() 

{ 

	 



if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 { 



	 

//split id and inserted id 

//alert(xmlHttp.responseText);

var splitresult = xmlHttp.responseText.split("-");





	  

	 

 

	var result = splitresult[0];

	

 

var tweetidf = "ftweets"+result;



var displaystatusidf = 'fdisplay'+result;

var showidf = "fshow"+result;

var dateid = "fdateff"+result;

document.getElementById(displaystatusidf).innerHTML="";



 

 dateid = document.getElementById(dateid).value;





var removeid = "fremove"+result;

var saveid = "fsave"+result;

var updateid = "fupdate"+result;

var rowid = splitresult[1];



var divIdName = "my"+result+"Divforfuturetweets";

//document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";

//document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\','"+dateid+"\')\">update  </a>";





document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforfuturetweets(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/close.png alt= />  </a>";

document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElementforfuturetweets(\'"+divIdName+"\','"+result+"\','"+rowid+"\','"+dateid+"\')\"><img src=../images/edit.png alt= />  </a>";



document.getElementById(saveid).innerHTML="";





ShowNoRecordsForFutureTweets();

 

	}		 

}











function addEventforfuturetweets() {

	

	  var ni = document.getElementById('myDivforfuturetweets');

	  var numi = document.getElementById('theValueforfuturetweets');

	  var num = (document.getElementById("theValueforfuturetweets").value -1)+ 2;

	  numi.value = num;

	  var divIdName = "my"+num+"Divforfuturetweets";

	  var ids = num;



	  var tweetsid = "ftweets"+ids;

	  var showid = "fshow"+ids;

	  var displaydate = "fdisplaydate"+ids;

	  

	  var newdiv = document.createElement('div');

	  newdiv.setAttribute("id",divIdName);

	 // newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top>	  <font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=displaydate"+ids+"></div> <div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

	 // newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top>	  <font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=displaydate"+ids+"></div> <div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";



	  

	  

	  var  out = ''; 

	  out +=" <div class=followers_data>";

	  out +="	<div class=autotweet05>";

	  out +=	"	<div style=float:left id=fdisplay"+ids+"></div><div style=float:left><textarea  cols=80 rows=4 name=ftweets"+ids+"  id=ftweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"', '"+ids+"', '"+divIdName+"')\" onkeyup=\"updateCounter(139, '"+tweetsid+"', '"+showid+"', '"+ids+"', '"+divIdName+"')\" class=textarea_editable01  ></textarea><strong id=fshow"+ids+"></strong> </div>";

	  out +="	</div>";

	  out +=	"<div class=tick_red02>&nbsp;</div>";

	  out +=	"<div class=autotweet06>";

	//  out +=	"<div class=inner_boxes02><div id=fdisplaydate"+ids+"></div></div>";

	  out +=	"<div class=inner_boxes02><div id="+displaydate+"></div></div>";

	//  newdiv.innerHTML .=	"<div class=inner_link_00><a href=#><img src=../images/calender.jpg alt= /></a></div>";



	  out +="</div>";

	  out +="<div class=followers_data03>";

	  out +=	"<div style=float:left id=fremove"+ids+"></div><div style=float:left id=fsave"+ids+"></div><div style=float:left id=fupdate"+ids+"></div> ";

	  out +=	"</div>"

		  out +="	<div class=clear></div>";

		  out +="</div>";



		  newdiv.innerHTML = out;

		  

	

					

	           



    

	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";



	 

	

	  ni.appendChild(newdiv);

	 



	  

	  var removeid = "fremove"+ids;

	  var saveid = "fsave"+ids;

	  var updateid = "fupdate"+ids;

	  

	//  document.getElementById(displaydate).innerHTML="<input name=date1"+ids+" id=date1"+ids+" class=date-pick>";

	  document.getElementById(displaydate).innerHTML="<input name=fdateff"+ids+" id=fdateff"+ids+" class=date-picku>";

	  document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementforfuturetweets(\'"+divIdName+"\','"+ids+"\')\"><img src=../images/save.png alt= />  </a>";

	 // $('.date-pick').datePicker();

	  $('.date-picku').datePicker();

	  

	  

	}















function savesettingsuuu()

{

 

 

var CampaignID = document.getElementById('CampaignID').value;

 

// check the norecords  div value =  that mesasge if  message there script be false 



 



if(document.getElementById('testforsavetweets').value == "no"){



//	document.getElementById('testforsavetweets').innerHTML = "please enter save tweets messages then try save tweets";

	return false;

	

}











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
//var repeat=0;
url=url+"?Do=Save&freq_id="+freq_id+"&repeat="+repeat+"&random="+random+"&CampaignID="+CampaignID+"";





document.getElementById("Displaytweetsettingsstatus").innerHTML="<div class=blue>Saving....</div>";

 

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



	

	//document.getElementById("displaybutton").innerHTML="<input type=button name=updatesettings value=updatesettings onclick=updatesettings('"+CampaignID+"','"+rowid+"')>";

	

	document.getElementById("Displaytweetsettingsstatus").innerHTML=message;

	}		 

}













function saveElementwithrowid(divname,id,rowid)

{



	var tweetid = "tweets"+id;

	var showid = "show"+id;

	 

	var displaystatusid = "display"+id;





	var enteredtextvalue = document.getElementById(tweetid).value;



	 

	

	if(enteredtextvalue == '' || enteredtextvalue == '0' || !isNaN(enteredtextvalue) || enteredtextvalue.charAt(0) == ' ')

	{

		document.getElementById(tweetid).select;

		

		document.getElementById(tweetid).value = '' ;

		document.getElementById(displaystatusid).innerHTML = 'Tweet message  Should not empty';

		return false;

		

	}





	

	document.getElementById(tweetid).style.border="none";

	document.getElementById(tweetid).readOnly = true;

	document.getElementById(showid).innerHTML = '';



	

	

	var tweetmessage = document.getElementById(tweetid).value;

	var CampaignID  = document.getElementById('CampaignID').value;

	 

	 xmlHttp=GetXmlHttpObject();

		if (xmlHttp==null)

		  {

		  alert ("Browser does not support HTTP Request");

		  return;

		  } 

		var url="updatetweetmessage.php";

	url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"";

	 



	document.getElementById(displaystatusid).innerHTML="<div class=blue>Updating....</div>";

		 

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

	//document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">Remove  </a>";

	//document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowid(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\">save  </a>";

	

	document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforsavetweets(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\"><img src=../images/close.png alt= />  </a>";

	document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowid(\'"+divIdName+"\','"+id+"\','"+rowid+"\')\"><img src=../images/save.png alt= />  </a>";

	

	

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
	var tweetres = splitresult[2];
 	

var tweetidf = "tweets"+result;



var displaystatusidf = 'display'+result;

var showidf = "show"+result;

 

document.getElementById(displaystatusidf).innerHTML="";



 







var removeid = "remove"+result;

var saveid = "save"+result;

var updateid = "update"+result;



var divIdName = "my"+result+"Div";

//document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">Remove  </a>";

//document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\">update  </a>";
if(!isNaN(tweetres))
{

document.getElementById(removeid).innerHTML="<a href=\"javascript:;\"onclick=\"removeElementforsavetweets(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/close.png alt= />  </a>";

document.getElementById(updateid).innerHTML="<a href=\"javascript:;\" onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/edit.png alt= />  </a>";
document.getElementById(saveid).innerHTML="";
}
else
{
alert(tweetres);
document.getElementById(tweetidf).readOnly = false;
document.getElementById(tweetidf).style.border="medium solid black";
document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElementwithrowid(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/save.png alt= />  </a>";

//document.getElementById(displaystatusidf).innerHTML="";
//document.getElementById(saveid).innerHTML=rowid;
//document.getElementById(divIdName).innerHTML="";
//addEventForsaveTweets();
}
ShowNoRecordsForSaveTweets();
	}		 

}

function addEventForsaveTweets() {

	  var ni = document.getElementById('myDivforsavetweets');

	  var numi = document.getElementById('theValue');

	  var num = (document.getElementById("theValue").value -1)+ 2;

	  numi.value = num;

	  var divIdName = "my"+num+"Div";

	  var ids = num;



	  var tweetsid = "tweets"+ids;

	  var showid = "show"+ids;

	  

	  var newdiv = document.createElement('div');

	  newdiv.setAttribute("id",divIdName);

	//  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

	

	//  newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25% valign=top><font face=verdana size=2>Tweet Message </td><td><div id=display"+ids+"></div><textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"')\" onpaste=\"updateCounter(139, '"+tweetsid+"', '"+showid+"')\" /></textarea><strong id=show"+ids+"></strong> </td><td><div id=remove"+ids+"></div><div id=save"+ids+"></div><div id=update"+ids+"></div></td></tr></table>";

var out  = '';





out +="<div class=followers_data>";

out += "<div class=autotweet07><div id=display"+ids+"></div>";

out +="<textarea cols=80 rows=4 name=tweets"+ids+"  id=tweets"+ids+"  onkeypress=\"updateCounter( 139, '"+tweetsid+"', '"+showid+"', '"+ids+"', '"+divIdName+"')\" onkeyup=\"updateCounter('139', '"+tweetsid+"', '"+showid+"', '"+ids+"', '"+divIdName+"')\" class=textarea_editable  ></textarea><strong id=show"+ids+"></strong>";

out +="</div>";

out +="<div class=tick_red01>&nbsp;</div>";

out +="<div class=followers_data03>";



out +=	"<div style=float:left id=remove"+ids+"></div><div style=float:left id=save"+ids+"></div><div style=float:left id=update"+ids+"></div>";

out +=	"</div>";

out +=	"<div class=clear></div>";

out +="</div>";

	

newdiv.innerHTML =out;



	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";





	  ni.appendChild(newdiv);



	  var removeid = "remove"+ids;

	  var saveid = "save"+ids;

	  var updateid = "update"+ids;

	  

	  document.getElementById(saveid).innerHTML=" <a href=\"javascript:;\" onclick=\"saveElement(\'"+divIdName+"\','"+ids+"\')\"><img style=float:left; padding:0 0 0 7px; src=../images/save.png alt= title=Save /></a>";

	  

	  //document.getElementById(saveid).innerHTML="<a href=\"javascript:;\" onclick=\"saveElement(\'"+divIdName+"\','"+ids+"\')\">save  </a>";



	  

	}







function saveElement(divname,id)

{

 

var tweetid = "tweets"+id;

var showid = "show"+id;



var displaystatusid = "display"+id;



var enteredtextvalue = document.getElementById(tweetid).value;



 

	

if(enteredtextvalue == '' || enteredtextvalue == '0' || !isNaN(enteredtextvalue) || enteredtextvalue.charAt(0) == ' ')

{

	document.getElementById(tweetid).select;

	

	document.getElementById(tweetid).value = '' ;

	document.getElementById(displaystatusid).innerHTML = 'Tweet message  Should not empty';

	return false;

	

}







 



document.getElementById(tweetid).style.border="none";

document.getElementById(tweetid).readOnly = true;

document.getElementById(showid).innerHTML = '';





var tweetmessage = document.getElementById(tweetid).value;

//var CampaignID  = <?php print $CampaignID; ?>;



var CampaignID  = document.getElementById('CampaignID').value;



 

 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="savetweetmessage.php";

url=url+"?Do=Save&tweetmessage="+tweetmessage+"&CampaignID="+CampaignID+"&did="+id+"";

 

document.getElementById(displaystatusid).innerHTML="<div class=blue>saving....</div>";



	 

	xmlHttp.onreadystatechange=stateChangedsaveElement;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);



	



}







function removeElementforsavetweets(divNum,id,rowid) {





	 // first remove from db and remove lement 

	 var tweetid = "tweets"+id;

var showid = "show"+id;

var displaystatusid = "display"+id;





 

//var CampaignID  = <?php print $CampaignID; ?>;

var CampaignID  = document.getElementById('CampaignID').value;



xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  } 

	var url="deletetweetmessage.php";

url=url+"?Do=Save&CampaignID="+CampaignID+"&did="+id+"&rowid="+rowid+"";





document.getElementById(displaystatusid).innerHTML="<div class=blue>Deleting....</div>";

	 

	xmlHttp.onreadystatechange=stateChangedremoveElementforsavetweets;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





	

 var d = document.getElementById('myDivforsavetweets');

 var olddiv = document.getElementById(divNum);

 d.removeChild(olddiv);

}





function stateChangedremoveElementforsavetweets() 

{ 

	 



if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

{ 



	ShowNoRecordsForSaveTweets();





	}		 

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

if(!isNaN(rowid))
{
document.getElementById(updateid).innerHTML="<div style=float:left ><a href=\"javascript:;\" onclick=\"removeElementforsavetweets(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/close.png alt= />  </a></div>";

document.getElementById(removeid).innerHTML="<div style=float:left ><a href=\"javascript:;\"onclick=\"updateElement(\'"+divIdName+"\','"+result+"\','"+rowid+"\')\"><img src=../images/edit.png alt= />  </a></div>";
document.getElementById(saveid).innerHTML="";
ShowNoRecordsForSaveTweets();
}
else
{
alert(rowid);
document.getElementById(displaystatusidf).innerHTML="";
document.getElementById(saveid).innerHTML=rowid;
document.getElementById(divIdName).innerHTML="";
//addEventForsaveTweets();
}
	}		 

}

function GetuseraccountsndSave()

{



	var CampaignID = document.getElementById('CampaignID').value;

	var theValue = document.getElementById('theValue').value;



	// call ajax

	 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  }

	var url="editcampaign_action.php";

	url=url+"?Do=Save&CampaignID="+CampaignID+"&theValue="+theValue+"";



 

	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  ="Saving....";



	xmlHttp.onreadystatechange=stateChangedGetuseraccountsndSave;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





		//return false;





	 

	

}







function stateChangedGetuseraccountsndSave123()

{





if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 {



	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  =xmlHttp.responseText;

	

 	



	}

}



function GetUpdatecampaignvalues(campaignrowid)

{



		  

	var campaignname = document.getElementById('campaignname').value;

	var campaignnamedesc = document.getElementById('campaignnamedesc').value;

	var startdate = document.getElementById('start-date').value;

	var enddate = document.getElementById('end-date').value;





	if(campaignname == '' || campaignname == '0' ||  campaignname.charAt(0) == ' ')

	{

		document.getElementById('campaignname').select;

		

		document.getElementById('campaignname').value = '' ;



		if(campaignnamedesc == '' || campaignnamedesc == '0' || !isNaN(campaignnamedesc) || campaignnamedesc.charAt(0) == ' ')

		{

			document.getElementById("campaignnameid").innerHTML = 'Campaignname and CampaignDescription Should not empty';

			return false;

		}

		else

		{

		document.getElementById("campaignnameid").innerHTML = 'Campaignname Should not empty';

		return false;

		}

		

		

	}





	if(campaignname != ""){

		

		  var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

	        for (var i = 0; i < campaignname.length; i++) {

	                if (iChars.indexOf(campaignname.charAt(i)) != -1) {

	                	document.getElementById("campaignnameid").innerHTML = 'Campaignname Special characters  are not allowed';

	                	

	              //  alert ("The box has special characters. \nThese are not allowed.\n");

	                return false;

	        }

	                }



	}

            



	if(campaignnamedesc == '' || campaignnamedesc == '0' ||   campaignnamedesc.charAt(0) == ' ')

	{

		document.getElementById('campaignnamedesc').select;

		document.getElementById('campaignnamedesc').value = '' ;

		document.getElementById("campaignnameid").innerHTML = '';

		

		document.getElementById("campaignnamedescid").innerHTML = 'Campaign Description Should not empty';

		return false;

		

	}





	document.getElementById("campaignnamedescid").innerHTML = '';



	// call ajax

	 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  }

	var url="update_campaignaction.php";

	url=url+"?Do=Save&campaignname="+campaignname+"&campaignnamedesc="+campaignnamedesc+"&startdate="+startdate+"&enddate="+enddate+"&campaignrowid="+campaignrowid+"";





	document.getElementById("DisplayNewCampaignAddingStatus").innerHTML  ="<div class=blue>Updating....</div>";



	xmlHttp.onreadystatechange=stateChangedGetUpdatecampaignvalues;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





		//return false;

	 



		  

}









function stateChangedGetUpdatecampaignvalues()

{





if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 {



	var splitresult = xmlHttp.responseText.split("-");

	var errormessage = splitresult[0];

	var CID = splitresult[1];

	document.getElementById("DisplayNewCampaignAddingStatus").innerHTML  =errormessage;



  

 	



	}

}

















function GetNewcampaignvalues()

{



		  

	var campaignname = document.getElementById('campaignname').value;

	var campaignnamedesc = document.getElementById('campaignnamedesc').value;

	var startdate = document.getElementById('start-date').value;

	var enddate = document.getElementById('end-date').value;

//!isNaN(campaignname) ||



	if(campaignname == '' || campaignname == '0' ||  campaignname.charAt(0) == ' ')

	{

		document.getElementById('campaignname').select;

		

		document.getElementById('campaignname').value = '' ;





		if(campaignnamedesc == '' || campaignnamedesc == '0' || !isNaN(campaignnamedesc) || campaignnamedesc.charAt(0) == ' ')

		{

			document.getElementById("campaignnameid").innerHTML = 'Campaign Name and Campaign Description  should not empty';

			return false;

			

		}

		else

		{

		document.getElementById("campaignnameid").innerHTML = 'Campaign Name should not empty';

		return false;

		}

		

		

	}





	if(campaignname != ""){

		

		  var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

	        for (var i = 0; i < campaignname.length; i++) {

	                if (iChars.indexOf(campaignname.charAt(i)) != -1) {

	                	document.getElementById("campaignnameid").innerHTML = 'Enter a valid Campaign Name';

	                	

	              //  alert ("The box has special characters. \nThese are not allowed.\n");

	                return false;

	        }

	                }





		 	   

	}

	



	if(campaignnamedesc == '' || campaignnamedesc == '0' ||   campaignnamedesc.charAt(0) == ' ')

	{

		document.getElementById('campaignnamedesc').select;

		document.getElementById('campaignnamedesc').value = '' ;

		document.getElementById("campaignnameid").innerHTML = '';

		

		document.getElementById("campaignnamedescid").innerHTML = 'Campaign Description Should not empty';

		return false;

		

	}





	document.getElementById("campaignnamedescid").innerHTML = '';



	// call ajax

	 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  }

	var url="add_campaignaction.php";

	url=url+"?Do=Save&campaignname="+campaignname+"&campaignnamedesc="+campaignnamedesc+"&startdate="+startdate+"&enddate="+enddate+"";





	document.getElementById("DisplayNewCampaignAddingStatus").innerHTML  ="<div class=blue>Saving....</div>";



	xmlHttp.onreadystatechange=stateChangedsavenewcampaigns;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





		//return false;

	 



		  

}











function stateChangedsavenewcampaigns()

{





if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 {



	var splitresult = xmlHttp.responseText.split("-");

	var errormessage = splitresult[0];

	var CID = splitresult[1];

	



 	if(CID == 0){

 	 	

 		document.getElementById('start-date').value = '';

 		document.getElementById('end-date').value = '';



 		

	document.getElementById("campaignname").readOnly = false;

	

 

	document.getElementById("campaignnamedesc").readOnly = false ;

	

	document.getElementById("DisplayNewCampaignAddingStatus").innerHTML  =errormessage;



	document.getElementById("ShowNewcampaignAddButton").innerHTML = "<input type=button value=Save   onclick=GetNewcampaignvalues()> ";

	

	//document.getElementById("addaccounts").style.visibility="visible";

	//switchid('addaccounts');

	//  document.getElementById("addaccounts").style.display="block";

 	}



 	else

 	{



 		document.getElementById('CampaignID').value = CID;

 		

 		

 		document.getElementById("campaignname").readOnly = true;

 		

 		 

 		document.getElementById("campaignnamedesc").readOnly = true ;

 		

 		document.getElementById("DisplayNewCampaignAddingStatus").innerHTML  =errormessage;



 		document.getElementById("ShowNewcampaignAddButton").innerHTML = "";

 		

 		document.getElementById("addaccounts").style.visibility="visible";

 		//switchid('addaccounts');



 		// document.getElementById('others1').innerHTML="   ";

 		 document.getElementById('others6').innerHTML=" <a     onclick=switchid('addaccounts');    > Accounts<a> ";

 		// document.getElementById('selectedtab').value= "s";

 		 



 		 

 		//window.location = "campaign.php?c="+CID+"&m=a";

 	//	window.location = "campaign.php?c="+CID+"&m=s";

 		



 		 document.getElementById('DisplayCmapignPlayPauseStatus').innerHTML="<img src=../images/pause.png title='Pause The Campaign' alt='' onclick=updateplaypasuse('pause','"+CID+"') >";

		 

 	}

 	

 	



	}

}













$(function()

		{

			$('.date-pick').datePicker()

			$('#start-date').bind(

				'dpClosed',

				function(e, selectedDates)

				{

					var d = selectedDates[0];

					if (d) {

						d = new Date(d);

						$('#end-date').dpSetStartDate(d.addDays(1).asString());

					}

				}

			);

			$('#end-date').bind(

				'dpClosed',

				function(e, selectedDates)

				{

					var d = selectedDates[0];

					if (d) {

						d = new Date(d);

						$('#start-date').dpSetEndDate(d.addDays(-1).asString());

					}

				}

			);

		});











  </script>



			  <form name="abc" action="campaign" method="post">

	<!-- Middle Content Area Start -->

	<div class="middle_main">

		<div class="bx_top"><div class="clear"></div></div>

		 

		<!-- <input type="text" name="selectedtabU" id="selectedtabU"  ></input> -->   

		

		

		 

		<div class="bx_mid">

			<div class="inner_middle_cont">

				<!-- Middle Contents Start -->

				<div class="innermain_head">

					<div class="innermain_head_addedit"><h1>Add/Edit Your Campaigns</h1></div>

					<div class="innermain_help" ><a href="#" onclick="return popitup('<?php echo USR_PATH.'campaign_help.php' ?>')" ><img src="../images/help_quest.png" title="Help" alt="" ></a></div>

				</div>



				<div class="middlecont_01_inner">



					<div class="innermid_top"></div>

					<div class="innermid_mid">

						<!-- Inner Page Main Content Start -->

						<div class="subhead_main">

							<div class="subhead_main_head"><h1><?php echo $campainDetails[0]['CampaignName']?></h1></div>

							<!-- <div class="subhead_main_pause"> <img src="../images/pause.png" title="Pause The Campaign" alt="" onclick=""/> </div> -->

							

							

 <div class="subhead_main_pause">  <div id="DisplayCmapignPlayPauseStatus"></div> </div> 

							

							

							<div class="clear"></div>

						</div>

						<div class="midnav_inner">

							<!-- middle Navigation Start -->

							<div class="innermid_mid_nav">

							

							

								<ul>

								

								

								

								

									  <li class="settings_link"><a href="#" onclick="switchid('settings');"  >Settings</a></li>  

									

									

									<!-- <li class="settings_link"><a href="campaign.php?c=<?php print $_REQUEST["c"]?>&m=s"  <?php  if($_REQUEST["m"] == "s") { print "id=tab";} ?>>Settings</a></li> -->

									

									

									

									

									

									

									 

									  <!--  <li class="account_link"><a href="#" onclick="switchid('addaccounts');"  >Add Accounts</a></li>  

									

									  

									

									<li class="keyword_link"><a href="#" onclick="switchid('keywords');"  >Keywords</a></li>

									<li class="feeds_link"><a href="#" onclick="switchid('feeds');"   >Feeds</a></li>

									<li class="auto_link"><a href="#" onclick="switchid('autotweet');"  >Auto Tweet</a></li>

									<li class="tracklinks_link"><a href="#" onclick="switchid('tracklinks');"   >Track Links</a></li>

									<li class="trackcampaign_link"><a href="#" onclick="switchid('trackcampaigns' );"   >Track Campaign</a></li>  

									

									 -->

									 

									 

									 



									 <li class="account_link"><div id="others6"></div></li>  

									

									  

									

									<li class="keyword_link"><div id="others1"></div></li>

									<li class="feeds_link"><div id="others2"></div></li>

									<li class="auto_link"><div id="others3"></div></li>

									<li class="tracklinks_link"><div id="others4"></div></li>

									<li class="trackcampaign_link"><div id="others5"></div></li> 

									

									

									

									

									

									 

									

									

									

									

									

									

									

									

									 

								</ul>

							</div>

							<!-- middle Navigation End -->

						</div>

						<!-- Campaign Settings Form Start-->

						<div class="cont_form_inner" id="settings" style="display: none;">



<?php 

	$dkPackage 		= dkGetPackagedetails($_SESSION["username"]);

	$dkNoCampaign	= dkGetNoCampaign($_SESSION["username"]); 

	if(intval($_SESSION["SCampaignId"]))

	{

		$campFlag = true;

	}

	else if($dkNoCampaign < $dkPackage['campaignLimit'])

	{

		$campFlag = true;

	}

	else

	{

		$campFlag = false;

	}

	if(!$campFlag)

	{

?>



	<span class="error">You have created <?php echo $dkNoCampaign;?> campaigns and your campaign limit is over. <a href="upgrade">Please upgrade your account.</a></span>

<?php

	}

	else

	{

?>

							<div class="forms01">

								<div class="inner_title">Campaign Name (*)</div>

								<div class="inner_boxes"><input type="text" class="inner_txtbx_01" name="campaignname"   id="campaignname"/><div id="campaignnameid" class="error"></div></div>

								<div class="clear" ></div>

							</div>

							<div class="forms01">

								<div class="inner_title">Description (*)</div>

								<div class="inner_boxes"><textarea    name="campaignnamedesc" class="inner_txtarea_01" id="campaignnamedesc"   cols="40" rows="10"/></textarea><div id="campaignnamedescid" class="error"></div></div>

								<div class="clear"></div>

							</div>

							<div class="forms01">





								<div class="inner_title">Start Date</div>

								<div class="inner_boxes">  <input    readonly  name="start-date" id="start-date"  class="date-pick"/></div>



								<div class="clear"></div>

							</div>

							<div class="forms01">



								<div class="inner_title">End Date</div>

								<div class="inner_boxes"><input    readonly name="end-date" id="end-date" class="date-pick"/></div>

								<div class="clear"></div>

							</div>

							<div class="forms01">

								<div class="inner_title">&nbsp;</div>

								<div class="inner_boxes">

									<div style="float:left" id="ShowNewcampaignAddButton"></div>

									<div  style="float:left; padding:0 0 0 10px;" id="DisplayNewCampaignAddingStatus" class="error" ></div>

									<div class="clear"></div>

								</div>

								<div class="clear"></div>

							</div>

<?php

}

?>							

							

						</div>

						

						

						

						<!-- Campaign Settings Form End -->

 



						<!-- Add Accounts Form Start -->

						 

						<div class="cont_form_inner" id="addaccounts" style="display: none;">

							<div class="forms01">Twitter accounts added to this campaign</div>

							<div class="editaccounts">

							

							

								<div class="followers_top">

									<div class="followers_left"></div>

									<div class="followers_middle">

										<div class="followers_middle06">Account Name</div>

										<div class="followers_middle04">&nbsp;</div>



										<div class="followers_middle05">Actions</div>

										<div class="clear"></div>

									</div>

									<div class="followers_right"></div>

									<div class="clear"></div>

								</div>

							

							

							

						 <script type="text/javascript">

						loadallaccounts();

						

						 </script>

						 

							

								<!-- Account 1 Start -->

								  <input type="hidden" value="0" id="theValueforaccounts"  name="theValueforaccounts"/>

								  

								  

								<div style="width:550px;">

									<div id="myDivforaccounts" style="width:550px;"></div>

								</div>

								<div class="clear"></div>

								<!-- Account 1 End -->



							 

							</div>

							<div class="account_select">

							 

							

							  	<div class="account_title">Select account to add (*)</div> 

							 

								<div class="account_title">

								

									 <input type="hidden" name="CampaignID" id="CampaignID"></input>

									<?php

									$GetUsersbyrefid ="SELECT * FROM ta_users WHERE 	RefID='$refid'";

									$GetUsersbyrefidResult  = runQuery($GetUsersbyrefid);

																	

									?>

								  <select name="accs"  id="accs" onchange="addEvent(this.value,'<?php print $_SESSION["username"]; ?>');reloaddata();" class="inner_option_01">

									  <option value="0" selected="selected">Select</option>

									  <?php

									  $k=1;

									  for($p=0;$p<count($GetUsersbyrefidResult);$p++)

									  {

									

									 ?>

									  <!-- <option value="<?php  print $GetUsersbyrefidResult[$p]["UserName"]?>"   id="opid<?php print $k?>"><?php  print $GetUsersbyrefidResult[$p]["UserName"]?></option> -->

									  <option value="<?php  print $GetUsersbyrefidResult[$p]["UserName"]?>"   id="<?php  print $GetUsersbyrefidResult[$p]["UserName"]?>"><?php  print $GetUsersbyrefidResult[$p]["UserName"]?></option>

									  <?php

									  $k++;

									  }

									  ?>

									  </select>

									  

  

  

								</div>

								<div class="account_title"> 

								<div class="green" id="DisplayStatusForSavingAccountsUsingCampaignId"></div>

								</div>

								<div class="clear"></div>

							</div>

						</div>

						<!-- Add Accounts Form End -->

						

						

						



					<?php 

					include  "campaign_keywords.php";

					

					?>

						 

						<!-- Feeds Form Start -->

						<div class="cont_form_inner" id="feeds" style="display: none;">



							<!-- Followers Area Start -->

							<div class="editaccounts">

								<div class="followers_top">

									<div class="followers_left"></div>

									<div class="followers_middle">

										<div class="followers_middle06">Feed Name</div>

										<div class="followers_middle04">Feed URL</div>

										<div class="followers_middle05">Actions</div>

										<div class="clear"></div>

									</div>

									<div class="followers_right"></div>

									<div class="clear"></div>

								</div>

								

								<script type="text/javascript" language="javascript">

								//ShowAllfeedsUsingCampaign();

								 

								

								</script>

								

								<!-- Feed 1 Start -->

								 

								<div  >



								<div id="DisplayAllFeedsusingCampaignsFFF"></div>

								

									

								</div>

								<!-- Feed 1 End -->



								 

<div class="clear"></div>

							</div>

							<!-- Followers Area End -->

						

<?php 

	$dkPackage 			= dkGetPackagedetails($_SESSION["username"]);

	$dkNoCampaignFeeds	= dkGetNoCampaignFeeds($_SESSION["SCampaignId"]); 

	if($dkNoCampaignFeeds >= $dkPackage['feedLimit'])

	{

?>	

	<span class="error" id="error">You have created <?php echo $dkNoCampaignFeeds;?> campaign feeds and your campaign feed limit is over.  <a href="upgrade">Please upgrade your account.</a></span>

<?php

	}

?>

<span class="error" id="error"></span>

							<div class="forms01">

								<div class="inner_title">  </div>

								<div class="account_title"></div>

								<div class="error">&nbsp;</div>

								<div class="clear"></div>

							</div>

							

							<div class="forms01">

								<div class="inner_title01">Name of the feed * &nbsp;</div>

								<div class="account_title"><input type="text" class="inner_txtbx_03"  id="feed_feedname" name="feedname" >

								<label  id="feed_feednamev" name="feed_feednamev" class="error"></label></div>

								<div class="error">&nbsp;</div>

								<div class="clear"></div>

							</div>

							<div class="forms01">

								<div class="inner_title01">RSS feed URL * &nbsp;</div>

								<div class="account_title"><input type="text" class="inner_txtbx_01" id="feed_feedurl" name="feedurl" onblur="checkURLtest();"/>

								<label  id="feed_feedurlv" name="feed_feedurlv" ></label></div>

								

								

								<div> 

								<div id="feed_urlstatus" class="error"></div>

								<div id="feed_urlstatus_green" class="green"></div>

								 <div id="feed_urlstatus_red"  class="error"></div>

								 

								</div>

								<div class="clear"></div>

							</div>

							<div class="forms01">

								<div class="inner_title01">Post links &nbsp;</div>

								<div class="account_title"><input type="checkbox"  id="posturl" name="posturl" value="1" /></div>

								<div class="account_title"> &nbsp; Using our URL shortening </div>

								<div class="account_title"><input type="checkbox" id="shorturl" name="shorturl" value="1" t /></div>

								<div class="clear"></div>

							</div>

							<div class="forms01">

								<div class="inner_title01">Sort ID * &nbsp;</div>

								<div class="account_title">

									<select id="sortid" name="sortid"  class="inner_option_medium01">

										 <option value="0"  >Select Sort id</option>

<option value="1"  >PubDate</option>

<option value="2">guid</option>

									</select><label  id="sortidv" name="sortidv" class="error">

									<input type="hidden" name="susername" id="susername" value="<?php print $_SESSION["username"]?>">

									

								</div>

								

								 

								<div class="clear"></div>

							</div>

							

							

							

							

							

							

							<div class="forms01">

								 

							 

								<div class="inner_title01">Content to be included * &nbsp;</div>

								<div class="account_title">

									<select id="feed_showdesc" name="showdesc"  class="inner_option_medium01">

									 <option value="22"  >Select Post Content</option>

 

<option value="0">title only</option>

<option value="1"  >title &amp; description</option>

<option value="2">description only</option></select>

									</select><label  id="feed_showdescv" name="feed_showdescv" class="error">

								</div>

								<div class="clear"></div>

							</div>

							

							

							

							

							

							

							

							<div class="forms01">

								<div class="inner_title01"> Frequency of posts * &nbsp;</div>

								<div class="account_title">

									<select id="feed_freq_id" name="freq_id" class="inner_option_medium01">

										<option value="0"  >Select Frequency</option>

   

<option value="1">Every hour</option>

<option value="2">Every 2 hours</option>

<option value="3">Every 3 hours</option>

<option value="6">Every 6 hours</option>

<option value="12">Every 12 hours</option>

<option value="24">Every 24 hours</option>

									</select><label  id="feed_freq_idv" name=""feed_freq_idv"" class="error">

								</div>

								<div class="account_title"><div id="ShowFeedButton"></div><div id="DisplayStatusForAddingfeeddetails"></div></div>

								<div class="clear"></div>

							</div>



						</div>

						<!-- Feeds Form End -->



					<!-- Autotweet Form Start -->

						<div class="cont_form_inner" id="autotweet" style="display: none;">



							<div class="autotweet_inner01">

							

								<h3>Saved Tweets</h3>

								

								<!-- Tweet Area Start -->

								<div class="editaccounts">

								

									<!-- Future Tweet Headings Start -->

									<div class="followers_top">

										<div class="followers_left"></div>

										<div class="followers_middle">



											<div class="autotweet04">Saved Tweets</div>

											<div class="autotweet03">&nbsp;</div>

											<div class="followers_middle03">Action</div>

											<div class="clear"></div>

										</div>

										<div class="followers_right"></div>

										<div class="clear"></div>

									</div>



									<!-- Future Tweet Headings End -->

									

									  <script  type="text/javascript">

									//ShowNoRecordsForSaveTweets();

									

									  </script>

									  

									

									

									<div>

									<div id="DisplayNoreecorsForsaveTweets" ></div>

									</div>

									

									<div>

									<div id="myDivforsavetweets"></div>

									</div>

									

									

								</div>

								<!-- Tweet Area End -->

								

								<!-- Add Tweet Start -->

								<div class="add_tweet_area">

								<input type="hidden" value="0" id="theValue" name="theValue" />

									<!-- Add Button Start -->

									<div><img src="../images/add.png" title="Add" alt=""  onClick="addEventForsaveTweets();"></div>

									<!-- Add Button End -->

								</div>

								<!-- Add Tweet End-->

							<?php 

		

		

			// get all tweet setting  by campaign id 

//$getallsettingspop = "SELECT * FROM ta_save_tweets_settings WHERE CampaignID='$_REQUEST[c]'";



		$getallsettingspop = "SELECT * FROM ta_save_tweets_settings WHERE CampaignID='$_SESSION[SCampaignId]'";

		

		

		

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

 

 

 

								<!-- Update Area Start -->

								<div class="add_tweet_area">

									<div class="account_title">Update Frequency</div>



									<div class="account_title">

										<select id="freq_id" name="freq_id"  class="inner_option_medium01">

 <option value="1" <?php if($getallsettingspop[0]["Frequency"] == 1) print "Selected" ?> >Every hour</option>

<option value="2"  <?php if($getallsettingspop[0]["Frequency"] == 2) print "Selected" ?>>Every 2 hours</option>

<option value="3" <?php if($getallsettingspop[0]["Frequency"] == 3) print "Selected" ?> >Every 3 hours</option>

<option value="6"  <?php if($getallsettingspop[0]["Frequency"] == 6) print "Selected" ?>>Every 6 hours</option>

<option value="12" <?php if($getallsettingspop[0]["Frequency"] == 12) print "Selected" ?> >Every 12 hours</option>

<option value="24"  <?php if($getallsettingspop[0]["Frequency"] == 24) print "Selected" ?>>Every 24 hours</option>

										</select>

									</div>

								<div class="tweet_title">Repeat</div>



									<div class="account_title"><input type="checkbox" name="repeat"  id="repeat"  <?php  print $Repeatstatus?> /></div>

									<div class="tweet_title">Random</div>

									<div class="account_title"><input type="checkbox" name="random"  id="random" <?php  print $Randomstatus?>/></div>

									

									 <script  type="text/javascript">

									 var CAmID = document.getElementById("CampaignID").value;

									 

									 </script>

									 

									<div class="account_title">

									<!-- <input type="button" value="Save Settings"  name="savesettings"  class="inner_txtbtn_02"  onclick="savesettings();" /> -->

									<div id="displaybutton"></div>

									<div id="Displaytweetsettingsstatus"></div>

									

									</div>

									<div class="clear"></div>

								</div>

								<!-- Update Area End -->

								

							</div>



							<!-- Saved Tweets Area End -->

							

							<!-- Future Tweets Area Start -->

							<div class="autotweet_inner02">

							

								<h3>Future Tweets</h3>

								

								<!-- Tweet Area Start -->

								<div class="editaccounts">

								

									<!-- Future Tweet Headings Start -->

									<div class="followers_top">



										<div class="followers_left"></div>

										<div class="followers_middle">

											<div class="autotweet04">Message</div>

											<div class="autotweet03">Date</div>

											<div class="followers_middle03">Action</div>

											<div class="clear"></div>

										</div>



										<div class="followers_right"></div>

										<div class="clear"></div>

									</div>

									<!-- Future Tweet Headings End -->

									

									

									<div>

									<div id="DisplayNoreecorsForfutureTweets" ></div>

									</div>

									

									

									

									<div >

									<div id="myDivforfuturetweets"></div>

									</div>

									

								</div>

								<!-- Tweet Area End -->



								

								<!-- Add Tweets Start -->

								<div class="add_tweet_area">

								<input type="hidden" value="0" id="theValueforfuturetweets" name="theValueforfuturetweets" />

								

									<!-- Add Button Start -->

									<div><img src="../images/add.png" title="Add" alt=""  onClick="addEventforfuturetweets();"/></div>

									<!-- Add Button End -->

								</div>

								<!-- Add Tweets End -->

								

							

							</div>	

						</div>


							<!-- Future Tweets Area End -->
						<!-- Autotweet Form End -->

						<!-- Track Links Form Start -->
<script type="text/javascript" language="javascript" >
$(document).ready(function() {
	$.ajax({
	   type: "POST",
	   url: "automated_unfollow_settings.php",
	   data: "user_id=1",
	   success: function(msg){
		 $('#automated_unfollow_main').html(msg);
	   }
	 });  
});
function automated_unfollow_setings()
{
	if ($('#automated_unfollow').attr('checked')) {
		 var flag = 'Y';
	}
	else {
		 var flag = 'N';
	}
	var wait_span = $('#automated_unfollow_wait_span').attr('value');
	$.ajax({
	   type: "POST",
	   url: "automated_unfollow_settings_submit.php",
	   data: "flag="+flag+"&wait_span="+wait_span,
	   success: function(msg){
	   	 if(msg=='failed')
		 {
		 alert('Update failed, server error');
		 }
	   }
	 });  
}
</script>
						<div class="cont_form_inner" id="tracklinks" style="display: none;">

								<h4>Automated unfollow tool</h4>
								<div class="automated_unfollow" id="automated_unfollow_main" style="margin-top:5px; margin-bottom:5px;">
									<img src="../images/loading.gif" >
								</div>
								<h4  style="padding:22px 0px 0px 0px;">Mass follow from another account</h4>
								<p style="padding:9px 0px 0px 0px;">This feature allows you to follow all the users another twitter user is following.</p>
								<div style="padding:10px 0px 0px 0px;">
								
								<p>Follow all users that this user is following  : </p>

								<div class="account_title"><input type="text" class="inner_txtbx_03" name="mass_username" id="mass_username" value="" /></div>

								<div class="account_title"><input type="button" value="Follow" class="inner_txtbtn_01" onclick="Getmassfollow(document.getElementById('mass_username').value)"></div>

								<label id="massfollowresult"></label>
							
								<div class="clear"></div>

							</div>
	<p style="padding:10px 0px 0px 0px; font-style:italic;">* Please note that the follows will be done for the logged in user only. If you want to enable this function for your addon accounts, then please login using that account name.</p>
								<p style="font-style:italic;"> * Also note that the mass follow will be done gradually and may take a few days to follow all users. </p>
							</div>

						<!-- Track Links Form End -->



						<!-- Track Campaigns Form Start -->

						<div class="cont_form_inner" id="trackcampaigns" style="display: none;">

							

							

							

<?php 

$query 				= "SELECT COUNT(*) AS cnt FROM `ta_short_urls` WHERE  app_type='Feed' and campaign_id  ='".$_SESSION["SCampaignId"]."'";

$tempPcount 		= runQuery($query);

$limit_start 		= $_REQUEST['ls'];

$limit_diff			= 10;

$limit_next			= $limit_diff;

if(!intval($limit_start)) 

{

	$limit_start 	= 0;

}

else

{

	if($limit_start > $tempPcount[0]['cnt'])

	{

		$limit_start 	= 0;

	}

}	

$limit_next+=$limit_start;

$query 				= "SELECT * FROM `ta_short_urls` WHERE app_type='Feed' and  campaign_id  ='".$_SESSION["SCampaignId"]."' LIMIT $limit_start,$limit_diff ";

$tempRes 			= runQuery($query);
if(count($tempRes)>0)
{
for($i=0;$i<count($tempRes);$i++)

{

	$query 			= "SELECT COUNT(*) AS cnt FROM `ta_short_urls_log` WHERE `id` = '".$tempRes[$i]['id']."'";

	$tempCnt 		= runQuery($query);

?>

							<!-- Track  Start -->

							<div class="trackcampaignsarea">

								<div style="float:right; width:100px;"><strong><?php echo $tempCnt[0]['cnt'];?> Clicks</strong></div>

								<div style="float:left" id="basic-modal">

									<p>

										<strong>Link: </strong>

										<a href="<?php echo 'http://twitjix.com/'.$tempRes[$i]['short'];?>" target="_blank"><?php echo 'http://twitjix.com/'.$tempRes[$i]['short'];?></a><br />

										<strong>Long Link: </strong>

										<a href="<?php echo $tempRes[$i]['url'];?>" target="_blank"><?php echo substr($tempRes[$i]['url'],0,50);?></a>

									</p>

									<p class="trackcampaignsarea_btn"><a href="javascript: jQuery.facebox({ajax:'short_url_log?id=<?php echo $tempRes[$i]['id'];?>'});">View Status</a></p>

								</div>

								<div class="clear"></div>

							</div>

							<!-- Track  End -->

<?php

}

if($tempPcount[0]['cnt'] > $limit_diff && $limit_next < $tempPcount[0]['cnt'])

{

?>							

<div style="text-align:right; padding:5px;"><strong><a href="campaign?ls=<?php echo $limit_next;?>">More ...</a></strong></div>		

<?php

}
}
else{?>
	<p><strong>No Records Found </strong></p>

<?php
}
?>					

							

						</div>

						<!-- Track Campaigns Form End -->

						<!-- Inner Page Main Content End -->

					</div>

					<div class="innermid_btm"></div>

					<div class="clear"></div>



					<div class="clear"></div>

				</div>

				<!-- Middle Contents End -->

			</div>

		</div>

	</div>

	<!-- Middle Content Area End -->



 





<script type="text/javascript">





//document.getElementById("ShowNewcampaignAddButton").innerHTML = "<input type=button value=Save  class=inner_txtbtn_01  onclick=GetNewcampaignvalues()>";



 





</script>

 



<script type="text/javascript">



/*

document.getElementById("addaccounts").style.visibility="hidden";

document.getElementById("keywords").style.visibility="hidden";

document.getElementById("feeds").style.visibility="hidden";

document.getElementById("autotweet").style.visibility="hidden";

document.getElementById("tracklinks").style.visibility="hidden";

document.getElementById("trackcampaigns").style.visibility="hidden";



 */

 



function doupdate(rowid)

{

	var CampaignID = document.getElementById('CampaignID').value;

	var feedrowid = rowid;



	// call ajax

	 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  }

	var url="fetchfeedrecordusingcampaignid.php";

	url=url+"?Do=Save&CampaignID="+CampaignID+"&feedrowid="+feedrowid+"";





	//document.getElementById("DisplayAllFeedsusingCampaigns").innerHTML  ="Deleting  Feeds....";



	xmlHttp.onreadystatechange=stateChangeddoupdate;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





		//return false;



}





function stateChangeddoupdate()

{





if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 {

	 

	

	var splitresult = xmlHttp.responseText.split("!");	 

	var feedname = splitresult[0];	

 	var feedurl = splitresult[1];

 	var posturl = splitresult[2];

 	var shorturl = splitresult[3];

 	var freq_id = splitresult[4];

 	var showdesc = splitresult[5];

 	var sortid = splitresult[6];

 	var feedrowid = splitresult[7];

 	 

 	

 	document.getElementById('feed_feedname').value = feedname;

 	document.getElementById('feed_feedurl').value = feedurl;



 	

  

	if(posturl == 1)

		document.getElementById('posturl').checked = true;	 

	else

		document.getElementById('posturl').checked = false;

	if(shorturl == 1)

		document.getElementById('shorturl').checked = true;	 

	else

		document.getElementById('shorturl').checked = false;







	document.getElementById('sortid').value = sortid;

	document.getElementById('feed_freq_id').value = freq_id;

	document.getElementById('feed_showdesc').value = showdesc;





	document.getElementById("ShowFeedButton").innerHTML  ="<input type=button value=Update id=xx class=inner_txtbtn_01 onclick=UpdateRssformValidation("+feedrowid+") >";



	

 	

	}

}









function dodelete(rowid)

{



	 

	

	var CampaignID = document.getElementById('CampaignID').value;

	var feedrowid = rowid;

	



	// call ajax

	 xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)

	  {

	  alert ("Browser does not support HTTP Request");

	  return;

	  }

	var url="deletefeedusingcampaign.php";

	url=url+"?Do=Save&CampaignID="+CampaignID+"&feedrowid="+feedrowid+"";





	document.getElementById("DisplayAllFeedsusingCampaignsFFF").innerHTML  ="<div class=blue>Deleting  Feeds....</div>";



	xmlHttp.onreadystatechange=stateChangeddodelete;

	xmlHttp.open("POST",url,true);

	xmlHttp.send(null);





		//return false;



	



}





function stateChangeddodelete()

{





if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")

 {

	if(document.getElementById('error'))

	{

		document.getElementById('error').innerHTML = '';

	}

	document.getElementById("DisplayAllFeedsusingCampaignsFFF").innerHTML  =xmlHttp.responseText;

	ShowAllfeedsUsingCampaign();

	

	}

}









</script>





<script type="text/javascript" language="javascript">

								 

								 

								document.getElementById("ShowFeedButton").innerHTML  ="<input type=button value=Save id=xx class=inner_txtbtn_01 onclick=RssformValidation() >";

								</script>

				

				

				<script type="text/javascript">



	/*function updateCounter(maxlength,id,counter) {



		var field = document.getElementById(id);

		 

		var totalLength = field.value.length;

		 

		if(totalLength >= maxlength) {

		field.value = field.value.substring(0, maxlength);

		}



		

		document.getElementById(counter).innerHTML = maxlength-field.value.length;

		}*/

		

 



	function updateCounter(maxlength,id,counter,rids,divIdName) {



		var field = document.getElementById(id);

		 

		var totalLength = field.value.length;

		 

		//if(totalLength >= maxlength) {

		//field.value = field.value.substring(0, maxlength);

		//}



		

		var ssid = "save"+rids;

		

		var result = maxlength-totalLength;

		

		document.getElementById(counter).innerHTML = maxlength-totalLength;



		if(result <  0){



			//alert(result);

			

			document.getElementById(ssid).innerHTML = "";

			

		}

		else{

		  document.getElementById(ssid).innerHTML=" <a href=\"javascript:;\" onclick=\"saveElement(\'"+divIdName+"\','"+rids+"\')\"><img style=float:left; padding:0 0 0 7px; src=../images/save.png alt= title=Save /></a>";

		}

		

		

		}



	

</script>





				<script type="text/javascript">

	document.getElementById("showmessagesforcategorytweets").style.border="none";

//loadtweetmessages('<?php print $getdatausingcampaignidresult[0]["CategoryIds"]?>');



//document.getElementById('CampaignID').value =<?php print $_REQUEST["c"]; ?>;



document.getElementById('CampaignID').value =<?php print $_SESSION["SCampaignId"]; ?>;



 </script>

 

 

 

 <?php 

 // check the number of rows in accounts 

 

 if(isset($_SESSION["SCampaignId"]) && ($_SESSION["SCampaignId"] != "")){

	

	  $getgroupeduserids ="SELECT * FROM ta_campaigns WHERE CampaignID='$_SESSION[SCampaignId]'";

	$getgroupeduseridsresult  = runQuery($getgroupeduserids);

	$splitgroupeduserids = explode("-",$getgroupeduseridsresult[0]["UserID"]);



	

	$tempforplayandpauesecampaignid = $_SESSION["SCampaignId"];

	

 

 

 $type123 = $getgroupeduseridsresult[0]["Status"];

 if($type123 == "A")

 {

 	?>

 	 <script type="text/javascript">

 	 

 	 document.getElementById("DisplayCmapignPlayPauseStatus").innerHTML = "<img src=../images/pause.png title='Pause The Campaign' alt='' onclick=updateplaypasuse('pause','<?php print $tempforplayandpauesecampaignid; ?>') >";

 	</script>

 	

 	<?php 

 }

 else if($type123 == "D")

 {

 	?>

 	 <script type="text/javascript">

 	 

 	 document.getElementById("DisplayCmapignPlayPauseStatus").innerHTML = "<img src=../images/play.png title='Play The Campaign' alt='' onclick=updateplaypasuse('play','<?php print $tempforplayandpauesecampaignid; ?>') >";

 	</script>

 	<?php 

 }

 else

 {

 }

 

 



	if(array_sum($splitgroupeduserids) >=1 ){

		$ACStatus = "yes";

		

	}

	else

	{

		$ACStatus = "no";

	}

 }

 

 ?>



 <?php 

 

 

 	  if(isset($_SESSION["SCampaignId"]) && ($_SESSION["SCampaignId"] != "")){

 	  	

 	  	?>

 	  	

 	  	

 	  	 <script type="text/javascript">

 	 

 	 document.getElementById("CampaignID").value = <?php  print $_SESSION["SCampaignId"] ?>;

 	</script>

 	

 	<?php 

 	   

 	  	if($ACStatus == "yes"){

 	  		

 	  		

 	  	  $getgroupeduserids ="SELECT * FROM ta_campaigns WHERE CampaignID='$_SESSION[SCampaignId]'";

	$getgroupeduseridsresult  = runQuery($getgroupeduserids);

	$splitgroupeduserids = explode("-",$getgroupeduseridsresult[0]["UserID"]);



 

 

 



	if(array_sum($splitgroupeduserids) >=1 ){

			

	for($t=0;$t<count($splitgroupeduserids);$t++){

	//pass each and every userid to  JS function



		

		if($splitgroupeduserids[$t] != ""){

			

		// get username by userid

	  	$getusernamebyuserid = "SELECT * FROM ta_users WHERE UserID='$splitgroupeduserids[$t]'";

		$getusernamebyuseridresult   = runQuery($getusernamebyuserid);

		$ousername = $getusernamebyuseridresult[0]["UserName"];





	?>



 <script type="text/javascript" language="javascript">

 ShowAllfeedsUsingCampaign();

 

 ShowNoRecordsForSaveTweets();

 ShowNoRecordsForFutureTweets();

 reloaddata();

 LoadAllAccounts('<?php print $ousername;?>');



 </script>

 	

 	  	

 <?php

		}

		



	}

	}

	

	

 	  		

 	  ?>

 	  

 	 



 	  <script type="text/javascript">

 	 

 	 document.getElementById("CampaignID").value = <?php  print $_SESSION["SCampaignId"] ?>;

 	 

 	  	 document.getElementById('others6').innerHTML=" <a      href=#  onclick=switchid('addaccounts');    > Accounts</a> ";



    	 

  	  document.getElementById('others1').innerHTML=" <a     href=#  onclick=switchid('keywords');    > Keywords</a> ";

  	  document.getElementById('others2').innerHTML=" <a     href=#   onclick=switchid('feeds');    > Feeds</a> ";

  	  document.getElementById('others3').innerHTML=" <a     href=#   onclick=switchid('autotweet');    > Auto Tweet</a> ";

  	  document.getElementById('others4').innerHTML=" <a     href=#   onclick=switchid('tracklinks');    > Follow Tools</a> ";

  	  document.getElementById('others5').innerHTML=" <a      href=#  onclick=switchid('trackcampaigns');    > Track Campaign</a> ";

  	  

 	  

 	  	</script>

 	  	

 	  





	<?php

	

 	  	}

 	  	else

 	  	{

 	  		

 	  		

 	  		?>

 	  		<script type="text/javascript">

 	  		document.getElementById('myDivforaccounts').innerHTML = "There are no Twitter accounts added to this campaign";

 	  		

 	  		

 	  		 document.getElementById('others6').innerHTML=" <a      href=#  onclick=switchid('addaccounts');    > Accounts</a> ";



    	 

  	  document.getElementById('others1').innerHTML=" <a      disabled  <?php  print 'id=tab'; ?>    > Keywords</a> ";

  	  document.getElementById('others2').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?>    > Feeds</a> ";

  	  document.getElementById('others3').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?>    > Auto Tweet</a> ";

  	  document.getElementById('others4').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?> > Follow Tools</a> ";

  	  document.getElementById('others5').innerHTML=" <a     disabled  <?php  print 'id=tab'; ?>  > Track Campaign</a> ";

  	</script>

 	  		<?php

 	  	}

 	  	

 	  	

 	  	if($_SESSION["selectedarray"] == "s")

 	  	

 	  	{

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('settings');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	   

 	   else if($_SESSION["selectedarray"] == "a")

 	  	

 	  	{

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('addaccounts');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	  	 

 	  	else if($_SESSION["selectedarray"] == "k")

 	  	

 	  	{

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('keywords');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	  	 

 	  	else if($_SESSION["selectedarray"] == "f")

 	  	

 	  	{

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('feeds');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	  	 

 	  	else if($_SESSION["selectedarray"] == "t")

 	  	

 	  	{

 	  	//	print "yes";

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('autotweet');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	  	 

 	  else 	if($_SESSION["selectedarray"] == "tl")

 	  	

 	  	{

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('tracklinks');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	  	 

 	  	else if($_SESSION["selectedarray"] == "tc")

 	  	

 	  	{

 	  		

 	  		?>

 	  		

 	  		<script type="text/javascript">

 	  		switchid('trackcampaigns');

 	  		</script>

 	  		

 	  		<?php 

 	  		

 	  	}

 	  	

 	  	else

 	  	{

 	  		

 	  	}

 	  	

 	  	?>

 	  	

 	  	

 	  	

 	  	

	  <?php 

 	  }

 	  else

 	  {

 	  	?>

 	  		<script type="text/javascript">

 	  		 

 	  		switchid('settings');

 	  		

 	  	 document.getElementById('others6').innerHTML=" <a   disabled  <?php  print 'id=tab'; ?>> Accounts</a> ";

 	  	 

 	   		 document.getElementById('others1').innerHTML=" <a   disabled  <?php  print 'id=tab'; ?>> Keywords</a> ";

 			   document.getElementById('others2').innerHTML=" <a   disabled  <?php  print 'id=tab'; ?> >Feeds</a> ";

 			   document.getElementById('others3').innerHTML="<a   disabled  <?php  print 'id=tab'; ?> >Auto Tweet </a>";

 			   document.getElementById('others4').innerHTML=" <a   disabled  <?php  print 'id=tab'; ?>> Follow Tools</a> ";

 			   document.getElementById('others5').innerHTML=" <a   disabled  <?php  print 'id=tab'; ?>>Track Campaign</a> ";

 	 	  		

 	 	  		

 	 	  		

//document.getElementById("addaccounts").style.visibility="hidden";

//document.getElementById("keywords").style.visibility="hidden";

//document.getElementById("feeds").style.visibility="hidden";

//document.getElementById("autotweet").style.visibility="hidden";

//document.getElementById("tracklinks").style.visibility="hidden";

//document.getElementById("trackcampaigns").style.visibility="hidden";

ShowAllfeedsUsingCampaign();



</script>

   	

   	

 	  	<?php 

 	  }

 	  

 ?>

  

 <?php 

		

			// get all tweet setting  by campaign id 

$getallsettings = "SELECT * FROM ta_save_tweets_settings WHERE CampaignID='$_SESSION[SCampaignId]'";

 $getallsettings = runQuery($getallsettings);

 

 if(count($getallsettings) == 1 )

 {

 	?>

 	<script type="text/javascript">

 	

 	document.getElementById("displaybutton").innerHTML="<input type=button name=updatesettings  class=inner_txtbtn_02  value=Save onclick=updatesettings1('<?php print $getallsettings[0]["Id"]; ?>')>";

 	

 	</script>

 	

 	<?php 

 }

 else

 {

 	?>

 	<script type="text/javascript">

 	

 	document.getElementById("displaybutton").innerHTML="<input type=button name=savesettings23121231233 class=inner_txtbtn_02  value=Save onclick=savesettingsuuu();>";

 	

 	</script>

 	<?php 

 }

  ?>

  

<?php

	

	// get all tweet messages frm save tweets table 
if(isset($_SESSION[SCampaignId]))
{
$getallmessages = "SELECT * FROM ta_save_tweets WHERE CampaignID='$_SESSION[SCampaignId]' order by id asc";



 $getallmessagesresult = runQuery($getallmessages);

 }

 

if(count($getallmessagesresult) >=1 )

{

	

	for($y=0;$y<count($getallmessagesresult);$y++){

		

		?>

		 

		<script type="text/javascript">

loadEventforsavetweets('<?php print $getallmessagesresult[$y]["TweetMessage"] ?>','<?php print $getallmessagesresult[$y]["CampaignID"] ?>','<?php print $getallmessagesresult[$y]["id"] ?>');

		</script>



<?php 

 

	}



}

?>



<?php

	

	// get all tweet messages frm save tweets table 

$getallmessages = "SELECT * FROM  ta_future_tweet_messages WHERE CampaignID='$_SESSION[SCampaignId]'";



 $getallmessagesresult = runQuery($getallmessages);

 

 

if(count($getallmessagesresult) >=1 )

{

	

	for($y=0;$y<count($getallmessagesresult);$y++){

		

		?>

		 

		<script type="text/javascript">

loadEventforfuturetweets('<?php print $getallmessagesresult[$y]["TweetMessage"] ?>','<?php print $getallmessagesresult[$y]["Date"] ?>','<?php print $getallmessagesresult[$y]["CampaignID"] ?>','<?php print $getallmessagesresult[$y]["id"] ?>','<?php print $getallmessagesresult[$y]["Status"] ?>');

		</script>

		

<?php 

 

	}

	

}



?>



<?php 



//show common campaign details 

 //if(isset($_REQUEST["c"]) && ($_REQUEST["c"] != "")){

 

if(isset($_SESSION["SCampaignId"]) && ($_SESSION["SCampaignId"] != "")){

	$getdetailsusingCampaign = "SELECT * FROM ta_campaigns WHERE CampaignID='$_SESSION[SCampaignId]'";

	$getdetailsusingCampaignresult  = runQuery($getdetailsusingCampaign);

	

	//show common campaign details



	?>

	 <script type="text/javascript" language="javascript">

	 document.getElementById("ShowNewcampaignAddButton").innerHTML = "<input type=button value=Update  class=inner_txtbtn_01  onclick=GetUpdatecampaignvalues('<?php print $getdetailsusingCampaignresult[0]["CampaignID"] ?>')>";

 

document.getElementById("campaignname").value  ='<?php print $getdetailsusingCampaignresult[0]["CampaignName"] ?>';

document.getElementById("campaignnamedesc").value  ='<?php print $getdetailsusingCampaignresult[0]["Campaigndesc"] ?>';

document.getElementById("start-date").value  ='<?php print $getdetailsusingCampaignresult[0]["StartDT"] ?>';

document.getElementById("end-date").value  ='<?php print $getdetailsusingCampaignresult[0]["EndDT"] ?>';



</script>

<?php 

 }

 else

 {

 	?>



 <script type="text/javascript" language="javascript">

	 document.getElementById("ShowNewcampaignAddButton").innerHTML = "<input type=button value=Save  class=inner_txtbtn_01  onclick=GetNewcampaignvalues()>";





</script>

 	<?php 

 }



?>							

  <?php



	include "../includes/footer.php";

} else {

	header("Location:../index.php");

}

?>





 



