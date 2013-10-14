<?php
include_once '../classes/paypal.class.php';
include_once '../classes/class.phpmailer.php';
$p = new paypal_class; 
include_once '../classes/dbClient.php';
include_once '../common/sqlFunctions.php';
	//send mail to user
		$mail       = new PHPMailer();
		$mail->AddReplyTo("noreply@twitjix.com","No Reply");
		$mail->SetFrom('noreply@twitjix.com', 'No Reply');
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		$mail->Subject    = "Twitacc subscription confirmation";
		$mail->IsHTML(true);
		$sql3 =  "SELECT * FROM ta_email_template WHERE status='Active' and t_id='2'";
        $gettempdetails3 = runQuery($sql3);
        if(file_exists("../mailtempl/".$gettempdetails3[0]["t_file"]))
				{
			    	//Output a line of the file until the end is reached
					$file2 = fopen("../mailtempl/".$gettempdetails3[0]["t_file"], "r") or exit("Unable to open file!");
                    //$body="Hi {$username},\n"; 
						while(!feof($file2))
					    {
					    	 $body.=fgets($file2);
					    }
						 fclose($file2);
				}
				echo  $body;
				$username="divya";
	  $body=str_replace('{username}',	$username,$body);	
	  $mail->AddAddress("divya@logicsupport.com", $username);
	  $mail->MsgHTML($body);
	  if(!$mail->Send()) 
		{
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else 
		{
		  echo "Message sent! <br/>";
		}
