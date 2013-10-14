<?php
ob_start();
session_start();
 
include '../classes/dbClient.php';
include '../common/sqlFunctions.php';

 ?>
 
 
 <?php 
 

 $refuser123 = $_SESSION["username"];
   $CampaignID = $_REQUEST["CampaignID"];
 
 
 //-------------------
	    $sqlsubs = "SELECT *  FROM ta_users WHERE UserName ='$refuser123'";
	  
	  $GetSubscriberscount = runQuery($sqlsubs);
	  	  $refuser = $GetSubscriberscount[0]["RefID"];
		  
	 //-------------------
	//   if(isset($_REQUEST["delete"]) && $_REQUEST["delete{
	   
	   
 


?>
 

 

 


 

<?php

  //  $sql = "SELECT * FROM ta_users WHERE RefID ='$refuser' AND UserName!='$refuser123' ";
  
   //$sql = "SELECT * FROM ta_feeds WHERE UserID ='$refuser123' ";
   $sql = "SELECT * FROM ta_feeds WHERE CampaignID ='$CampaignID' ";
 
$GetAdminUserlist = runQuery($sql);
$i=1;
$result = '';

if(count($GetAdminUserlist) >0){
	

for($k=0;$k<count($GetAdminUserlist);$k++){
 
 $fname = $GetAdminUserlist[$k]["feedname"];
 $furl = $GetAdminUserlist[$k]["feedurl"];
 $rowid = $GetAdminUserlist[$k]["id"];
 $CampaignID = $GetAdminUserlist[$k]["CampaignID"];
 
 $result .="<div class=account_01>";
 $result .="<div class=feed_name>$fname</div>";
 $result .="<div class=feed_url>$furl</div>";
 $result .="<div class=feeds_close> <img src=../images/edit.jpg title=Edit  onclick=doupdate($rowid);> </div>";
 
 $result .="<div class=feeds_close><img src=../images/close.png title=Delete  onclick=dodelete($rowid); ></div>";
 
 $result .="<div class=clear></div>";
 
  $result .="</div>";
  
 
 //$result .="<input type=hidden name=feedrowid id=feedrowid value=$rowid>";
 


  $result .="<input type=hidden name=CampaignID  id=CampaignID value=$CampaignID>";
 

 
 
 
 
  


 


 


 
 
$i++;
 }
 
  print $result;
}
else
{
	
	print "There are no feeds added to this campaign";
}

 
?>

 


 

 