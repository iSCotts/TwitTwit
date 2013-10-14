<?php
if($_SESSION["username"]!="" && $_SESSION["password"]!="" && basename($PHP_SELF)=="features_and_pricing.php" && $_REQUEST["CampaignID"]=="")
{
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>twitjix.com</title>
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<link href="facebox/faceplant.css" media="screen" rel="stylesheet" type="text/css" />-->

	<script src="js/DD_belatedPNG_0.0.7a-min.js"></script>
	<script>
	   DD_belatedPNG.fix('img, div, li');
	</script>
	
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="facebox/facebox.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loading_image : 'facebox/loading.gif',
			close_image   : 'facebox/closelabel.gif'
		  }) 
		})
	 </script>
</head>

<body>
<!-- Main Container Begin -->
<div class="main_container">

	<!-- Top Navigation Links Start -->
	<div class="top_navigation">
		<ul>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'home.php')) echo 'class="current"';?> href="user/home">Home</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'add_account.php')) echo 'class="current"';?> href="user/add_account">My Accounts</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'home.php')) echo 'class="current"';?> href="user/home">My Campaigns</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'mygroups.php')) echo 'class="current"';?> href="../group/mygroups">My Groups</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'logout.php')) echo 'class="current"';?> href="user/logout.php">Logout</a></li>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- Top Navigation Links End -->
	<!-- Banner Area Start -->
	<div class="banner_area_inner">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="banner_mid_inner">
			<div class="banner_left_inner">
				<div><img src="images/twitacc_logo.png" alt="" /></div>
			</div>
			
			<div class="banner_right_inner">
				<div class="caption_inner"><img src="images/caption.png" alt="The Twitter Accelerator !" /></div>
				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>
		</div>
		<div class="bx_btm"><div class="clear"></div></div>
	</div>
	<!-- Banner Area End -->	
	<?php } else 

if($_SESSION["username"] != "" && $_SESSION["password"] !="" )
{
include_once "../config/config.php";
include_once "../common/sqlFunctions.php";
include_once "../classes/Database.php";
include_once "../classes/Mysql.php";
if(file_exists("JSON.php"))
{
include("JSON.php");
}
$jsonurl = "http://twitter.com/followers/ids.json?user=".$_SESSION["username"];
$abc = file_get_contents($jsonurl);

if($abc===false){
die('request failed');

}
 $results=json_decode($abc);
 $followcount = count($results);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>twitjix.com</title>



<link	href="../css/ucss.css" rel="stylesheet" type="text/css" />
<script	type="text/javascript" src="../js/datepiker.js"></script>
<link	rel="stylesheet" href="../css/style.css" type="text/css" />
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script	src="../js/jquery.validate.js" type="text/javascript"></script>
<script src="../facebox/facebox.js" type="text/javascript"></script>

 <link href="../css/main.css" rel="stylesheet" type="text/css" />
	<script src="../js/DD_belatedPNG_0.0.7a-min.js"></script>
	<script>
	   DD_belatedPNG.fix('img, div, li');
	</script>
<script type="text/javascript" src="../js/accordian.js"></script>



<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loading_image : '../facebox/loading.gif',
			close_image   : '../facebox/closelabel.gif'
		  }) 
		})

	 </script>
<script type="text/javascript">
//here you place the ids of every element you want.
var ids=new Array('settings','addaccounts','keywords','feeds','autotweet','tracklinks','trackcampaigns');

function switchid(id){	

	 
	 <?php 
	 
	// unset($_SESSION["aaa"]);
	 
			//	$_SESSION["selectedtabU"] = "";
				
				?>
	
	
	hideallids();
	var CID = document.getElementById("CampaignID").value;

	//alert(word);

//	if(ar != "ar"){
//	  window.location = "campaign.php?c="+camid+"&m="+word;
	//}
	//else
	//{
	//	showdiv(id,CID); 
//	}
	showdiv(id,CID); 
	
	//return false;
	
	 

	


		// call ajax
		 xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  }
		var url="assignselectedtab.php";
		url=url+"?Do=Save&id="+id+"";

 
	//	document.getElementById("DisplayAllFeedsusingCampaignsFFF").innerHTML  ="loading Feeds....";

		xmlHttp.onreadystatechange=stateChangedswitchid;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);

			//return false;


		
		 
 
	
	
}


