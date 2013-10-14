<style type="text/css">
.new_txtbx_01 {
	padding:2px 0 2px 2px;
	width:238px;
	height:20px;
	background-color:#fff;
	border:1px solid #3B6F80;
	color:#193842;
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.inner_dropdown {
	padding:1px 0 2px 2px;
	width:238px;
	height:19px;
	background-color:#fff;
	border:1px solid #3B6F80;
	color:#193842;
	font-size:12px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.sub_lbl {
	float:left;
	padding:0 0 0 70px;
	width:200px;
	font-size:14px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.sub_heading {
	float:left;
	padding:0 0 0 150px;
	width:auto;
	font-size:16px;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
</style>
<link href="../css/home.css" rel="stylesheet" type="text/css" />
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<!--<script type='text/javascript' src='../js/basic_pop.js'></script>-->
<script type="text/javascript" src='../js/DD_belatedPNG_0.0.7a-min.js'></script>
<script>
DD_belatedPNG.fix('img, div, li');
</script>
<script language="javascript">
function closefun()
{
window.top.location.href="http://www.twitjix.com/user/index";
}
function opentutorial()
{
window.top.location.href="http://www.twitjix.com/user/tutorial";
}
</script>
<?php 
include('openinviter.php');
$inviter=new OpenInviter();
$phpdate = date('Y-m-d H:i:s');
$oi_services=$inviter->getPlugins();
if (isset($_REQUEST['result']))
{
		$contents="<div style='padding:20px; width:550px;'>
									   <div style='text-align:center;'><img src='../images/twitacc_logo.png' alt=''></div>
									   <div style='padding:20px 0 0 0;'>";
									   
		$contents.="<div class='sub_heading'><center><strong>You are ready to start now. <br/><br/>Want to take a look at our tutorials first?<br/><br/><a href='#' onclick='opentutorial()' style='text-decoration:none'> <input  type='button' class='inner_txtbtn_01' value='Yes!'></a> &nbsp;<a href='#' onclick='closefun()' style='text-decoration:none'> <input  type='button' class='inner_txtbtn_01' value='No Thanks!'></a></strong></center></div>		
					
			<div style='clear:both;'></div></div></div>";
			echo $contents;
			exit;
		}
if (isset($_POST['provider_box'])) 
{
	if (isset($oi_services['email'][$_POST['provider_box']])) $plugType='email';
	elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType='social';
	else $plugType='';
}
else $plugType = '';
function ers($ers)
	{
	if (!empty($ers))
		{
		$contents="<div style='padding:10px; width:550px;text-align:center;color:red'>";
		foreach ($ers as $key=>$error)
			$contents.="{$error}<br >";
		$contents.="</div>";
		return $contents;
		}
	}
	
function oks($oks)
	{
	if (!empty($oks))
		{
		$contents="<div style='padding:20px; width:550px;'>
						           <div style='text-align:center;'><img src='../images/twitacc_logo.png' alt=''></div>
						           <div style='padding:20px 0 0 0;'>";
							       
		//$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center'><tr><td valign='middle' valign='middle'><img src='images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
		foreach ($oks as $key=>$msg)
			$contents.="{$msg}<br >";
			
			$contents.="</div>";
	//	$contents.="</td></tr></table><br >";
		return $contents;
		}
	}
if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';
$ers=array();$oks=array();$import_ok=false;$done=false;
if ($_SERVER['REQUEST_METHOD']=='POST')
	{
	if ($step=='get_contacts')
		{
		if (empty($_POST['email_box']))
			$ers['email']="Email missing !";
		if (empty($_POST['password_box']))
			$ers['password']="Password missing !";
		if (empty($_POST['provider_box']))
			$ers['provider']="Provider missing !";
		if (count($ers)==0)
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal)
				$ers['inviter']=$internal;
			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
				{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
				}
			elseif (false===$contacts=$inviter->getMyContacts())
				$ers['contacts']="Unable to get contacts !";
			else
				{
				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
		if (empty($_POST['provider_box'])) $ers['provider']='Provider missing !';
		else
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal) $ers['internal']=$internal;
			else
				{
				if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing !';
				if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session !';
				if (empty($_POST['message_box'])) $ers['message_body']='Message missing !';
				else $_POST['message_box']=strip_tags($_POST['message_box']);
				$selected_contacts=array();$contacts=array();
				$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\nMessage: \n\r".$_POST['message_box']);
				if ($inviter->showContacts())
					{
					foreach ($_POST as $key=>$val)
						if (strpos($key,'check_')!==false)
							$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
						elseif (strpos($key,'email_')!==false)
							{
							$temp=explode('_',$key);$counter=$temp[1];
							if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
							}
					if (count($selected_contacts)==0) $ers['contacts']="You haven't selected any contacts to invite !";
					}
				}
			}
	
		if (count($ers)==0)
			{
			$sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
			$inviter->logout();
			if ($sendMessage===-1)
				{
				//$message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
				$message_subject=$_POST['email_box'].$message['subject'];
				$message_body=$message['body'].$message['attachment'].$message_footer; 
				$headers="From: {$_POST['email_box']}";
				include_once '../common/dbconfig.php';
				include_once '../classes/dbClient.php';
				include_once '../common/sqlFunctions.php';
				include_once '../classes/dbClient.php';
				db_connect();
				$username=$_REQUEST['username'];
				foreach ($selected_contacts as $email=>$name)
				{
					mail($email,$message_subject,$message_body,$headers);
					$query ="INSERT INTO `ta_invitation_history` (`ih_username` , `ih_email` , `ih_date` ) VALUES ('$username', '$email','$phpdate')";
					mysql_query($query);
				}
				db_close();
				$oks['mails']="<div class='sub_heading'><center><strong>You are ready to start now. <br>Want to take a look at our tutorials first?<br/><br/><a href='#' onclick='opentutorial()' style='text-decoration:none'> <input  type='button' class='inner_txtbtn_01' value='Yes!'></a> &nbsp;<a href='#' onclick='closefun()' style='text-decoration:none'> <input  type='button' class='inner_txtbtn_01' value='No Thanks!'></a></strong></center></div>		
						
						    <div style='clear:both;'></div></div></div>";
							
				}
			elseif ($sendMessage===false)
				{
				$internal=$inviter->getInternalError();
				$ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
				}
			else $oks['internal']="Invites sent successfully!";
			$done=true;
			}
		}
	}
else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
		}
$contents="<script type='text/javascript'>
	function toggleAll(element) 
	{
	var form = document.forms.openinviter, z = 0;
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
</script>";
$contents.="<body><form action='' method='POST' name='openinviter'>".ers($ers).oks($oks);
if (!$done)
	{
	if ($step=='get_contacts')
		{
		$contents.="<div style='padding:20px; width:550px;'>
						<div style='text-align:center;'><img src='../images/twitacc_logo.png' alt=''></div>
						<div style='padding:20px 0 0 0;'>
								<div class='sub_heading'>Do you want to invite your friends to twitjix.com?</div>
								<div style='clear:both;'></div>
							</div>
							<div style='padding:20px 0 0 0;'>
								<div class='sub_lbl'>Email: &nbsp;</div>
								<div style='float:left;'><input class='new_txtbx_01' type='text' name='email_box' value='{$_POST['email_box']}'></div>
								<div style='clear:both;'></div>
							</div>
							<div style='padding:10px 0 0 0;'>
								<div class='sub_lbl'>Password: &nbsp;</div>
								<div style='float:left;'><input  class='new_txtbx_01' type='password' name='password_box' value='{$_POST['password_box']}'></div>
								<div style='clear:both;'></div>
							</div>
							<div style='padding:10px 0 0 0;'>
							<div class='sub_lbl'>Email provider: &nbsp;</div>
							<div style='float:left;'><select  class='inner_dropdown' name='provider_box'><option value=''></option>";
		foreach ($oi_services as $type=>$providers)	
			{
			$contents.="<optgroup label='{$inviter->pluginTypes[$type]}'>";
			foreach ($providers as $provider=>$details)
				$contents.="<option value='{$provider}'".($_POST['provider_box']==$provider?' selected':'').">{$details['name']}</option>";
			$contents.="</optgroup>";
			}
		$contents.="</select></div><div style='clear:both;'></div></div>
		<div style='text-align:center; padding:20px 10px 0 0;'><input  class='inner_txtbtn_01' type='submit' name='import' value='Import Contacts'></div><div  style='text-align:center; padding:20px 10px 0 0;'><a href='inviter.php?result=1'><input  type='button' name='skip1' class='inner_txtbtn_01' value='Skip'></a></div>
	<input type='hidden' name='step' value='get_contacts'>";
				}
	else
		$contents.="<div style='padding:20px; width:550px;'>
						<div style='text-align:center;'><img src='../images/twitacc_logo.png' alt=''></div>
						<div style='padding:20px 0 0 0;'>
						<div>Message: &nbsp;</div>
						<div style='float:left;'><textarea  name='message_box' class='home_tweetslefttxtarea' >{$_POST['message_box']}</textarea></div>
					     <div style='clear:both;'></div>
						</div>";
	
	}
//$contents.="<center><a href='http://openinviter.com/'><img src='http://openinviter.com/images/banners/banner_blue_1.gif' border='0' alt='Powered by OpenInviter.com' title='Powered by OpenInviter.com'></a></center>";
if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
			{
			$contents.="<div style='padding:20px 0 0 0;'><div style='float:left;'>Your contacts</div></div>";
			if (count($contacts)==0)
				$contents.="<table class='thTable' align='center' cellspacing='0' cellpadding='0'><tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='".($plugType=='email'? "3":"2")."'>You do not have any contacts in your address book.</td></tr>";
			else
				{
				$contents.="<div style='padding:20px 0 0 0;'><div style='float:left;'><input type='checkbox' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked>All?</div> <div style='clear:both;'></div></div><table class='thTable' align='center' cellspacing='0' cellpadding='0'><tr class='thTableDesc'><td>&nbsp;</td><td>Name</td>".($plugType == 'email' ?"<td>E-mail</td>":"")."</tr>";
				$odd=true;$counter=0;
				foreach ($contacts as $email=>$name)
					{
					$counter++;
					if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					$contents.="<tr class='{$class}'><td><input name='check_{$counter}' value='{$counter}' type='checkbox'  checked><input type='hidden' name='email_{$counter}' value='{$email}'><input type='hidden' name='name_{$counter}' value='{$name}'></td><td>{$name}</td>".($plugType == 'email' ?"<td>{$email}</td>":"")."</tr>";
					$odd=!$odd;
					}
									}
			$contents.="</table>";
			$contents.="<div style='text-align:center; padding:20px 0 0 0;'><input type='submit' name='send' value='Send invites' class='inner_txtbtn_01'></div><div  style='text-align:center; padding:20px 10px 0 0;'><a href='inviter.php?result=1'><input  type='button' name='skip1' class='inner_txtbtn_01' value='Skip'></a></div></div>";
			}
		$contents.="<input type='hidden' name='step' value='send_invites'>
			<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
		}
	}
$contents.="</form></body>";
echo $contents;
?>