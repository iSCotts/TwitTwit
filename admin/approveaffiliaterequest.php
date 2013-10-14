<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){
if(isset($_REQUEST["id"]) && $_REQUEST["act"] == "d"){
		// delete case 
		$sql = "UPDATE `ta_affiliate_request` SET `Status` = 'D' WHERE  `id` ='$_REQUEST[id]'";
		$deletequerystatus = runQuery($sql);
}
if(isset($_REQUEST["id"]) && $_REQUEST["act"] == "a"){
		$token = md5(uniqid(rand(),1));
		// update wit h A Case 
		$updatequery = "UPDATE `ta_affiliate_request` SET `Status` = 'A' , `affiliateid` = '$token'  WHERE  `id` ='$_REQUEST[id]'";
		$updatequerystatus = runQuery($updatequery);
		// send email to Affiliate with affiliate URL 
		$getemailaddress  = "SELECT * FROM ta_affiliate_request WHERE `id` ='$_REQUEST[id]'";
		$getemailaddressresult = runQuery($getemailaddress);
		$url=SITE_URL.$token;
		$to = $getemailaddressresult[0]["EmailId"];
		$Mesasge = "Your Affiliate URL ".$url;
		$subject = "Your Affiliate URL";
		$headers = 'From: no-reply@twitjix.com' . "\r\n" .
			'Reply-To: no-reply@twitjix.com' . "\r\n" .
			'Cc: no-reply@twitjix.com' . "\r\n".
			'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $Mesasge, $headers);
}
?>
<td height="380" align="center" valign="top">
<script type="text/javascript">
    $(document).ready(function() {
      $("#changepassword").validate({
        rules: {
    	  oldpassword: "required",// simple rule, converted to {required:true}
          newpassword:"required",// simple rule, converted to {required:true}
          email: {// compound rule
          required: true,
          email: true
        },
        },
        
      });
    });
  </script>
<table cellpadding="2" cellspacing="2" width="100%" border="1">
<tr>
<td colspan="4" align="center"><strong>View Approved Affiliate Request</strong></td>
</tr>
<tr>
<td><strong>Sl No</strong></td>
<td><strong>User Id</strong></td>
<td><strong>Date</strong></td>
<td><strong>Cancel</strong></td>
</tr>
<?php
$getaffiliatedetails = "SELECT * FROM ta_affiliate_request WHERE Status ='A' ";
$getaffiliatedetailsresult  = runQuery($getaffiliatedetails);
 if( count($getaffiliatedetailsresult) >=1 )
  {
 for($r=0;$r<count($getaffiliatedetailsresult);$r++){
?>
<tr>
<td><?php echo $r+1;?></td>
<td><?php echo $getaffiliatedetailsresult[$r]["EmailId"]; ?> </td>
<td> <?php echo $getaffiliatedetailsresult[$r]["Date"]; ?></td>
<td> <a href="viewaffiliaterequest.php?id=<?php echo $getaffiliatedetailsresult[$r]["id"]; ?>&act=d">Cancel</a></td>
</tr>
<?
}
}
else
{
?>
<tr>
<td colspan="5">No Records Found</td>
</tr>
<?
}
?>
</table>
</td>
</tr>
<?php
include "includes/footer.php";
}
else
{
 header("Location:index.php?act=3");
 }
?>