function stateChangedswitchid()
{


if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	
	//document.getElementById("CampaignID").value = ;
	
	}
}


function hideallids(){
	//loop through the array and hide each element by id
	for (var i=0;i<ids.length;i++){
		hidediv(ids[i]);
	}		  
}

function hidediv(id) {
	//safe function to hide an element with a specified id
	if (document.getElementById) { // DOM3 = IE5, NS6
		document.getElementById(id).style.display = 'none';
	}
	else {
		if (document.layers) { // Netscape 4
			document.id.display = 'none';
		}
		else { // IE 4
			document.all.id.style.display = 'none';
		}
	}
}

function showdiv(id,CID) {
	//safe function to show an element with a specified id
	
 
    
	
	 document.getElementById("CampaignID").value = CID;
	 
	
	 
	
	if (document.getElementById) { // DOM3 = IE5, NS6
		document.getElementById(id).style.display = 'block';
	}
	else {
		if (document.layers) { // Netscape 4
			document.id.display = 'block';
		}
		else { // IE 4
			document.all.id.style.display = 'block';
		}
	}
}
</script>
<script type="text/javascript" language="javascript">

function AddCampaignValidation()
{

	var startdate = document.addcampaign.startdate.value;
	var enddate = document.addcampaign.enddate.value; 

	//alert(startdate);
	//alert(enddate);
}
function Accountvalidation()
{

var username1 = document.getElementById("username1").value; 
var password1 =  document.getElementById("password1").value; 
 //name field

    if (username1 == "" || username1 == null || !isNaN(username1) || username1.charAt(0) == ' ')

    {

    alert("\"username\" is a mandatory field.\nPlease amend and retry.")
document.getElementById("username1").value ='';
document.getElementById("username1").focus(); 
    return false;

    }
	
	
	  if (password1 == "" || password1 == null || !isNaN(password1) || password1.charAt(0) == ' ')

    {

    alert("\"password\" is a mandatory field.\nPlease amend and retry.")
document.getElementById("password1").value ='';
document.getElementById("password1").focus(); 
    return false;

    }


	  var url="d.php";
		url=url+"?Do=Save&username1="+username1+"&password1="+password1+"";
	window.location= url;

}

function UpdtaeAccountvalidation()
{

var username1 = document.getElementById("username1").value; 
var password1 =  document.getElementById("password1").value;
var uidnew =  document.getElementById("uidnew").value; 
var RefID =  document.getElementById("RefID").value; 
 //name field

    if (username1 == "" || username1 == null || !isNaN(username1) || username1.charAt(0) == ' ')

    {

    alert("\"username\" is a mandatory field.\nPlease amend and retry.")
document.getElementById("username1").value ='';
document.getElementById("username1").focus(); 
    return false;

    }
	
	
	  if (password1 == "" || password1 == null || !isNaN(password1) || password1.charAt(0) == ' ')

    {

    alert("\"password\" is a mandatory field.\nPlease amend and retry.")
document.getElementById("password1").value ='';
document.getElementById("password1").focus(); 
    return false;

    }


	  var url="edit_action.php";
		url=url+"?Do=Save&username1="+username1+"&password1="+password1+"&uidnew="+uidnew+"&RefID="+RefID+"";
	window.location= url;
	
	
}


</script>

<script type="text/javascript" language="javascript">

