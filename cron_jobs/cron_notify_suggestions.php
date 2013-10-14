<?php
/*

* This cron file send email notification of keyword suggetions based on user selected fequency.

*/

include_once '../classes/dbClient.php';

include_once '../common/sqlFunctions.php';

include_once '../common/commonfunctions.php';

include_once '../classes/class.phpmailer.php';

$query 		= " SELECT a.`keyId`,b.`Email`,b.`UserName` FROM `ta_keyword_users` a LEFT JOIN `ta_users` b ON a. `UserId` = b.`UserID` WHERE b.`Email` !='' AND a.`notify_status` ='yes' $fequency ORDER BY  a.id DESC ";
$notifyR 	= runQuery($query);


$s_limit2 = dkGetCommonSettings('keyword-suggestions-notify-limit'); 

for($i=0;$i<count($notifyR);$i++)

{

	$user_name = $notifyR[$i]['UserName'];

	$key_id	   = $notifyR[$i]['keyId'];

	$keyword   = dkGetKeyword($key_id);


	$limit2 = dkGetSuggestionsUserListCount($user_name,$key_id); 

	if(intval($limit2) )

	{

		if($limit2<$s_limit2) $limit2 = " LIMIT 0,$limit2 ";

		else 

		{

			

			$limit2 = " LIMIT 0,$s_limit2 ";

		}

	}

	else

	{

		$limit2 = " LIMIT 0,0 ";

	}

	

$query = "SELECT * FROM `ta_keyword_message` "

	   . " WHERE `keyId` = '$key_id' "

	   . " AND `from_user` NOT IN (SELECT `blocked` FROM `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ) "

	   . " AND `from_user` NOT IN (SELECT `follow_user_name` FROM `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ) "

	   . " AND `from_user` NOT IN (SELECT `followed_user_name` FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' )"

	   . " GROUP BY from_user ORDER BY `id` DESC $limit2";

//-------------------- new query---------------------	   
$fromUser = array();
$in		  = '';
$query = "SELECT DISTINCT `blocked` FROM `ta_follow_blocked_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id' ";
$temp  = runQuery($query);
for($p=0;$p<count($temp);$p++)
{
	if(empty($in))
	{
		$in.= "'".$temp[$p]['blocked']."'";
	}
	else
	{
		$in.= ", '".$temp[$p]['blocked']."'";
	}
	$fromUser[] = $temp[$p]['blocked'];
}
unset($temp);
$query = "SELECT DISTINCT `follow_user_name` FROM `ta_follow_queued_user_list` WHERE `user_name` = '$user_name' AND `key_id` = '$key_id'";
$temp  = runQuery($query);
for($q=0;$q<count($temp);$q++)
{
	if(!in_array($temp[$q]['follow_user_name'],$fromUser))
	{
		if(empty($in))
		{
			$in.= "'".$temp[$q]['follow_user_name']."'";
		}
		else
		{
			$in.= ", '".$temp[$q]['follow_user_name']."'";
		}
		$fromUser[] = $temp[$q]['follow_user_name'];
	}
}
unset($temp);
$query = "SELECT DISTINCT `followed_user_name` FROM `ta_user_followed_keyword_users` WHERE `user_name` = '$user_name' ";
$temp  = runQuery($query);
for($r=0;$r<count($temp);$r++)
{
	if(!in_array($temp[$r]['followed_user_name'],$fromUser))
	{
		if(empty($in))
		{
			$in.= "'".$temp[$r]['followed_user_name']."'";
		}
		else
		{
			$in.= ", '".$temp[$r]['followed_user_name']."'";
		}
		$fromUser[] = $temp[$r]['followed_user_name'];
	}
}
unset($temp);
unset($fromUser);

if(empty($in))
{
$query = "SELECT * FROM `ta_keyword_message` WHERE `keyId` = '$key_id' $limit2";
}
else
{
$query = "SELECT * FROM `ta_keyword_message` WHERE `keyId` = '$key_id'  AND `from_user` NOT IN ($in) $limit2";
}
//-------------------- new query---------------------	   
	$notificationR 	= runQuery($query);

	$body	= '

<table cellpadding="0" cellspacing="0" style="width:600px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#193842;">

	<tr>

		<td colspan="3" style="padding:10px;">Hi, <strong>'.$user_name.'</strong></td>

	</tr>

	<tr>

		<td colspan="3" style="padding:10px; font-size:15px; font-weight:bold;">Keyword : '.$keyword.'</td>

	</tr>

	<tr style=" background-color:#9EB4BB; font-weight:bold;">

		<td colspan="2" style=" padding:10px 0 10px 10px;">User</td>

		<td style=" padding:10px 0 10px 10px;">Reason</td>

	</tr>

	';

	for($k=0;$k<count($notificationR);$k++)

	{

		$body.= '

	<tr style="border-bottom:1px solid #CCCCCC;">

		<td style="width:48px; border-bottom:1px solid #CCCCCC; padding:5px;">			<a href="https://twitter.com/'.$notificationR[$k]['from_user'].'" target="_blank">

				<img src="'.urldecode($notificationR[$k]['profile_image_url']).'" height="50" width="50"  border="0" />

			</a>

</td>

		<td style="width:120px; border-bottom:1px solid #CCCCCC; padding-left:10px; font-size:11px;">			<a href="https://twitter.com/'.$notificationR[$k]['from_user'].'" target="_blank" style="color:#193842;">

				'.$notificationR[$k]['from_user'].'

			</a>

</td>

		<td style="padding-left:10px; border-bottom:1px solid #CCCCCC; padding-right:10px; font-size:10px;">'.$notificationR[$k]['text'].'</td>

	</tr>

				';

	}

	$body.= '</table>';

	if(count($notificationR)>0)

	{
		$mail       = new PHPMailer();
		$mail->Subject    = "$keyword - suggestions";
		$mail->AddReplyTo("noreply@twitjix.com","No Reply");
		$mail->SetFrom('noreply@twitjix.com', 'No Reply');
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		$mail->AddAddress($notifyR[$i]['Email'], $notifyR[$i]['UserName']);
		$mail->MsgHTML($body);

		if(!$mail->Send()) 

		{

		  echo "Mailer Error: " . $mail->ErrorInfo;

		} else 

		{

		  echo "Message sent! <br/>";

		}

	}

}
?>

