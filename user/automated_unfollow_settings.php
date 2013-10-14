<?php 
ob_start();
session_start();
?>
<script type="text/javascript" language="javascript" src="http://www.twitjix.com/js/jquery.js">
</script>
<script type="text/javascript" language="javascript" >
/*$(document).ready(function() {
	$.ajax({
	   type: "POST",
	   url: "automated_unfollow_settings.php",
	   data: "user_id=1",
	   success: function(msg){
		 $('#automated_unfollow_main').html(msg);
	   }
	 });  
});
*/
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
<div  style="margin-top:70px;">
<h3 style="color:#000000;font-weight:bold;font-size:14px; font-family:Arial, Helvetica, sans-serif;">Automated unfollow tool</h3>
<?php
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
$username = $_SESSION['username'];
$sql= "SELECT `UserID` FROM `ta_users` WHERE `UserName` = '$username'";
$temp  = runQuery($sql);
if(count($temp)>0)
{
	$user_id = $temp[0]['UserID'];
	$sql= "SELECT * FROM `ta_automated_unfollow_settings` WHERE user_id = '$user_id'";
	$temp  = runQuery($sql);
	if(count($temp)==0)
	{
?>
		<p><input type="checkbox" value="Y" name="automated_unfollow"  id="automated_unfollow"  onclick="automated_unfollow_setings()"/> 
		Enable Automated Unfollow</p>
		<p>Unfollow all users who have not followed me back within  
		<select id="automated_unfollow_wait_span" name="automated_unfollow_wait_span" onchange="automated_unfollow_setings()">
		<option value="3">3</option>
		<option value="5">5</option>
		<option value="7">7</option>
		<option value="14">14</option>
		<option value="30">30</option>
		</select>
		days.</p>
		<p style="font-style:italic;">* Please note that this unfollow will happen gradually and not all at once.</p>
		<?php
	}
	else
	{
?>
		<p><input type="checkbox" <?php if($temp[0]['status'] == 'Y') {?> checked="checked" <?php }?> value="Y" name="automated_unfollow"  id="automated_unfollow"  onclick="automated_unfollow_setings()"/> 
		Enable Automated Unfollow</p>
		<p>Unfollow all users who have not followed me back within 
		<select id="automated_unfollow_wait_span" name="automated_unfollow_wait_span" onchange="automated_unfollow_setings()">
		<option value="3"  <?php if($temp[0]['wait_span'] == '3') {?> selected="selected" <?php }?> >3</option>
		<option value="5"  <?php if($temp[0]['wait_span'] == '5') {?> selected="selected" <?php }?> >5</option>
		<option value="7"  <?php if($temp[0]['wait_span'] == '7') {?> selected="selected" <?php }?> >7</option>
		<option value="14" <?php if($temp[0]['wait_span'] == '14') {?> selected="selected" <?php }?> >14</option>
		<option value="30" <?php if($temp[0]['wait_span'] == '30') {?> selected="selected" <?php }?> >30</option>
		</select>
		days.</p>
		<p style="padding:5px 0px 0px 0px;font-style:italic;">* Please note that this unfollow will happen gradually and not all at once.</p>
<?php
	}
}
?>
</div>