function ShowAllfeedsUsingCampaign(){
	var CampaignID = document.getElementById('CampaignID').value;

	// call ajax
	 xmlHttpforfeeds=GetXmlHttpObject();
	if (xmlHttpforfeeds==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url="loadallfeedsusingcampaigns.php";
	url=url+"?Do=Save&CampaignID="+CampaignID+"";
 

 
	document.getElementById("DisplayAllFeedsusingCampaignsFFF").innerHTML  ="loading Feeds234....";

	xmlHttpforfeeds.onreadystatechange=stateChangedShowAllfeedsUsingCampaign;
	xmlHttpforfeeds.open("POST",url,true);
	xmlHttpforfeeds.send(null);

		//return false;

}

function stateChangedShowAllfeedsUsingCampaign()
{


if (xmlHttpforfeeds.readyState==4 || xmlHttpforfeeds.readyState=="complete")
 {
	 
	
	document.getElementById("DisplayAllFeedsusingCampaignsFFF").innerHTML  =xmlHttpforfeeds.responseText;
	}
}

function RssformValidation()
{

	
var feedname = document.getElementById("feed_feedname").value;
var feedurl = document.getElementById("feed_feedurl").value;
var sortid = document.getElementById("sortid").value; 
var freq_id = document.getElementById("feed_freq_id").value; 
var showdesc = document.getElementById("feed_showdesc").value; 
 
if(document.getElementById("posturl").checked == true)
{
var posturl =1;

}
else
	var posturl =0;	
 

if(document.getElementById("shorturl").checked == true)
{
var shorturl =1;

}
else
	var shorturl =0;	
 //name field

    if (feedname == "" || feedname == null || !isNaN(feedname) || feedname.charAt(0) == ' ')

    {

  //  alert("\"feedname\" is a mandatory field.\nPlease amend and retry.")
    document.getElementById("feed_feednamev").innerHTML ="Please enter the   feedname";

    
document.getElementById("feed_feedname").value ='';
    document.getElementById("feed_feedname").focus(); 
    RssformValidation();
    
    return false;

    }
	

    if (feedname != "" )

    {
    	  document.getElementById("feed_feednamev").innerHTML ="";
    }
    
    
	  if (feedurl == "" || feedurl == null || !isNaN(feedurl) || feedurl.charAt(0) == ' ')

    {
		  
		 
		  
   // alert("\"feedurl\" is a mandatory field.\nPlease amend and retry.")
    document.getElementById("feed_feedurlv").innerHTML ="Please enter the   Feedurl";
    
document.getElementById("feed_feedurl").value ='';
    document.getElementById("feed_feedurl").focus(); 
    RssformValidation();
    return false;

    }


	  if (feedurl != "" )

	    {
	    	  document.getElementById("feed_feedurlv").innerHTML ="";
	    }

	    
	// if(document.rssform.isactive.checked == false)
	//  {

	//	  alert("\"Active url\" is a mandatory field.\nPlease amend and retry.")
			 
	//		document.rssform.isactive.focus(); 
	//		    return false;
	//  }



	  

	//  if(document.rssform.posturl.checked == false)
	//  {

	//	  alert("\"posturl\" is a mandatory field.\nPlease amend and retry.")
			 
	//		document.rssform.posturl.focus(); 
	//		    return false;
	//  }

	  
	  
	  
 
	

	  if (sortid == "0" )

	    {

	  //  alert("\"sortid\" is a mandatory field.\nPlease amend and retry.")
	  document.getElementById("sortidv").innerHTML ="Please Select  the   Sortid";
	document.getElementById("sortid").focus(); 
	    return false;

	    }



	 
	  
	  if (freq_id == "0" )

	    {

	  //  alert("\"Update Frequency\" is a mandatory field.\nPlease amend and retry.")
	   document.getElementById("feed_freq_idv").innerHTML ="Please Select  the   Frequency";
	document.getElementById("feed_freq_id").focus(); 
	    return false;

	    }


	  
	  if (showdesc == "22" )

	    {

	//    alert("\"Post Content\" is a mandatory field.\nPlease amend and retry.")
	  document.getElementById("feed_showdescv").innerHTML ="Please Select  the   Content";
	document.getElementById("feed_showdesc").focus(); 
	    return false;

	    }
	

		var CampaignID = document.getElementById('CampaignID').value;
		var username = document.getElementById('susername').value;
	// call ajax
		 xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  }
		var url="feed.php";
		url=url+"?Do=Save&CampaignID="+CampaignID+"&feedname="+feedname+"&feedurl="+feedurl+"&sortid="+sortid+"&freq_id="+freq_id+"&showdesc="+showdesc+"&posturl="+posturl+"&shorturl="+shorturl+"&username="+username+"";

	 
		document.getElementById("DisplayStatusForAddingfeeddetails").innerHTML  ="Adding the feed";

		xmlHttp.onreadystatechange=stateChangedRssformValidation;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);


			//return false;

	
}

