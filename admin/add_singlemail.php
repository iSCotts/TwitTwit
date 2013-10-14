<?php
ob_start();
session_start();
include  "../classes/dbClient.php";
include '../common/sqlFunctions.php';
include "includes/header.php";
include "includes/left.php";
//patht to the fckeditor class
include("fckeditor/fckeditor.php");

if(isset($_SESSION["uname"]) && ($_SESSION["uname"] != "") && ($_SESSION["type"] = "yes")){

	$GetErrorCode = $_REQUEST["act"];
	if($GetErrorCode == 1)
	$ErrorMessage = "Mail send successfully";
if(isset($_REQUEST["Add"]) && $_REQUEST["Add"] == "Send"){
$mailcontent=$_REQUEST['mailcontent'];
if($mailcontent=="")
{
	$ErrorMessage = "Please enter your mail contents";
	}
	else{
$frommail = addslashes($_REQUEST["frommail"]);
$tomail = addslashes($_REQUEST["tomail"]);
$subjectmail = addslashes($_REQUEST["subjectmail"]);
$sentdate =   date("Y-m-d");
//sending mails
	$headers = 'From:'.$frommail."\r\n" .
    'Reply-To: '.$tomail."\r\n" .
	 'X-Mailer: PHP/'.phpversion();
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject=$subjectmail;
	$body=$mailcontent;
	$mailto=$tomail;
	mail($mailto, $subject, $body, $headers);
 $sql = "INSERT INTO  `ta_sent_mails` (`frommail` ,`tomail` ,`subject`,`content`,`sentdate`)VALUES ('$frommail', '$tomail', '$subjectmail','$mailcontent','$sentdate')";
		
		if(executeQuery($sql) == 1){
		header("Location:sentmails.php?act=1");
		exit;
		}
		else{
		$ErrorMessage = "Some problem while sending ";
		}
	}
}

// Insert Package area 
?>

<td height="380" align="center" valign="top">

<script type="text/javascript">
    $(document).ready(function() {
      $("#addemails").validate({
        rules: {
    	  frommail: "required",// simple rule, converted to {required:true}
    	  tomail:"required",// simple rule, converted to {required:true}
    	  subjectmail:"required",// simple rule, converted to {required:true}
    	       },
         });
    });
  </script>
<form name="addemails" id="addemails"  action="add_singlemail.php" method="post" enctype="multipart/form-data">
<table cellpadding="2" cellspacing="2" border="0">
<tr>
<td colspan="2" align="center">Send mails</td>
</tr>
<tr>
<td colspan="2" align="center"><?php print $ErrorMessage ?></td>
</tr>
<tr>
<td>From</td>
<td><input type="text" name="frommail" id="frommail"></td>
</tr>
<tr>
<td>To</td>
<td><input type="text" name="tomail" id="tomail"></td>
</tr>
<tr>
<td>Subject</td>
<td><input type="text" name="subjectmail" id="subjectmail"></td>
</tr>
<tr>
<td valign="top">Content</td>
<td>
<?php 
//pass in a name for the field
$fck = new FCKeditor('mailcontent');
//to the folder of the fckeditor
$fck->BasePath = 'fckeditor/';
//default text to show in the editor
$fck->Value = "";
$fck->Width = '620px';
$fck->Height = '400px';

//render the editor
$fck->Create();
?>
</td>
</tr>
<tr>
<td colspan="2"   align="center"><input type="submit" name="Add" id="Add" value="Send"></td>
</tr>
</table>
</form>
</td>
</tr>
<?php
include "includes/footer.php";
?>
 
 
 <?php
 }
 else
 {
 header("Location:index.php?act=3");
		exit;
 }
 
 ?>