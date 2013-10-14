<?php
/*
 * Created on 15-Dec-2009
 *
 * Created By Liju Mammen
 *
 * File Name functions.php
 */


/**
 * @param $address
 * @param $ccAddress
 * @param $from
 * @param $subject
 * @param $body
 * @return unknown_type
 */
function sendMailToAll($address, $from, $subject, $body)
{
	//	include('../include/class/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->IsSMTP();
	//$mail->SMTPAuth = true;
	$mail->Host = MAILHOST;//"logicsupport.com"; // sets logicsupport as the SMTP server
	$mail->Port = 25; // set the SMTP port
	$mail->Username =MAILUSERNAME;// "liju@logicsupport.com"; // logic username
	$mail->Password = "d3fault"; // logic password
	for ($i = 0; $i < count($address); $i++)
	{
		$mail->AddAddress($address[$i][email], $address[$i][name]);
	}
	$mail->From = $from[email];
	$mail->FromName = $from[name];
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->WordWrap = 50; // set word wrap
	$mail->IsHTML(true); // send as HTML
	if (!$mail->Send())
	{
		print "Mailer Error: " . $mail->ErrorInfo;
		print "\n\n";
		exit;
	}
	else{
		print "mail Sent Successfully";
	}
}

?>