function stateChangedRssformValidation()
{


if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	
	document.getElementById("feed_feedname").value = '';
	  document.getElementById("feed_feedurl").value = '';
	 document.getElementById("sortid").value = '0'; 
	  document.getElementById("feed_freq_id").value = '0'; 
	  document.getElementById("feed_showdesc").value = '22'; 
	  
	  document.getElementById("feed_urlstatus").value = ''; 
	 
	document.getElementById("posturl").checked  = false;
	document.getElementById("shorturl").checked = false;
	
	
		
	document.getElementById("DisplayStatusForAddingfeeddetails").innerHTML  =xmlHttp.responseText;
	
	ShowAllfeedsUsingCampaign();

	}
}



function UpdateRssformValidation(feedrowid)
{

	
var feedname = document.getElementById("feed_feedname").value;
var feedurl = document.getElementById("feed_feedurl").value;
var sortid = document.getElementById("sortid").value; 
var freq_id = document.getElementById("feed_freq_id").value; 
var showdesc = document.getElementById("feed_showdesc").value; 
 
if(document.getElementById("posturl").checked == true)
{
var posturl =1;

}
else
	var posturl =0;	
 

if(document.getElementById("shorturl").checked == true)
{
var shorturl =1;

}
else
	var shorturl =0;	
 //name field

    if (feedname == "" || feedname == null || !isNaN(feedname) || feedname.charAt(0) == ' ')

    {

   // alert("\"feedname\" is a mandatory field.\nPlease amend and retry.")
  // document.getElementById("feed_feednamev").value ="Please enter the  feedname";
   document.getElementById("feed_feednamev").innerHTML ="Please enter the   feedname";

   
	document.getElementById("feed_feedname").value ='';
    document.getElementById("feed_feedname").focus(); 
    return false;

    }
	
    if (feedname != "" )

    {
    	  document.getElementById("feed_feednamev").innerHTML ="";
    }

    
	  if (feedurl == "" || feedurl == null || !isNaN(feedurl) || feedurl.charAt(0) == ' ')

    {

    //alert("\"feedurl\" is a mandatory field.\nPlease amend and retry.")
     document.getElementById("feed_feedurlv").innerHTML ="Please enter the   Feedurl";
    
document.getElementById("feed_feedurl").value ='';
    document.getElementById("feed_feedurl").focus(); 
    return false;

    }



	  if (feedurl != "" )

	    {
	    	  document.getElementById("feed_feedurlv").innerHTML ="";
	    }

	  

	// if(document.rssform.isactive.checked == false)
	//  {

	//	  alert("\"Active url\" is a mandatory field.\nPlease amend and retry.")
			 
	//		document.rssform.isactive.focus(); 
	//		    return false;
	//  }



	  

	//  if(document.rssform.posturl.checked == false)
	//  {

	//	  alert("\"posturl\" is a mandatory field.\nPlease amend and retry.")
			 
	//		document.rssform.posturl.focus(); 
	//		    return false;
	//  }

	  if (sortid == "0" )
	    {

	 //   alert("\"sortid\" is a mandatory field.\nPlease amend and retry.")
	   document.getElementById("sortidv").innerHTML ="Please Select  the   Sortid";
	document.getElementById("sortid").focus(); 
	    return false;
	    }
  
	  if (freq_id == "0" )

	    {

	//    alert("\"Update Frequency\" is a mandatory field.\nPlease amend and retry.")
	   document.getElementById("feed_freq_idv").innerHTML ="Please Select  the   Frequency";
	document.getElementById("feed_freq_id").focus(); 
	    return false;

	    }
	  if (showdesc == "22" )

	    {

	   // alert("\"Post Content\" is a mandatory field.\nPlease amend and retry.")
	  document.getElementById("feed_showdescv").innerHTML ="Please Select  the   Content";
	document.getElementById("feed_showdesc").focus(); 
	    return false;

	    }
	

		var CampaignID = document.getElementById('CampaignID').value;
		var username = document.getElementById('susername').value;
	// call ajax
		 xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  }
		var url="updtaefeed.php";
		url=url+"?Do=Save&CampaignID="+CampaignID+"&feedname="+feedname+"&feedurl="+feedurl+"&sortid="+sortid+"&freq_id="+freq_id+"&showdesc="+showdesc+"&posturl="+posturl+"&shorturl="+shorturl+"&username="+username+"&feedrowid="+feedrowid+"";

		
		document.getElementById("DisplayStatusForAddingfeeddetails").innerHTML  ="Updating Feeds....";

		xmlHttp.onreadystatechange=stateChangedUpdateRssformValidation;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);

			//return false;

}

