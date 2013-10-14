<?php
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
$last_date=date("Y-m-d", mktime(0, 0, 0, date('m')+16, date('d'), date('Y')));
//$last_date="2010-04-23";
$current_date=date("Y-m-d");
$selectsql="SELECT `SubsID`,`next_payment_date` FROM `ta_user_subscriptions` WHERE DATE_FORMAT( `next_payment_date` , '%m' )='".date('m')."' and (`next_payment_date`>='$current_date' and `next_payment_date`<='DATE_ADD(`next_payment_date`,INTERVAL 16 DAY)')";
$result=runQuery($selectsql);
for($i=0;$i<count($result);$i++)
{
	$sql2="SELECT count(*) as cnt FROM `ta_subscription_details` WHERE `subs_id`='".$result[$i]['SubsID']."' and DATE_FORMAT( `date_record` , '%m' )='".date('m')."' and `payment_status`='Completed'";
	$result2=runQuery($sql2);
	$next_date=date("Y-m-d", mktime(0, 0, 0, date('m',strtotime($result[$i]['next_payment_date']))+1, date('d'), date('Y')));
	    	$sqlforselect ="SELECT UserName  FROM `ta_user_subscriptions`  WHERE  `SubsID` ='".$result[$i]['SubsID']."'" ;
			$res=runQuery($sqlforselect);
			$username=$res[0]['UserName'];
			$email=$res[0]['Email'];
	if(($result2[0]['cnt']==0) && ($last_date==$result[$i]['next_payment_date']))
		{
	$sqlforinsert ="INSERT INTO `ta_subscription_banned_details` (`sbd_id` ,`subs_id` ,`pending_date`) VALUES ('0', '".$result[$i]['SubsID']."', '".$result[$i]['next_payment_date']."')";
	runQuery($sqlforinsert);
	$sqlforupdate2 ="UPDATE `ta_user_subscriptions` SET `status`='B',`next_payment_date` = '$next_date' WHERE  `SubsID` ='".$result[$i]['SubsID']."'" ;
	runQuery($sqlforupdate2);
	//sending mail to banned users
		
			$from="admin@twitjix.com";
			$to=$username;
			$mailto=$email;
			$replyto="admin@twitjix.com";
			$mailsubject="Twitacc subscription banned";
			$mcontent="Dear {$to},\n"; 
		    $mcontent.="Your subscription has been banned.";		
		    $mcontent.="For activating your subscription,please make the payment for this month "."\r\n";
		    	$headers = 'From:'.$from."\r\n" .
		    'Reply-To: admin@twitjix.com'."\r\n" .
			 'X-Mailer: PHP/'.phpversion();
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($mailto, $mailsubject, $mcontent, $headers);
	}
	else{
		$sqlforupdate2 ="UPDATE `ta_user_subscriptions` SET `status`='Y',`next_payment_date` = '$next_date' WHERE  `SubsID` ='".$result[$i]['SubsID']."'" ;
		runQuery($sqlforupdate2);
		//sending mail to banned users after activated the subscription
		    $from="admin@twitjix.com";
			$to=$username;
			$mailto=$email;
			$replyto="admin@twitjix.com";
			$mailsubject="Activated Your Twitacc subscription";
			$mcontent="Dear {$to},\n"; 
		    $mcontent.="Thank you for the payment,Your Twitacc subscription has been activated .";		
		       	$headers = 'From:'.$from."\r\n" .
		    'Reply-To: admin@twitjix.com'."\r\n" .
			 'X-Mailer: PHP/'.phpversion();
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($mailto, $mailsubject, $mcontent, $headers);
	}
}