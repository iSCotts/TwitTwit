<?php
session_start();
$_SESSION['username']=$_POST['os0'];
	include '../classes/dbClient.php';
	include '../common/sqlFunctions.php';
$subscription = getSubscriptionDetails($_POST['os0']);


if($subscription[0]['SubsID']=0||!isset($subscription[0]['SubsID'])){
	?>

<body>


<form action="https://www.sandbox.paypal.com/cgi-bin/webscr"
	name="myform" method="post"><input type="hidden" name="cmd"
	value="_s-xclick">
	<input type="hidden" name="hosted_button_id"
	value="<?php print $_REQUEST['hosted_button_id']?>">


	 <input name="cbt"
	value="Return To twitjix.com" type="hidden"> <input name="rm" value="2"
	type="hidden">
<table>
	<tr>
		<td><input type="hidden" name="on0" value="User name"></td>
	</tr>
	<tr>
		<td><input type="hidden" name="os0" maxlength="60"
			value="<?php print $_POST['os0'] ?>"></td>
	</tr>
</table>
</form>

<script type="text/javascript">
function submitform()
{
  document.myform.submit();
}
submitform();
</script>
	<?php

}
else{

	print "<h3>Username already subscribed. use another one<h3>";

}
?>