function stateChangedUpdateRssformValidation()
{


if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	
	document.getElementById("feed_feedname").value = '';
	  document.getElementById("feed_feedurl").value = '';
	 document.getElementById("sortid").value = '0'; 
	  document.getElementById("feed_freq_id").value = '0'; 
	  document.getElementById("feed_showdesc").value = '22'; 
	  
	  document.getElementById("feed_urlstatus").value = ''; 
	 
	document.getElementById("posturl").checked  = false;
	document.getElementById("shorturl").checked = false;
	
	
		
	document.getElementById("DisplayStatusForAddingfeeddetails").innerHTML  =xmlHttp.responseText;
	document.getElementById("ShowFeedButton").innerHTML  ="<input type=button value=Save id=xx class=inner_txtbtn_01 onclick=RssformValidation() >";
	ShowAllfeedsUsingCampaign();

	}
}

</script>

 <script  type="text/javascript">

 function LoadAllAccounts(username)
 {
	    
	 
	
	 if(document.getElementById('myDivforaccounts').innerHTML == "There are no Twitter accounts added to this campaign"){
			document.getElementById('myDivforaccounts').innerHTML = " ";}

		//alert(document.getElementById("theValueforaccounts").value);
		
		var username =username;
	 
	  var niu = document.getElementById('myDivforaccounts');
	  var numi = document.getElementById('theValueforaccounts');
	  var num = (document.getElementById("theValueforaccounts").value -1)+ 2;
	  numi.value = num;
	  var divIdName = "my"+num+"Divforaccounts";
	  var ids = num;
	  var newdivuu = document.createElement('div');
	  newdivuu.setAttribute("id",divIdName);
	 // newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25%><font face=verdana size=2>Operating System</td><td><input type=text name=osajax"+ids+"  id=osajax"+ids+"  /></td></tr><tr> <td valign=top width=195><font face=verdana size=2>Specs  </td><td><textarea name=Specsajax"+ids+"  id=Specsajax"+ids+"   rows=3 cols=40/></textarea><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">Remove  </a></td></tr></table>";

	  //newdiv.innerHTML =    "<table cellspacing=2 cellpadding=2 width=719px style=\"background:none\" align=left border=0><tr class=account_01> <td class=tweet_name style=\"background:none\" ><input type=hidden id=osajax"+ids+" name=osajax"+ids+" value="+username+" >"+username+"</td><td align=right class=tweet_actions style=\"background:none\" ><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\',\'"+username+"\')\"><img src=../images/close.png title=Close alt=>  </a></td></tr></table>";
	 // newdiv.innerHTML =    "<table cellspacing=2 cellpadding=2 width=719px style=\"background:none\" align=left border=0><tr class=account_01> <td class=tweet_name style=\"background:none\" >
		 // <input type=hidden id=osajax"+ids+" name=osajax"+ids+" value="+username+" >"+username+"</td>
		//  <td align=right class=tweet_actions style=\"background:none\" ><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\',\'"+username+"\')\"><img src=../images/close.png title=Close alt=>  </a></td></tr></table>";


	  newdivuu.innerHTML = " <div class=\"account_01\">	<div class=\"account_name\"><input type=hidden id=osajax"+ids+" name=osajax"+ids+" value="+username+" >"+username+"</div>	<div class=\"account_close\"><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\',\'"+username+"\')\"><img src=../images/close.png title=Close alt=>  </a></div>	<div class=\"clear\"></div></div>";

	 
	  
	  
		//var opid = "opid"+ids;
	  //document.getElementById(opid).disabled = true;
	  // alert(newdiv.innerHTML);
	  document.getElementById(username).disabled = true;
	  
	 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";

	  niu.appendChild(newdivuu);
	  
 }
 
