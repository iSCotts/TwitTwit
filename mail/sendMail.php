<?php
function sendmail($toname,$fromaddress,$page,$to,$subject,$uname,$pwd)
{
switch ($page) {
   case "signup" :
   $template ="<table><tr><td>Dear {$toname}, </td><tr><td>Thank you for your subscription.</td></tr>";
   $template.="<tr><td>You can signing in to the site with the following URL</td></tr>";
   $template.="<tr><td>www.twitjix.com/index.php</td></tr>";
   $template.="<tr><td>Your login details</td></tr>";
   $template.="<tr><td>Please provide your twitter username and pasword for login.</td></tr>";
   $templateplain="Dear {$toname},"."\r\n"." Thank you for your subscription."."\r\n";
   $templateplain.="You can sign in to the site with the following URL "."\r\n";
   $templateplain.="www.twitjix.com/index.php "."\r\n";
   $templateplain.="Please provide your twitter username and pasword for login."."\r\n";
   break;
  case "admin" :
   $template ="<table><tr><td>Dear {$toname}, </td><tr><td>Thank you for your subscription.</td></tr>";
   $template.="<tr><td>You can signing in to the site with the folowing URL</td></tr>";
   $template.="<tr><td>www.twitjix.com/index.php</td></tr>";
   $template.="<tr><td>Please provide your twitter username and pasword for login.</td></tr>";
   $templateplain="Dear {$toname},"."\r\n"." Thank you for your subscription. "."\r\n";
   $templateplain.="You can sign in to the site with the following URL"."\r\n";
   $templateplain.="www.twitjix.com/index.php"."\r\n";
   $templateplain.="Please provide your twitter username and pasword for login."."\r\n";
   break;
    }

//for sending html mail

$headers = 'From:'.$fromaddress. "\r\n" .
    'Reply-To: '.$fromaddress. "\r\n" .
    'X-Mailer: PHP/'.phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$body="<html><body  background=\"background/default.png\">".$template."<br/><br/><br/></body></html>";

//for sending text mail

$headerstxt = 'From:'.$fromaddress. "\r\n" .
    'Reply-To: '.$fromaddress."\r\n" .
    'X-Mailer: PHP/'.phpversion();
$headerstxt .= "Content-type: Text/plain; charset=ISO-8859-1\r\n"; 
$bodytxt=$templateplain;
if(mail($to, $subject, $bodytxt, $headerstxt)){
 // mail($to, $subject, $body, $headers);
	return "mail sent";
}else{
	return "mail not sent";
}
}
?>
