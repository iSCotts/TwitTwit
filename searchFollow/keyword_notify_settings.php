<?php
include_once('../classes/dbClient.php');
include_once('../common/sqlFunctions.php');
$name 				= $_REQUEST['name'];
$act 				= $_REQUEST['act'];
$id 				= $_REQUEST['id'];
$notify_status 		= $_REQUEST['notify_status'];
$notify_frequency 	= $_REQUEST['notify_frequency'];
$new_email 			= $_REQUEST['new_email'];
if($act == '1')
{
	$query ="UPDATE `ta_keyword_users` SET `notify_frequency` = '$notify_frequency', `notify_status` = '$notify_status' WHERE `id` ='$id'";
	executeQuery($query);
}
else if($act == '2')
{
	$query ="UPDATE `ta_keyword_users` SET `notify_frequency` = '$notify_frequency' WHERE `id` ='$id'";
	executeQuery($query);
}
else if($act == '3')
{
	$query ="UPDATE `ta_users` SET `Email` = '$new_email' WHERE `UserName` ='$name'";
	executeQuery($query);
}
$user_email 		= dkGetUserEmail($name);
if(empty($user_email))
{
	echo '|brk|get_email|brk|';
}
else
{
	echo '|brk|ok|brk|';
}
?>