function addEvent(username,ssusername) {

 

	 
	
	if(document.getElementById('myDivforaccounts').innerHTML == "There are no Twitter accounts added to this campaign"){
	document.getElementById('myDivforaccounts').innerHTML = " ";}
	

	
	ShowNoRecordsForSaveTweets();
	ShowNoRecordsForFutureTweets();

	document.getElementById("keywords").style.visibility="visible";
	document.getElementById("feeds").style.visibility="visible";
	document.getElementById("autotweet").style.visibility="visible";
	document.getElementById("tracklinks").style.visibility="visible";
	document.getElementById("trackcampaigns").style.visibility="visible";

	var CampaignID = document.getElementById('CampaignID').value;
	var username = username;
	

	// call ajax
	 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url="editcampaign_action.php";
	url=url+"?Do=Save&CampaignID="+CampaignID+"&usernamefff="+username+"&ssusername="+ssusername+"";

 
 
	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  ="Adding the account";

	xmlHttp.onreadystatechange=stateChangedGetuseraccountsndSave;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);


		//return false;
		
	
		
	// alert(username);
	var username =username;
 
  var ni = document.getElementById('myDivforaccounts');
  var numi = document.getElementById('theValueforaccounts');
  var num = (document.getElementById("theValueforaccounts").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"Divforaccounts";
  var ids = num;
  var newdiv = document.createElement('div');
  newdiv.setAttribute("id",divIdName);
 // newdiv.innerHTML =    " <table cellspacing=2 cellpadding=2 width=100% border=0><tr> <td width=25%><font face=verdana size=2>Operating System</td><td><input type=text name=osajax"+ids+"  id=osajax"+ids+"  /></td></tr><tr> <td valign=top width=195><font face=verdana size=2>Specs  </td><td><textarea name=Specsajax"+ids+"  id=Specsajax"+ids+"   rows=3 cols=40/></textarea><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">Remove  </a></td></tr></table>";

  //newdiv.innerHTML =    "<table cellspacing=2 cellpadding=2 width=719px style=\"background:none\" align=left border=0><tr class=account_01> <td class=tweet_name style=\"background:none\" ><input type=hidden id=osajax"+ids+" name=osajax"+ids+" value="+username+" >"+username+"</td><td align=right class=tweet_actions style=\"background:none\" ><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\',\'"+username+"\')\"><img src=../images/close.png title=Close alt=>  </a></td></tr></table>";
 // newdiv.innerHTML =    "<table cellspacing=2 cellpadding=2 width=719px style=\"background:none\" align=left border=0><tr class=account_01> <td class=tweet_name style=\"background:none\" >
	 // <input type=hidden id=osajax"+ids+" name=osajax"+ids+" value="+username+" >"+username+"</td>
	//  <td align=right class=tweet_actions style=\"background:none\" ><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\',\'"+username+"\')\"><img src=../images/close.png title=Close alt=>  </a></td></tr></table>";


  newdiv.innerHTML = " <div class=\"account_01\">	<div class=\"account_name\"><input type=hidden id=osajax"+ids+" name=osajax"+ids+" value="+username+" >"+username+"</div>	<div class=\"account_close\"><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\',\'"+username+"\')\"><img src=../images/close.png title=Close alt=>  </a></div>	<div class=\"clear\"></div></div>";
	


 
  var numuu = document.getElementById("theValueforaccounts").value;
  

    if(numuu  == 0)
    {


  	  document.getElementById('others1').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?>     > Keywords</a> ";
  	  document.getElementById('others2').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?>     > Feeds</a> ";
  	  document.getElementById('others3').innerHTML=" <a     disabled  <?php  print 'id=tab'; ?>    > Auto Tweet</a> ";
  	  document.getElementById('others4').innerHTML=" <a      disabled  <?php  print 'id=tab'; ?>    > Track Links</a> ";
  	  document.getElementById('others5').innerHTML=" <a       disabled  <?php  print 'id=tab'; ?> > Track Campaign</a> ";


  	  
    }
    else
    {


  

    	
    	 document.getElementById('others6').innerHTML=" <a      href=#  onclick=switchid('addaccounts');    > Accounts</a> ";

    	 
  	  document.getElementById('others1').innerHTML=" <a     href=#  onclick=switchid('keywords');    > Keywords</a> ";
  	  document.getElementById('others2').innerHTML=" <a     href=#   onclick=switchid('feeds');    > Feeds</a> ";
  	  document.getElementById('others3').innerHTML=" <a     href=#   onclick=switchid('autotweet');    > Auto Tweet</a> ";
  	  document.getElementById('others4').innerHTML=" <a     href=#   onclick=switchid('tracklinks');    > Track Links</a> ";
  	  document.getElementById('others5').innerHTML=" <a      href=#  onclick=switchid('trackcampaigns');    > Track Campaign</a> ";
  	
    }
    


  
  
  

	//var opid = "opid"+ids;
  //document.getElementById(opid).disabled = true;
//   alert(username);
  document.getElementById(username).disabled = true;
  
 //newdiv.innerHTML ="<input type=text name=city"+ids+" id=city"+ids+"  > <a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">remove</a>";


  ni.appendChild(newdiv);

 
  
}

