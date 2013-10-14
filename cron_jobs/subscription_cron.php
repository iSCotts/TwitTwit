<?php
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';

$current_date=date("Y-m-d");
$selectsql	= "SELECT * FROM ( SELECT sd.`sd_id`,sd.`subs_id`,sd.`txn_type`, sd.`payment_status`, sd.`date_record`, sd.`payment_starts`, sd.`mc_fee`, sd.`mc_gross` "
		. " ,us.`UserName` ,us.`next_payment_date` "
		. " FROM `ta_subscription_details` sd "
		. " LEFT JOIN `ta_user_subscriptions` us ON sd.`subs_id` = us.`SubsID` "
  		. " WHERE us.`UserName` !=''  and  sd.`txn_type`='subscr_cancel'"
		. " ORDER BY sd.`sd_id` DESC) AS xyz GROUP BY subs_id";
$result=runQuery($selectsql);
for($i=0;$i<count($result);$i++)
{
    if($result[$i]['next_payment_date']<=$current_date)
	{
		$sqlforupdate ="UPDATE `ta_user_subscriptions` SET `status`='B' WHERE  `SubsID` ='".$result[$i]['subs_id']."'" ;
		runQuery($sqlforupdate);
	}
}

