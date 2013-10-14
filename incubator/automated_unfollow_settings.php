<?php 
session_start();
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
		<input type="checkbox" value="Y" name="automated_unfollow"  id="automated_unfollow"  onclick="automated_unfollow_setings()"/> 
		Enable automated unfollow with a wait span of 
		<select id="automated_unfollow_wait_span" name="automated_unfollow_wait_span" onchange="automated_unfollow_setings()">
		<option value="3">3</option>
		<option value="5">5</option>
		<option value="7">7</option>
		<option value="14">14</option>
		<option value="30">30</option>
		</select>
		days.
<?php
	}
	else
	{
?>
		<input type="checkbox" <?php if($temp[0]['status'] == 'Y') {?> checked="checked" <?php }?> value="Y" name="automated_unfollow"  id="automated_unfollow"  onclick="automated_unfollow_setings()"/> 
		Enable automated unfollow with a wait span of 
		<select id="automated_unfollow_wait_span" name="automated_unfollow_wait_span" onchange="automated_unfollow_setings()">
		<option value="3"  <?php if($temp[0]['wait_span'] == '3') {?> selected="selected" <?php }?> >3</option>
		<option value="5"  <?php if($temp[0]['wait_span'] == '5') {?> selected="selected" <?php }?> >5</option>
		<option value="7"  <?php if($temp[0]['wait_span'] == '7') {?> selected="selected" <?php }?> >7</option>
		<option value="14" <?php if($temp[0]['wait_span'] == '14') {?> selected="selected" <?php }?> >14</option>
		<option value="30" <?php if($temp[0]['wait_span'] == '30') {?> selected="selected" <?php }?> >30</option>
		</select>
		days.
<?php
	}
}
?>