function removeElement(divNum,ids) {
	var CampaignID = document.getElementById('CampaignID').value;
		var username = ids;
	

	// call ajax
	 xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url="deletecampaign_action.php";
	url=url+"?Do=Save&CampaignID="+CampaignID+"&username="+username+"";

 
	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  ="Deleting the account";

	xmlHttp.onreadystatechange=stateChangedremoveElement;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);


		//return false;

	
  var d = document.getElementById('myDivforaccounts');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
 // var opid = "opid"+ids;
 
 // document.getElementById(opid).disabled = false;
  document.getElementById(ids).disabled = false;




  /*var ni = document.getElementById('myDivforaccounts');
  var numi = document.getElementById('theValueforaccounts');
  var num = document.getElementById("theValueforaccounts").value;
alert(num);

  if(num == 0){
  document.getElementById('myDivforaccounts').innerHTML = "There are no Twitter accounts added to this campaign";

  }*/
  
  

  
  // LoadAllAccounts(username);
}

function stateChangedremoveElement()
{


if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {


	var splitresult = xmlHttp.responseText.split("-");
	var errormessage = splitresult[0];
	var CIDu = splitresult[1];
	var st = splitresult[2];


	 
	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  =errormessage;
	
	 
	reloaddata();
	// window.location = "campaign.php?c="+CIDu+"&m=a";


	//var numuudddd = document.getElementById("theValueforaccounts").value;
	  
 
    if(st  == "no")
    {


  	  document.getElementById('others1').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?>     > Keywords<a> ";
  	  document.getElementById('others2').innerHTML=" <a    disabled  <?php  print 'id=tab'; ?>     > Feeds<a> ";
  	  document.getElementById('others3').innerHTML=" <a     disabled  <?php  print 'id=tab'; ?>    > Auto Tweet<a> ";
  	  document.getElementById('others4').innerHTML=" <a      disabled  <?php  print 'id=tab'; ?>    > Track Links<a> ";
  	  document.getElementById('others5').innerHTML=" <a       disabled  <?php  print 'id=tab'; ?> > Track Campaign<a> ";


  	  
    }
    else
    {
  	  document.getElementById('others1').innerHTML=" <a     onclick=switchid('keywords');    > Keywords<a> ";
  	  document.getElementById('others2').innerHTML=" <a     onclick=switchid('feeds');    > Feeds<a> ";
  	  document.getElementById('others3').innerHTML=" <a     onclick=switchid('autotweet');    > Auto Tweet<a> ";
  	  document.getElementById('others4').innerHTML=" <a     onclick=switchid('tracklinks');    > Track Links<a> ";
  	  document.getElementById('others5').innerHTML=" <a     onclick=switchid('trackcampaigns');    > Track Campaign<a> ";
  	  
    }
    



	
	 
	}
}


