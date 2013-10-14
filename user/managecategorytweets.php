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


function loadtweetmessages(selectedids){

	// call ajax 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	var url="autoloadtweetmessages.php";
	url=url+"?Do=Save&selecetedarray="+selectedids+"";
 

	//document.getElementById("Displaytweetsettingsstatus").innerHTML="Updating....";
	 
	xmlHttp.onreadystatechange=stateChangedloadtweetmessages;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);
}



function stateChangedloadtweetmessages() 
{ 
	 

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 

	  
	//document.getElementById("Displaytweetsettingsstatus").innerHTML="saved";
	//document.getElementById("ShowTweetMessages").innerHTML=xmlHttp.responseText;
	document.getElementById("showmessages").value=xmlHttp.responseText;

	 

	
	
	}		 
}


function getcategoryids(ob,CampaignID){

	var freq_id = document.getElementById('freq_id').value;
	
	oSelect = document.getElementById ('categoryname');
	var iNumSelected = 0;
	var selecetedarray = new Array();

	var ori =0;
	   for (var iCount=0; oSelect.options[iCount]; iCount++) {
		   
	        if (oSelect.options[iCount].selected == true) {
	            iNumSelected ++;
	           // alert(oSelect[iCount].value); // this part alerts all the result within the loop
	            selecetedarray[ori] = oSelect[iCount].value;
	            ori++;
	        }

	       
	   }

	// call ajax 
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  } 
		var url="updatecategorytweetssettings.php";
		url=url+"?Do=Save&freq_id="+freq_id+"&CampaignID="+CampaignID+"&selecetedarray="+selecetedarray+"";
	 

		document.getElementById("Displaytweetsettingsstatus").innerHTML="Updating....";
		 
		xmlHttp.onreadystatechange=stateChangedgetcategoryids;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(null);
	   
}


function stateChangedgetcategoryids() 
{ 
	 

if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 

	  
	document.getElementById("Displaytweetsettingsstatus").innerHTML="saved";
	//document.getElementById("ShowTweetMessages").innerHTML=xmlHttp.responseText;
	document.getElementById("showmessages").value=xmlHttp.responseText;

	 

	
	
	}		 
}



</script>

 

<tr>

	<td colspan="2">

	<table cellpadding="2" cellpadding="2">




		 
 <!--  work area -->
		
		<tr><td>  Update Frequency  
		<?php 
  $getdatausingcampaignid = "SELECT * FROM ta_category_tweet_messages_settings WHERE CampaignId  ='$CampaignID'";
$getdatausingcampaignidresult = runQuery($getdatausingcampaignid);
 

 if(count($getdatausingcampaignidresult) >=1)
 {
 	?>
 	<script type="text/javascript">
	 
loadtweetmessages('<?php print $getdatausingcampaignidresult[0]["CategoryIds"]?>');
 </script>
 	<?php 
 }
 
?>
		
		
		
    <select id="freq_id" name="freq_id">
  
  
   
<option value="1" <?php if($getdatausingcampaignidresult[0]["freq_id"] == 1) print "Selected" ?>>Every hour</option>
<option value="2" <?php if($getdatausingcampaignidresult[0]["freq_id"] == 2) print "Selected" ?>>Every 2 hours</option>
<option value="3" <?php if($getdatausingcampaignidresult[0]["freq_id"] == 3) print "Selected" ?>>Every 3 hours</option>
<option value="6" <?php if($getdatausingcampaignidresult[0]["freq_id"] == 6) print "Selected" ?>>Every 6 hours</option>
<option value="12" <?php if($getdatausingcampaignidresult[0]["freq_id"] == 12) print "Selected" ?>>Every 12 hours</option>
<option value="24" <?php if($getdatausingcampaignidresult[0]["freq_id"] == 24) print "Selected" ?>>Every 24 hours</option></select>
		</td>
		<?php 
		$getalllcategortnames ="SELECT * FROM ta_category";
		$getalllcategortnamesresult = runQuery($getalllcategortnames);
		
		
		$joinarray = explode(",",$getdatausingcampaignidresult[0]["CategoryIds"]);
		 
		?>
		<td>
		<select name="categoryname" id="categoryname" multiple="multiple"  onblur="getcategoryids(this.value,'<?php print $CampaignID;?>');">
		<?php 
		for($u=0;$u<count($getalllcategortnamesresult);$u++){
		?>
		<option value="<?php print $getalllcategortnamesresult[$u]["id"] ?>" <?php if(in_array($getalllcategortnamesresult[$u]["id"],$joinarray)){ print "Selected"; } ?>><?php print $getalllcategortnamesresult[$u]["CategoryName"] ?></option>
		
		<?php 
		}
		?>
		</select>
		<div id="Displaytweetsettingsstatus" ></div>
		 
		</td>
		</tr>
		
	 
	 
	 <tr><td colspan="2">
	 <!--   <div id="ShowTweetMessages"></div>-->  
	
	  <textarea name="wwet" id="showmessages" name="showmessages"  readonly rows="5" cols="80" ></textarea> 
	 
	 </td></tr>
  <!--  work area -->
 
 
</table>	</td>

</tr>

<script type="text/javascript">
	document.getElementById("showmessages").style.border="none";
//loadtweetmessages('<?php print $getdatausingcampaignidresult[0]["CategoryIds"]?>');
 </script>
 
<?php 
 


	include "../includes/footer.php";
}
else
{

	Header("Location:../index.php");


}
?>




