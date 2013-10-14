<?php
session_start();
$user_name=$_SESSION["username"] ;
$user_email='';
$pack=$_REQUEST['pack'];
$upgrade="upgrade";
$affiliateid=$_SESSION["affiliateid"];
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
$packages=getPackagedetails($_REQUEST['pack']);
$price=$_REQUEST['price'];
$sql = "select * from ta_user_subscriptions where UserName='$user_name'";
$sqlq=  runQuery($sql);
if(count($sqlq)>0)
{
	$user_name=$sqlq[0]['UserName'];
	$user_email=$sqlq[0]['Email'];
}
?>
<head>
<link href="../css/basic.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
   	if($packages[0]['monPrice']!=""){
	echo "<br><h3 style='color:#fff'>{$packages[0]['packageName']} : {$price}</h3>";
	echo "<span style='color:#fff'>{$packages[0]['packageDesc']}</span>";
    }
	else{
	echo "<br><h3 style='color:#fff'>4 Day Free Trial</h3>";
  }
?>
<br />

   <br />
<?php $buttonid =$_REQUEST['buttonid'];?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paypaltest">
<input type="hidden" name="cmd" value="_s-xclick">
 <input type="hidden" name="hosted_button_id" value="<?php print $buttonid; ?>">  
<input type="hidden" name="pack" value="<?php print $_REQUEST["pack"]; ?>" />
<input name="cbt"
	value="Return To twitjix.com" type="hidden">
<div class="face_formdiv01">
	<div class="face_titlepackage"><input type="hidden" name="on0"  value="Twitter Username">Twitter Username</div>
	<div class="face_txtbx"><input type="text" name="os0" class="txtbx_face" readonly="" value=<?php echo $user_name;?>></div>
		<div class="clear"></div>
</div>
<div id="userlbl" class="emailerror"></div>

<div class="face_formdiv01">
	<div class="face_titlepackage"><input type="hidden" name="on1" value="Email">Email</div>
	<div class="face_txtbx"><input type="text" name="os1" class="txtbx_face" <?php if($user_email!=""){ echo "readonly";}?> value=<?php echo $user_email;?>>
	<input type="hidden" name="custom" value=<?php echo "$user_name/brk/$user_email/brk/$pack/brk/$affiliateid/brk/$upgrade"; ?>/>
	<br/>
	<br/>
	</div>
	<div class="clear"></div>
</div>

<div id="emaillbl" class="emailerror"></div>

 

<div class="face_packagediv01">
	 <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit"  alt="PayPal - The safer, easier way to pay online!" > 
	
  <!-- <img src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif"   onclick="validate(document.paypaltest)">-->  

<!--<img src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" />-->
	 
	
</div>
<div class="face_packagediv03">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</div>
</form>

