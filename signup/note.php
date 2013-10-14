<?php
include_once '../classes/paypal.class.php';
include_once '../classes/class.phpmailer.php';
$p = new paypal_class; 
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; 
//validate the paypal ipn
if(!$p->validate_ipn())
{
	?>
	<html><head>
	<title>404 Not Found</title>
	</head><body>
	<h1>Not Found</h1>
	<p>The requested URL /signup/note_new.php was not found on this server.</p>
	<p>Additionally, a 404 Not Found
	error was encountered while trying to use an ErrorDocument to handle the request.</p>
	<hr>
	<address>Apache/2.2.13 (Unix) mod_ssl/2.2.13 OpenSSL/0.9.8e-fips-rhel5 mod_auth_passthrough/2.1 mod_bwlimited/1.4 FrontPage/5.0.2.2635 Server at www.twitjix.com Port 80</address>
	</body></html>
	<?php
}
else
{ 
    //if the verification is success
	include_once '../mail/sendMail.php';
	include_once '../classes/dbClient.php';
	include_once '../common/sqlFunctions.php';
	$phpdate		    		= date("Y-m-d");
	$time 			    		= date("H:i:s");
	$phpnewdate     		= date('Y-m-d H:i:s');
	$txn_type        		    = $_POST['txn_type'];
	$txn_id             			= $_POST['txn_id'];
	$parent_txn_id   		= $_POST['parent_txn_id'];
	$payment_status			= $_POST['payment_status'];
	$reason_code				= $_POST['reason_code'];
	$pending_reason			= $_POST['pending_reason'];
	$receiver_email			= $_POST['receiver_email'];
	$payer_email				= $_POST['payer_email'];
	$subscr_id          		= $_POST['subscr_id'];
	$option_selection1 		= $_POST['option_selection1'];
	$option_selection2  	= $_POST['option_selection2'];
	$customTemp				= explode('/brk/',$_POST['custom']);
	$item_name        	    = $_POST['item_name'];
	$subscr_date				= $_POST['subscr_date'];
	$payer_business_name= $_POST['payer_business_name'];
	$payment_date			= $_POST['payment_date'];
	$payer_id					= $_POST['payer_id'];
	$period1 					= $_POST['period1'];
	$period3 					= $_POST['period3'];
	$amount3 					= $_POST['amount3'];
	$resend						= $_POST['resend'];
	$mc_currency				= $_POST['mc_currency'];
	$mc_fee					= $_POST['mc_fee'];
	$mc_gross					= $_POST['mc_gross'];
	// in case of free trial fetch the number of trial days and calculate the next payment date
	if(isset($period1)&&	($txn_type == 'subscr_signup'))
	{
		//$subscr_date	="12:52:57 Sep 23, 2010 PDT";
		$subscr_date	=strtotime($subscr_date);
		$trialperiod     	=explode(" ",$period1);
		if($trialperiod [1]=="M")
		{
				$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$subscr_date)+$trialperiod[0], date('d',$subscr_date), date('Y',$subscr_date)));
		}
		if($trialperiod [1]=="Y")
		{
		 		$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$subscr_date), date('d',$subscr_date), date('Y',$subscr_date)+$trialperiod[0]));
		 }
	    if($trialperiod [1]=="D")
		{
				$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$subscr_date), date('d',$subscr_date)+$trialperiod[0], date('Y',$subscr_date)));
		}
		$payment_starts	=$next_date;
		$payment_status	 = "Free Trial";
	}
	//verify the paypal receiver  email id
	if($receiver_email	=="payments@twitjix.com") 
	{
		if(isset($_POST['custom'])) //check the custom variable exists or not
		{
	  		//check whether there is already a subscription in the same twitter name
			$query			= "SELECT *  FROM `ta_user_subscriptions` WHERE `UserName` = '$customTemp[0]' order by SubsID desc";
			$subsc_result 	= runQuery($query);
			$old_subscr_id=$subsc_result[0]['subscr_id'];
			$username	=$subsc_result[0]['UserName'];
			$status	    =$subsc_result[0]['status'];
			$email	    =$subsc_result[0]['Email'];
    		$packageid	=$subsc_result[0]['PackageID'];
	        $affiliateid	=$subsc_result[0]['affiliateid'];
			
			$SubsID=$subsc_result[0]['SubsID'];
			// if a new subscription is created  using paypal button, create a new subscription  in twitacc
			if($txn_type == 'subscr_signup')
			{
				if(isset($period3))
				{
					//$subscr_date	="12:52:57 Sep 23, 2010 PDT";
					$subscr_date	=strtotime($subscr_date);
					$trialperiod     	=explode(" ",$period3);
					if($trialperiod [1]=="M")
					{
							$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$subscr_date)+$trialperiod[0], date('d',$subscr_date), date('Y',$subscr_date)));
					}
					if($trialperiod [1]=="Y")
					{
							$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$subscr_date), date('d',$subscr_date), date('Y',$subscr_date)+$trialperiod[0]));
					 }
					if($trialperiod [1]=="D")
					{
							$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$subscr_date), date('d',$subscr_date)+$trialperiod[0], date('Y',$subscr_date)));
					}
				}
			  	// if there is no  subscription exists, then insert a new record into the 'ta_user_subscriptions' table
			    if (!isset($old_subscr_id))
				{
					$query = "INSERT INTO `ta_user_subscriptions` (`UserName` ,`Email` ,`PackageID` ,`subscr_id`,`amount3`,`period1`,`period3`,`DT`, `affiliateid` , `item_name`,`subscr_date`,`payer_business_name`,`status`,`next_payment_date`)	VALUES ('$customTemp[0]','$option_selection2', '$customTemp[2]', '$subscr_id','$amount3','$period1','$period3','$phpnewdate','$customTemp[3]','$item_name','$subscr_date','$payer_business_name','Y', '$next_date')";
					$SubsID = insertQuery($query);
				}
				else //if there exists a subscription in the same twitter name				  
				{   //if resend the subscription signup,update the new data with the existing subscription id  
					if($resend==true)
						{
						$query = "UPDATE `ta_user_subscriptions` SET `UserName`='$customTemp[0]' ,`Email`='$option_selection2' ,`PackageID`='$customTemp[2]' ,`amount3`='$amount3',`period1`='$period1',`period3`='$period3',`DT`='$phpnewdate', `affiliateid`='$customTemp[3]' , `item_name`='$item_name',`subscr_date`='$subscr_date',`payer_business_name`='$payer_business_name',`status`='Y',`next_payment_date`= '$next_date'	WHERE `subscr_id`='$old_subscr_id'";
						runQuery($query);
						//$SubsID=$old_subscr_id;
					    }
					//in the case of upgrading the subscription,update the status of the old subscription inactive (status='N')
					else if($customTemp[4]!="")	
					{
						if($old_subscr_id!=$subscr_id)
						{
							$query = "INSERT INTO `ta_user_subscriptions` (`UserName` ,`Email` ,`PackageID` ,`subscr_id`,`amount3`,`period1`,`period3`,`DT`, `affiliateid` , `item_name`,`subscr_date`,`payer_business_name`,`status`,`next_payment_date`)	VALUES ('$customTemp[0]', '$option_selection2', '$customTemp[2]', '$subscr_id','$amount3','$period1','$period3','$phpnewdate','$customTemp[3]','$item_name','$subscr_date','$payer_business_name','Y', '$next_date')";
							$SubsID = insertQuery($query);
						}
					 	$insquery = "INSERT INTO `ta_subscription_history` (`username` ,`Email` ,`PackageID` ,`subscr_id`,	`affiliateid` ,`cancelled_date`,`next_payment_date`)	VALUES ('$username', '$email', '$packageid', '$old_subscr_id', '$affiliateid', '$phpdate', '$next_date')";
						executeQuery($insquery);
						$deletequery = "DELETE  FROM `ta_subscription_details` WHERE `subs_id`='".$subsc_result[0]['SubsID']."' "; 
						$deleteresult  = runQuery($deletequery);	
						$deletequery = "DELETE  FROM `ta_user_subscriptions` WHERE `subscr_id`='$old_subscr_id' "; 
						$deleteresult  = runQuery($deletequery);	
						
						//check whether the campaign limit is over than the current subscription
						$packgquery="SELECT u.`UserID`, u.`RefID`, u.`UserName`,p.`packageID`,p.`campaignLimit`,p.`keywordLimit`,p.`rssFeeds`,p.`twitterAcc`,p.`autoTweet`,p.`followLimit`  FROM `ta_user_subscriptions`us LEFT JOIN `ta_packages` p ON us.`packageID`=p.`packageID` LEFT JOIN  `ta_users` u ON us.`UserName`=u.`UserName` WHERE  us.`UserName` ='$customTemp[0]' and status='Y'";
						$packgresult 	  = runQuery($packgquery);
						$campaignLimit =$packgresult[0]['campaignLimit'];
						$keywordLimit  =$packgresult[0]['keywordLimit'];
						$rssFeeds         =$packgresult[0]['rssFeeds'];
						$twitterAcc      =$packgresult[0]['twitterAcc'];
						$autoTweet     =$packgresult[0]['autoTweet'];
						$followLimit      =$packgresult[0]['followLimit'];
						$UserID     		  =$packgresult[0]['UserID'];
						$RefID     		  =$packgresult[0]['RefID'];
						$campquery	  = "SELECT CampaignID FROM `ta_campaigns` WHERE `RefID` = '$RefID' ";
						$campresult 	  = runQuery($campquery);
						$totfeed=0;
						for($i=0;$i<count($campresult);$i++)
						{
							$campid=$campresult[$i]['CampaignID'];
							$feedquery		= "SELECT count(*) as cnt FROM `ta_feeds` WHERE `CampaignID` = '$campid' ";
							$feedresult 	= runQuery($feedquery);
							$totfeed=	$totfeed+$feedresult[0]['cnt']; 
						} 
						$res2="";
						if(($campresult[0]['cnt'])>$campaignLimit)
						{
						  $res2="Please make sure that your campaign limit is not over than your allowed limit in the package,Otherwise system will automatically delete your campaigns.";
						}
						$keyquery		= "SELECT count(*) as cnt FROM `ta_keyword_users` WHERE `UserID` = '$UserID' ";
						$keyresult 	= runQuery($keyquery);
						if(($keyresult[0]['cnt'])>$keywordLimit*$campaignLimit)
						{
						 $res2= "Please make sure that your Keyword limit is not over than your allowed limit in the package,Otherwise system will automatically delete your Keywords.";
						}
						if($totfeed>rssFeeds)
						{
						 $res2="Please make sure that your Feeds limit is not over than your allowed limit in the package,Otherwise system will automatically delete your Feeds.";
						}
						$query = " SELECT COUNT(*) AS cnt FROM  `ta_users` WHERE `RefID` = '$UserID' ";
						$temp  = runQuery($query);
						$addOnUser 	= $temp[0]['cnt'];		
						if($addOnUser>$twitterAcc)
						{
							  $res2="Please make sure that your Twitter Account limit is not over than your allowed limit in the package,Otherwise system will automatically delete your Accounts.";
						} 
								$mail       = new PHPMailer();
								$mail->AddReplyTo("noreply@twitjix.com","No Reply");
								$mail->SetFrom('noreply@twitjix.com', 'No Reply');
								$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
								$mail->Subject    = "Thank you for upgrading your Twitacc subscription";
								$body	= '<table cellpadding="0" cellspacing="0" >
								<tr><td style="padding:10px;">Hi, <strong>'.$username.'</strong></td></tr>
								<tr><td>Thank you for upgrading your subscription.</td></tr>
								<tr><td>'.$res2.'</td></tr>
								<tr><td>You can sign in to the site with the following URL .</td></tr>
								<tr><td>http://www.twitjix.com/index</td></tr>
								<tr><td>Please provide your twitter username and password for login</td></tr>
								<tr><td>Please cancel your old subscription manually from paypal otherwise you will be charged for both.</td></tr>
								<tr><td>Regards, </td></tr>
								<tr><td>Team Twitacc </td></tr>
								</table>';
								$mail->AddAddress($email, $username);
								$mail->MsgHTML($body);
								if(!$mail->Send()) 
								{
									echo "Mailer Error: " . $mail->ErrorInfo;
								}
								else 
								{
									 echo "Message sent! <br/>";
								}
																 	
					}	//upgrade  package ends here	
				else{
						$query = "UPDATE `ta_user_subscriptions` SET `UserName`='$customTemp[0]' ,`Email`='$option_selection2' ,`PackageID`='$customTemp[2]' ,`amount3`='$amount3',`period1`='$period1',`period3`='$period3',`DT`='$phpnewdate', `affiliateid`='$customTemp[3]' , `item_name`='$item_name',`subscr_date`='$subscr_date',`payer_business_name`='$payer_business_name',`status`='Y',`next_payment_date`= '$next_date'	WHERE `subscr_id`='$old_subscr_id'";
						runQuery($query);
					//	$SubsID=$old_subscr_id;
					}
				}
			}
			//if the subscription is cancelled, update the cancel status is 'Y'
			if(($txn_type == 'subscr_cancel') && ($subscr_id!=""))
			{
			   $updtequery = "UPDATE `ta_user_subscriptions` SET  `cancel`='Y' WHERE  `subscr_id` ='$subscr_id' " ;
			    runQuery($updtequery);
				$payment_status	 = "subscr_cancel";
			}
			//if the subscription is failed, update the cancel status is 'N'
		/*	if($txn_type == 'subscr_failed')
			{
			   $updtequery = "UPDATE `ta_user_subscriptions` SET  `status`='N' WHERE  `subscr_id` ='$subscr_id' " ;
			    runQuery($updtequery);
			}*/
			   if(isset($_POST['payment_status']))
			   {
				   //if the payment is received,	
					if($_POST['payment_status']=="Completed") 
				   {
				   // select the  SubsID from the ta_user_subscriptions
				   	$subscr_id          = $_POST['subscr_id'];
					$query				= "SELECT `SubsID`, `Email`, `period3`  FROM `ta_user_subscriptions` WHERE `subscr_id` = '$subscr_id' ";
					$userTemp 		= runQuery($query);
					$username			= $customTemp[0];
					$email				= $customTemp[1];
					$SubsID				= $userTemp[0]['SubsID'];
					$period3 			= $userTemp[0]['period3'];
					$payment_date1	=strtotime($payment_date);
					$payment_starts = date("Y-m-d",$payment_date1);
					$nperiod     =explode(" ",$period3);
					if($nperiod [1]=="M")
					$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$payment_date1)+$nperiod[0], date('d',$payment_date1), date('Y',$payment_date1)));
					if($nperiod [1]=="Y")
					$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$payment_date1), date('d',$payment_date1), date('Y',$payment_date1)+$nperiod[0]));
					if($nperiod [1]=="D")
					$next_date    =date("Y-m-d", mktime(0, 0, 0, date('m',$payment_date1), date('d',$payment_date1)+$nperiod[0], date('Y',$payment_date1)));
					//if there is no subscription  is created then create a new subscription
					if(empty($SubsID))
					{
					$query = "INSERT INTO `ta_user_subscriptions` (`UserName` ,`Email` ,`PackageID` ,`subscr_id`,`amount3`,`period1`,`period3`,`DT`, `affiliateid` , `item_name`,`subscr_date`,`payer_business_name`,`status`,`next_payment_date`)	VALUES ('$customTemp[0]', '$option_selection2', '$customTemp[2]', '$subscr_id','$amount3','$period1','$period3','$phpnewdate','$customTemp[3]','$item_name','$subscr_date','$payer_business_name','Y', '$next_date')";
						$SubsID = insertQuery($query);
					}
					else
					{
					//update the next payment date and status of the current user
					
					$query = "UPDATE `ta_user_subscriptions` SET `next_payment_date` = '$next_date',`status`='Y',`cancel`='N' WHERE  `subscr_id` ='$subscr_id' " ;
					//$query = "UPDATE `ta_user_subscriptions` SET `status`='Y' WHERE  `subscr_id` ='$subscr_id' " ;
					runQuery($query);
					}
					//send mail to the user regarding  Twitacc subscription confirmation
					$mail       = new PHPMailer();
					$mail->AddReplyTo("noreply@twitjix.com","No Reply");
					$mail->SetFrom('noreply@twitjix.com', 'No Reply');
					$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
					$mail->Subject    = "Twitacc subscription confirmation";
					$sql3 =  "SELECT * FROM ta_email_template WHERE status='Active' and t_id='2'";
					$gettempdetails3 = runQuery($sql3);
					if(count($gettempdetails3)>0)
					{
					//fetch the template from the db,his cab be editable by admin
							if(file_exists("../mailtempl/".$gettempdetails3[0]["t_file"]))
							{
								//Output a line of the file until the end is reached
								$file2 = fopen("../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
								while(!feof($file2))
								{
									 $body.=fgets($file2);
								}
								fclose($file2);
								$body=str_replace('{username}',	$username,$body);	
								$mail->AddAddress($email, $username);
								$mail->MsgHTML($body);
								if(!$mail->Send()) 
								{
								  echo "Mailer Error: " . $mail->ErrorInfo;
								}
								else 
								{
								  echo "Message sent! <br/>";
								}
							}
					}
			  //sending mail process ends here
			}
			else //in the case of payment_status is pending,failed etc, then update the next payment date and  status 
			{
				// $query = "UPDATE `ta_user_subscriptions` SET `next_payment_date` = '$next_date',`status`='B' WHERE  `UserName` ='$customTemp[0]' " ;
				 $query = "UPDATE `ta_user_subscriptions` SET `status`='B' WHERE  `UserName` ='$customTemp[0]' " ;
				 runQuery($query);
			}
		}
		//insert all  payment details to the ta_subscription_details table.
		$query ="INSERT INTO `ta_subscription_details` (`sd_id` ,`subs_id` ,`payment_status` ,`payment_date` ,	`mc_currency` ,	`mc_fee` ,
					`mc_gross` ,`payer_id`,`txn_id`,	`parent_txn_id`,`txn_type`,`reason_code`,`pending_reason`,`payment_starts`,`date_record`)	VALUES ('0', '$SubsID', '$payment_status', '$payment_date', '$mc_currency', '$mc_fee', '$mc_gross','$payer_id','$txn_id','$parent_txn_id','$txn_type','$reason_code','$pending_reason','$payment_starts','$phpdate')";
		executeQuery($query);	
    }
  }
}
		