function stateChangedGetuseraccountsndSave()
{


if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {

	 
	var splitresult = xmlHttp.responseText.split("-");
	var errormessage = splitresult[0];
	var CID = splitresult[1];
 
	
	document.getElementById("DisplayStatusForSavingAccountsUsingCampaignId").innerHTML  =errormessage;
	
	 ShowAllfeedsUsingCampaign();

	  //  window.location = "campaign.php?c="+CID+"&m=a";

	  
	 

		
	}
}

</script>

</head>

<body onload="new Accordian('basic-accordian',5,'campaign_slide02');">
<!-- Main Container Begin -->
<div class="main_container">

	<!-- Top Navigation Links Start -->
	<div class="top_navigation">
		<ul>
		<li><div class="affiliate"><a href="javascript: jQuery.facebox({ajax:'../includes/affiliate.html'});">Become An Affiliate</a></div></li><li> &nbsp; &nbsp; </li>
		
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'home.php')) echo 'class="current"';?> href="home">Home</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'add_account.php')) echo 'class="current"';?> href="add_account">My Accounts</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'home.php')) echo 'class="current"';?> href="home">My Campaigns</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'mygroups.php')) echo 'class="current"';?> href="../group/mygroups">My Groups</a></li><li>|</li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- Top Navigation Links End -->
	
	<!-- Banner Area Start -->
	<div class="banner_area_inner">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="banner_mid_inner">
			<div class="banner_left_inner">
				<div><img src="../images/twitacc_logo.png" alt="" /></div>
			</div>
			
			<div class="banner_right_inner">
			<!--  	<div class="logout_inner"><a href="logout">Logout</a></div>-->
			<div class="welcomemsg">You are logged in as <strong><?php print $_SESSION["username"];?></strong></div>
				<div class="caption_inner"><img src="../images/caption.png" alt="The Twitter Accelerator !" /></div>
					
				
				
				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>
		</div>
		<div class="bx_btm"><div class="clear"></div></div>
	</div>
	<!-- Banner Area End -->
	<?php }
else {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>twitjix.com</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
	<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="js/DD_belatedPNG_0.0.7a-min.js"></script>
	<script>
	   DD_belatedPNG.fix('img, div, li');
	</script>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="facebox/facebox.js" type="text/javascript"></script>
	<script src="js/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  $('a[rel*=facebox]').facebox({
			loading_image : 'facebox/loading.gif',
			close_image   : 'facebox/closelabel.gif'
		  }) 
		})
	 </script>
</head>

<body>
<!-- Main Container Begin -->
<div class="main_container">

	<!-- Top Navigation Links Start -->
	<div class="top_navigation">
		<ul>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo 'class="current"';?> href="index">Home</a></li><li>|</li>
			<li><a <?php if (strpos($_SERVER['PHP_SELF'], 'features_and_pricing.php')) echo 'class="current"';?> href="features_and_pricing">Features &amp; Pricing</a></li><li>|</li>
			<li><a href="#">Terms</a></li><li>|</li>
			<li><a href="#">Contact</a></li>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- Top Navigation Links End -->
	
	<!-- Banner Area Start -->
	<div class="banner_area_inner">
		<div class="bx_top"><div class="clear"></div></div>
		<div class="banner_mid_inner">
			<div class="banner_left_inner">
				<div><img src="images/twitacc_logo.png" alt="" /></div>
			</div>
			
			<div class="banner_right_inner">
				<div class="caption_inner"><img src="images/caption.png" alt="The Twitter Accelerator !" /></div>
				<div class="clear"></div>
			</div>
			
			<div class="clear"></div>
		</div>
		<div class="bx_btm"><div class="clear"></div></div>
	</div>
	<!-- Banner Area End -->
	<?php }?>
 

	
 